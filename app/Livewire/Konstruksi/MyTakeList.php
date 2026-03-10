<?php

namespace App\Livewire\Konstruksi;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Projects;
use App\Models\MaterialIssues;
use App\Models\MaterialIssuesItems;
use App\Models\ProjectDocuments;

class MyTakeList extends Component
{
    use WithFileUploads;

    public $project_id = null;

    // --- 1. DATA HEADER (Form Atas) ---
    public $spk_number;
    public $wbs_number;
    public $project_name;
    public $vendor_name;
    public $location;
    public $contract_value;
    public $contract_start_date;
    public $contract_end_date;
    public $category;
    public $pdp_category;
    public $proggress_percent = 0;
    public $follow_up_code;
    public $target_completion_date;
    public $constraint_note;
    public $slo_date;
    public $quantitySap;


    // --- 2. DATA MATERIAL (Tabel Tengah) ---
    public $material_inputs = [];

    // --- 3. DATA DOKUMEN (Form Bawah) ---
    public $doc_type;
    public $doc_file;

    // --- 4. PDF Preview ---
    public $previewDocUrl = null;
    public $previewDocName = null;

    // --- 5. Dropdown Options ---
    public $availableProjects = [];

    public function mount()
    {
        $this->availableProjects = Projects::select('id', 'spk_number', 'wbs_number', 'project_name', 'vendor_name')
            ->orderBy('spk_number')
            ->get();
    }

    public function updatedSpkNumber($value)
    {
        if (empty($value)) {
            $this->resetProjectData();
            return;
        }

        $project = Projects::where('spk_number', $value)->first();

        if ($project) {
            $this->loadProjectData($project);
        } else {
            $this->resetProjectData();
        }

        // Reset form dokumen saat ganti SPK
        $this->reset(['doc_type', 'doc_file']);
    }

    protected function loadProjectData($project)
    {
        $this->project_id = $project->id;
        $this->wbs_number = $project->wbs_number;
        $this->project_name = $project->project_name;
        $this->vendor_name = $project->vendor_name;
        $this->location = $project->location;
        $this->contract_value = $project->contract_value;
        $this->contract_start_date = $project->contract_start_date ? \Carbon\Carbon::parse($project->contract_start_date)->format('Y-m-d') : null;
        $this->contract_end_date = $project->contract_end_date ? \Carbon\Carbon::parse($project->contract_end_date)->format('Y-m-d') : null;
        $this->category = $project->category ?? null;
        $this->pdp_category = $project->pdp_category;
        $this->proggress_percent = $project->proggress_percent;
        $this->follow_up_code = $project->follow_up_code;
        $this->target_completion_date = $project->target_completion_date ? \Carbon\Carbon::parse($project->target_completion_date)->format('Y-m-d') : null;
        $this->constraint_note = $project->constraint_note;
        $this->slo_date = $project->slo_date ? \Carbon\Carbon::parse($project->slo_date)->format('Y-m-d') : null;

        $this->loadMaterialItems();
    }

    protected function loadMaterialItems()
    {
        $this->material_inputs = [];

        $materialIssues = MaterialIssues::where('project_id', $this->project_id)
            ->with(['items.material'])
            ->get();

        foreach ($materialIssues as $issue) {
            foreach ($issue->items as $item) {
                $quantitySap = $item->quantity_sap ?? 0;
                $quantityInstalled = $item->quantity_installed ?? 0;
                $selisih = $quantitySap - $quantityInstalled;

                $this->material_inputs[$item->id] = [
                    'posting_date' => $issue->posting_date?->format('Y-m-d'),
                    'sap_doc_no' => $issue->sap_doc_no,
                    'material_code' => $item->material->sap_material_code ?? 'N/A',
                    'material_name' => $item->material->material_description ?? 'N/A',
                    'quantity_sap' => $quantitySap,
                    'quantity_installed' => $quantityInstalled,
                    'selisih' => $selisih,
                    'val_currency' => $item->val_currency ?? 0,
                    'wbs_element' => $item->wbs_element,
                    'asset_number' => $item->asset_number,
                    'remarks' => $item->remarks,
                    'approval_status' => $item->approval_status ?? 'initial',
                ];
            }
        }
    }

