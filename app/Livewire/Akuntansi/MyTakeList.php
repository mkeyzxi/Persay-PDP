<?php

namespace App\Livewire\Akuntansi;

use Livewire\Component;
use App\Models\Projects;
use App\Models\MaterialIssues;
use App\Models\MaterialIssuesItems;
use App\Models\ProjectDocuments;

class MyTakeList extends Component
{
    public $project_id;

    // HEADER
    public $spk_number;
    public $wbs_number;
    public $project_name;
    public $vendor_name;
    public $location;
    public $contract_value;
    public $contract_start_date;
    public $contract_end_date;
    public $pdp_category;
    public $follow_up_code;
    public $target_completion_date;
    public $constraint_note;
    public $slo_date;

    // MATERIAL
    public $material_inputs = [];

    // OPTIONS
    public $availableProjects = [];

    public function mount()
    {
        $this->availableProjects = Projects::select(
            'id',
            'spk_number',
            'wbs_number',
            'project_name',
            'vendor_name'
        )
            ->orderBy('spk_number')
            ->get();
    }

    public function updatedSpkNumber($value)
    {
        if (!$value) {
            $this->resetProjectData();
            return;
        }

        $project = Projects::where('spk_number', $value)->first();

        $project
            ? $this->loadProjectData($project)
            : $this->resetProjectData();
    }

    protected function loadProjectData(Projects $project)
    {
        $this->project_id = $project->id;
        $this->wbs_number = $project->wbs_number;
        $this->project_name = $project->project_name;
        $this->vendor_name = $project->vendor_name;
        $this->location = $project->location;
        $this->contract_value = $project->contract_value;
        $this->contract_start_date = optional($project->contract_start_date)?->format('Y-m-d');
        $this->contract_end_date = optional($project->contract_end_date)?->format('Y-m-d');
        $this->pdp_category = $project->pdp_category;
        $this->follow_up_code = $project->follow_up_code;
        $this->target_completion_date = optional($project->target_completion_date)?->format('Y-m-d');
        $this->constraint_note = $project->constraint_note;
        $this->slo_date = optional($project->slo_date)?->format('Y-m-d');

        $this->loadMaterialItems();
    }

    protected function loadMaterialItems()
    {
        $this->material_inputs = [];

        $issues = MaterialIssues::where('project_id', $this->project_id)
            ->with('items.material')
            ->get();

        foreach ($issues as $issue) {
            foreach ($issue->items as $item) {
                $qtySap = $item->quantity_sap ?? 0;
                $qtyInstalled = $item->quantity_installed ?? 0;

                $this->material_inputs[$item->id] = [
                    'posting_date' => optional($issue->posting_date)?->format('Y-m-d'),
                    'sap_doc_no'   => $issue->sap_doc_no,
                    'material_code'=> optional($item->material)->sap_material_code ?? '-',
                    'material_name'=> optional($item->material)->material_description ?? '-',
                    'quantity_sap' => $qtySap,
                    'quantity_installed' => $qtyInstalled,
                    'selisih' => $qtySap - $qtyInstalled,
                    'val_currency' => $item->val_currency ?? 0,
                    'asset_number' => $item->asset_number,
                ];
            }
        }
    }

    public function updateMaterialItem($itemId)
    {
        if (!isset($this->material_inputs[$itemId])) {
            return;
        }

        MaterialIssuesItems::where('id', $itemId)->update([
            'asset_number' => $this->material_inputs[$itemId]['asset_number'],
            'asset_number_date' => now(),
        ]);

        session()->flash('message', "Asset number berhasil disimpan");
    }

    public function updateStatusProject()
    {
        if (!$this->project_id) return;

        $hasEmptyAsset = MaterialIssuesItems::whereHas('issue', fn ($q) =>
            $q->where('project_id', $this->project_id)
        )
            ->where(fn ($q) =>
                $q->whereNull('asset_number')->orWhere('asset_number', '')
            )
            ->exists();

        if ($hasEmptyAsset) {
            session()->flash('error', 'Masih ada asset number yang belum diisi.');
            return;
        }

        Projects::where('id', $this->project_id)
            ->update(['status' => 'CLOSED']);

        session()->flash('message', 'Project ditutup. Semua asset lengkap 🎯');
    }

    protected function resetProjectData()
    {
        $this->reset([
            'project_id',
            'wbs_number',
            'project_name',
            'vendor_name',
            'location',
            'contract_value',
            'contract_start_date',
            'contract_end_date',
            'pdp_category',
            'follow_up_code',
            'target_completion_date',
            'constraint_note',
            'slo_date',
            'material_inputs',
        ]);
    }

    public function render()
    {
        return view('livewire.akuntansi.my-take-list', [
            'uploadedDocuments' => $this->project_id
                ? ProjectDocuments::where('project_id', $this->project_id)->get()
                : collect(),
        ]);
    }
}
