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

    public $project_id = null; // ID Project yang sedang diedit

    // --- 1. DATA HEADER (Form Atas) ---
    public $spk_number;
    public $wbs_number;
    public $project_name;
    public $vendor_name;
    public $location;
    public $contract_value;
    public $contract_start_date;
    public $contract_end_date;
    public $target_completion_date;
    public $bastp_date;
    public $slo_date;
    public $progress_percent = 0;
    public $constraint_note;

    // --- 2. DATA MATERIAL (Tabel Tengah) ---
    public $material_inputs = [];

    // --- 3. DATA DOKUMEN (Form Bawah) ---
    public $doc_type;
    public $doc_file;

    // --- 4. Dropdown Options ---
    public $availableProjects = [];

    public function mount()
    {
        // Load semua project yang tersedia untuk dropdown SPK
        $this->availableProjects = Projects::select('id', 'spk_number', 'wbs_number', 'project_name', 'vendor_name')
            ->orderBy('spk_number')
            ->get();
    }

    // Ketika user memilih SPK Number
    public function updatedSpkNumber($value)
    {
        if (empty($value)) {
            $this->resetProjectData();
            return;
        }

        // Cari project berdasarkan spk_number
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
        $this->contract_start_date = $project->contract_start_date?->format('Y-m-d');
        $this->contract_end_date = $project->contract_end_date?->format('Y-m-d');
        $this->target_completion_date = $project->target_completion_date;
        $this->bastp_date = $project->bastp_date?->format('Y-m-d');
        $this->slo_date = $project->slo_date?->format('Y-m-d');
        $this->progress_percent = $project->progress_percent ?? 0;
        $this->constraint_note = $project->constraint_note;

        // Load material items
        $this->loadMaterialItems();
    }

    protected function loadMaterialItems()
    {
        $this->material_inputs = [];

        // Ambil material issues untuk project ini
        $materialIssues = MaterialIssues::where('project_id', $this->project_id)
            ->with(['items.material'])
            ->get();

        foreach ($materialIssues as $issue) {
            foreach ($issue->items as $item) {
                $this->material_inputs[$item->id] = [
                    'material_name' => $item->material->name ?? 'N/A',
                    'material_code' => $item->material->code ?? 'N/A',
                    'quantity_sap' => $item->quantity_sap,
                    'wbs_element' => $item->wbs_element,
                    'quantity_installed' => $item->quantity_installed,
                    'asset_number' => $item->asset_number,
                    'remarks' => $item->remarks,
                ];
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
        $this->target_completion_date = null;
        $this->bastp_date = null;
        $this->slo_date = null;
        $this->progress_percent = 0;
        $this->constraint_note = null;
        $this->material_inputs = [];
    }

    // Fungsi Save Header & Material
    public function saveProgress()
    {
        if (!$this->project_id) {
            session()->flash('error', 'Silakan pilih SPK Number terlebih dahulu!');
            return;
        }

        // 1. Simpan Header Project
        $project = Projects::find($this->project_id);
        $project->update([
            'location' => $this->location,
            'contract_value' => $this->contract_value,
            'contract_start_date' => $this->contract_start_date,
            'contract_end_date' => $this->contract_end_date,
            'target_completion_date' => $this->target_completion_date,
            'bastp_date' => $this->bastp_date,
            'slo_date' => $this->slo_date,
            'progress_percent' => $this->progress_percent,
            'constraint_note' => $this->constraint_note,
            'status' => 'OPEN'
        ]);

        // 2. Simpan Loop Material (Banyak Baris)
        foreach ($this->material_inputs as $itemId => $data) {
            MaterialIssuesItems::where('id', $itemId)->update([
                'quantity_installed' => $data['quantity_installed'],
                'asset_number' => $data['asset_number'] ?? null,
                'remarks' => $data['remarks'] ?? null,
            ]);
        }

        session()->flash('message', 'Progress berhasil disimpan!');
    }

    // Fungsi Upload Dokumen
    public function uploadDocument()
    {
        if (!$this->project_id) {
            session()->flash('error', 'Silakan pilih SPK Number terlebih dahulu!');
            return;
        }

        $this->validate([
            'doc_type' => 'required',
            'doc_file' => 'required|file|max:10240',
        ]);

        // Simpan File
        $path = $this->doc_file->store('project_docs/' . $this->spk_number);

        ProjectDocuments::create([
            'project_id' => $this->project_id,
            'document_type' => $this->doc_type,
            'file_path' => $path,
            'original_filename' => $this->doc_file->getClientOriginalName(),
            'uploaded_by' => auth()->id,
        ]);

        $this->reset(['doc_type', 'doc_file']);
        session()->flash('message', 'Dokumen berhasil diupload!');
    }

    public function render()
    {
        $documents = [];
        if ($this->project_id) {
            $documents = ProjectDocuments::where('project_id', $this->project_id)->get();
        }

        return view('livewire.konstruksi.my-take-list', [
            'documents' => $documents,
        ]);
    }
}
