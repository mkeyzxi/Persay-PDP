<?php

namespace App\Livewire\Konstruksi;

use Livewire\Component;
use App\Models\Projects;
use Livewire\WithFileUploads;
use App\Models\MaterialIssues;

use App\Models\ProjectDocuments;
use App\Models\MaterialIssuesItems;

class OriginalWork extends Component
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
    public $bastp_date;

    //variabel finish project
    public $selisih;
    public bool $finish_project = false;
    // --- 2. DATA MATERIAL (Tabel Tengah) ---
    public $material_inputs = [];



    // --- 4. Dropdown Options ---
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
        $this->bastp_date = $project->bastp_date ? \Carbon\Carbon::parse($project->bastp_date)->format('Y-m-d') : null;

        $this->loadMaterialItems();
    }

    protected function loadMaterialItems()
    {
        $this->material_inputs = [];
        $this->selisih = 0;
        $materialIssues = MaterialIssues::where('project_id', $this->project_id)
            ->with(['items.material'])
            ->get();

        foreach ($materialIssues as $issue) {
            foreach ($issue->items as $item) {
                $quantitySap = $item->quantity_sap ?? 0;
                $quantityInstalled = $item->quantity_installed ?? 0;
                $selisih = $quantitySap - $quantityInstalled;
                $this->selisih += $selisih;
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
                    'approval_status' => $item->approval_status,
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
                // dd($this->material_inputs[$itemId]['selisih']);
                $this->selisih = collect($this->material_inputs)
                    ->sum(fn($item) => $item['selisih']);
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
        $this->bastp_date = null;
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
            'proggress_percent' => $this->proggress_percent,
            'bastp_date' => $this->bastp_date,
            'status' => 'OPEN'
        ]);

        foreach ($this->material_inputs as $itemId => $data) {
            MaterialIssuesItems::where('id', $itemId)->update([
                'quantity_installed' => $data['quantity_installed'],
                'asset_number' => $data['asset_number'] ?? null,
                'remarks' => $data['remarks'] ?? null,
                'approval_status' => 'process',
            ]);
        }

        session()->flash('message', 'Progress berhasil disimpan!');
    }




    public function render()
    {
        $uploadedDocuments = collect();
        if ($this->project_id) {
            $uploadedDocuments = ProjectDocuments::where('project_id', $this->project_id)->get();
        }

        return view('livewire.konstruksi.original-work', [
            'uploadedDocuments' => $uploadedDocuments,
        ]);
    }
}