    public function updatedMaterialInputs($value, $key)
    {
        $parts = explode('.', $key);
        if (count($parts) >= 2) {
            $itemId = $parts[0];
            $field = $parts[1] ?? null;

            if ($field === 'quantity_installed' && isset($this->material_inputs[$itemId])) {
                $quantitySap = $this->material_inputs[$itemId]['quantity_sap'] ?? 0;
                $this->material_inputs[$itemId]['selisih'] = $quantitySap - floatval($value);
            }
        }
    }

    protected function resetProjectData()
    {
        $this->project_id = null;
        $this->wbs_number = null;
        $this->project_name = null;
        $this->vendor_name = null;
        $this->location = null;
        $this->contract_value = null;
        $this->contract_start_date = null;
        $this->contract_end_date = null;
        $this->category = null;
        $this->pdp_category = null;
        $this->proggress_percent = 0;
        $this->follow_up_code = null;
        $this->target_completion_date = null;
        $this->constraint_note = null;
        $this->slo_date = null;
        $this->material_inputs = [];
    }

    public function saveProgress()
    {
        if (!$this->project_id) {
            session()->flash('error', 'Silakan pilih SPK Number terlebih dahulu!');
            return;
        }

        $project = Projects::find($this->project_id);
        $project->update([
            'project_name' => $this->project_name,
            'vendor_name' => $this->vendor_name,
            'location' => $this->location,
            'contract_value' => $this->contract_value,
            'contract_start_date' => $this->contract_start_date,
            'contract_end_date' => $this->contract_end_date,
            'category' => $this->category,
            'pdp_category' => $this->pdp_category,
            'proggress_percent' => $this->proggress_percent,
            'follow_up_code' => $this->follow_up_code,
            'target_completion_date' => $this->target_completion_date,
            'constraint_note' => $this->constraint_note,
            'slo_date' => $this->slo_date,
            'status' => 'OPEN'
        ]);

        foreach ($this->material_inputs as $itemId => $data) {
            // Determine approval_status:
            // 1. If asset_number is filled → 'approved'
            // 2. If still 'initial' and quantity_installed is changed → 'process'
            // 3. Otherwise keep current status
            $currentStatus = $data['approval_status'] ?? 'initial';
            $assetNumber = trim($data['asset_number'] ?? '');

            if (!empty($assetNumber)) {
                $newStatus = 'approved';
            } elseif ($currentStatus === 'initial') {
                $newStatus = 'process';
            } else {
                $newStatus = $currentStatus;
            }

            MaterialIssuesItems::where('id', $itemId)->update([
                'quantity_installed' => $data['quantity_installed'],
                'asset_number' => !empty($assetNumber) ? $assetNumber : null,
                'approval_status' => $newStatus,
            ]);

            // Update the local array so the UI reflects the change immediately
            $this->material_inputs[$itemId]['approval_status'] = $newStatus;
        }

        session()->flash('message', 'Progress berhasil disimpan!');
    }

    public function uploadDocument()
    {
        // dd([
        //     'project_id' => $this->project_id,
        //     'doc_type' => $this->doc_type,
        //     'file' => $this->doc_file,
        //     'user_id' => auth()->id(),
        // ]);

        if (!$this->project_id) {
            session()->flash('error', 'Silakan pilih SPK Number terlebih dahulu!');
            return;
        }

        $this->validate([
            'doc_type' => 'required',
            'doc_file' => 'required|file|max:10240',
        ]);

        $path = $this->doc_file->store(
            'project_docs/' . $this->spk_number,
            'public'
        );

        ProjectDocuments::create([
            'project_id' => $this->project_id,
            'document_type' => $this->doc_type,
            'file_path' => $path,
            'original_filename' => $this->doc_file->getClientOriginalName(),
            'uploaded_by' => auth()->id(), // tidak error
            'uploaded_at' => now(),
        ]);

        $this->reset(['doc_type', 'doc_file']);
        session()->flash('message', 'Dokumen berhasil diupload!');
    }


    public function previewDocument($docId)
    {
        $doc = ProjectDocuments::find($docId);
        if ($doc) {
            $this->previewDocUrl = asset('storage/' . $doc->file_path);
            $this->previewDocName = $doc->original_filename;
        }
    }

    public function closePreview()
    {
        $this->previewDocUrl = null;
        $this->previewDocName = null;
    }

    public function render()
    {
        $uploadedDocuments = collect();
        if ($this->project_id) {
            $uploadedDocuments = ProjectDocuments::where('project_id', $this->project_id)->get();
        }

        return view('livewire.konstruksi.my-take-list', [
            'uploadedDocuments' => $uploadedDocuments,
        ]);
    }
}
