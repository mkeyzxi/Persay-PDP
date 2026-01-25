<?php

namespace App\Livewire\Akuntansi;

use App\Models\Projects;
use App\Models\MaterialIssues;
use App\Models\MaterialIssuesItems;
use App\Models\Material;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ManualInput extends Component
{
    // Active Tab: 'project', 'material_issue', 'material', 'item'
    public $activeTab = 'project';

    // ========================================
    // PROJECT TAB
    // ========================================
    public $project_mode = 'new'; // 'new' or 'existing'
    public $selected_project_id;
    public $spk_number;
    public $wbs_number;
    public $project_name;
    public $vendor_name;
    public $unit_code;
    public $fiscal_year;

    // ========================================
    // MATERIAL ISSUE TAB
    // ========================================
    public $mi_project_mode = 'existing'; // 'new_project' or 'existing'
    public $mi_selected_project_id;
    // For new project within MI
    public $mi_spk_number;
    public $mi_wbs_number;
    public $mi_project_name;
    public $mi_vendor_name;
    public $mi_unit_code;
    public $mi_fiscal_year;
    // MI fields
    public $sap_doc_no;
    public $posting_date;
    public $header_text;
    // Include items toggle
    public $mi_include_items = false;
    public $mi_item_mode = 'existing_material'; // 'existing_material', 'new_material'
    public $mi_material_id;
    public $mi_new_material_code;
    public $mi_new_material_desc;
    public $mi_new_material_uom;
    public $mi_new_material_category;
    public $mi_quantity_sap;
    public $mi_val_currency;
    public $mi_item_wbs_element;

    // ========================================
    // MATERIAL TAB
    // ========================================
    public $material_mode = 'new'; // 'new', 'edit', 'add_to_mi'
    public $selected_material_id;
    public $material_code;
    public $material_desc;
    public $material_uom;
    public $material_category;
    // For add_to_mi mode
    public $mat_selected_mi_id;
    public $mat_quantity_sap;
    public $mat_val_currency;
    public $mat_wbs_element;

    // ========================================
    // ITEM TAB
    // ========================================
    public $item_mi_mode = 'existing_mi'; // 'existing_mi', 'new_mi'
    public $item_selected_mi_id;
    // For new MI
    public $item_selected_project_id;
    public $item_sap_doc_no;
    public $item_posting_date;
    public $item_header_text;
    // Item fields
    public $item_material_mode = 'existing'; // 'existing', 'new'
    public $item_material_id;
    public $item_new_material_code;
    public $item_new_material_desc;
    public $item_new_material_uom;
    public $item_new_material_category;
    public $item_quantity_sap;
    public $item_val_currency;
    public $item_wbs_element;

    // ========================================
    // DROPDOWN DATA
    // ========================================
    public $projects = [];
    public $materialIssues = [];
    public $materials = [];

    public function mount()
    {
        $this->loadDropdowns();
    }

    protected function loadDropdowns()
    {
        $this->projects = Projects::orderBy('spk_number')->get();
        $this->materialIssues = MaterialIssues::with('project')->orderBy('sap_doc_no')->get();
        $this->materials = Material::orderBy('material_description')->get();
    }

    public function updatedActiveTab()
    {
        $this->resetValidation();
        $this->loadDropdowns();
    }

    public function updatedMiSelectedProjectId($value)
    {
        if ($value) {
            $this->materialIssues = MaterialIssues::where('project_id', $value)
                ->with('project')
                ->orderBy('sap_doc_no')
                ->get();
        }
    }

    public function updatedItemSelectedProjectId($value)
    {
        if ($value) {
            $this->materialIssues = MaterialIssues::where('project_id', $value)
                ->with('project')
                ->orderBy('sap_doc_no')
                ->get();
        }
    }

    // ========================================
    // SAVE METHODS
    // ========================================

    public function saveProject()
    {
        $rules = [
            'spk_number'   => 'required|string|max:100',
            'wbs_number'   => 'nullable|string|max:100',
            'project_name' => 'nullable|string|max:255',
            'vendor_name'  => 'nullable|string|max:255',
            'unit_code'    => 'nullable|string|max:50',
            'fiscal_year'  => 'nullable|integer|min:2000|max:2100',
        ];

        $this->validate($rules);

        try {
            Projects::firstOrCreate(
                ['spk_number' => $this->spk_number],
                [
                    'wbs_number'   => $this->wbs_number,
                    'project_name' => $this->project_name,
                    'vendor_name'  => $this->vendor_name,
                    'unit_code'    => $this->unit_code,
                    'fiscal_year'  => $this->fiscal_year,
                    'status'       => 'DRAFT',
                    'created_by'   => Auth::id(),
                ]
            );

            $this->reset(['spk_number', 'wbs_number', 'project_name', 'vendor_name', 'unit_code', 'fiscal_year']);
            $this->loadDropdowns();
            session()->flash('success', 'Project berhasil disimpan!');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function saveMaterialIssue()
    {
        $rules = [
            'sap_doc_no'   => 'required|string|max:100',
            'posting_date' => 'required|date',
            'header_text'  => 'nullable|string|max:500',
        ];

        if ($this->mi_project_mode === 'existing') {
            $rules['mi_selected_project_id'] = 'required|exists:projects,id';
        } else {
            $rules['mi_spk_number']   = 'required|string|max:100';
            $rules['mi_wbs_number']   = 'nullable|string|max:100';
            $rules['mi_project_name'] = 'nullable|string|max:255';
        }

        if ($this->mi_include_items) {
            $rules['mi_quantity_sap'] = 'required|numeric|min:0';
            $rules['mi_val_currency'] = 'nullable|numeric|min:0';

            if ($this->mi_item_mode === 'existing_material') {
                $rules['mi_material_id'] = 'required|exists:materials,id';
            } else {
                $rules['mi_new_material_code'] = 'required|string|max:100';
                $rules['mi_new_material_desc'] = 'required|string|max:255';
            }
        }

        $this->validate($rules);

        try {
            DB::transaction(function () {
                // Determine project ID
                if ($this->mi_project_mode === 'existing') {
                    $projectId = $this->mi_selected_project_id;
                } else {
                    $project = Projects::firstOrCreate(
                        ['spk_number' => $this->mi_spk_number],
                        [
                            'wbs_number'   => $this->mi_wbs_number,
                            'project_name' => $this->mi_project_name,
                            'vendor_name'  => $this->mi_vendor_name,
                            'unit_code'    => $this->mi_unit_code,
                            'fiscal_year'  => $this->mi_fiscal_year,
                            'status'       => 'DRAFT',
                            'created_by'   => Auth::id(),
                        ]
                    );
                    $projectId = $project->id;
                }

                // Create Material Issue
                $materialIssue = MaterialIssues::create([
                    'project_id'   => $projectId,
                    'sap_doc_no'   => $this->sap_doc_no,
                    'posting_date' => $this->posting_date,
                    'header_text'  => $this->header_text,
                ]);

                // Create Item if included
                if ($this->mi_include_items) {
                    $materialId = $this->mi_material_id;

                    if ($this->mi_item_mode === 'new_material') {
                        $material = Material::firstOrCreate(
                            ['sap_material_code' => $this->mi_new_material_code],
                            [
                                'material_description' => $this->mi_new_material_desc,
                                'uom'                  => $this->mi_new_material_uom,
                                'category'             => $this->mi_new_material_category,
                            ]
                        );
                        $materialId = $material->id;
                    }

                    MaterialIssuesItems::create([
                        'material_issue_id' => $materialIssue->id,
                        'material_id'       => $materialId,
                        'quantity_sap'      => $this->mi_quantity_sap,
                        'val_currency'      => $this->mi_val_currency,
                        'wbs_element'       => $this->mi_item_wbs_element,
                    ]);
                }
            });

            $this->reset([
                'mi_selected_project_id',
                'mi_spk_number',
                'mi_wbs_number',
                'mi_project_name',
                'mi_vendor_name',
                'mi_unit_code',
                'mi_fiscal_year',
                'sap_doc_no',
                'posting_date',
                'header_text',
                'mi_include_items',
                'mi_material_id',
                'mi_new_material_code',
                'mi_new_material_desc',
                'mi_new_material_uom',
                'mi_new_material_category',
                'mi_quantity_sap',
                'mi_val_currency',
                'mi_item_wbs_element'
            ]);
            $this->loadDropdowns();

            $message = $this->mi_include_items
                ? 'Material Issue + Item berhasil disimpan!'
                : 'Material Issue berhasil disimpan!';
            session()->flash('success', $message);
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function saveMaterial()
    {
        $rules = [];

        if ($this->material_mode === 'new') {
            $rules = [
                'material_code'     => 'required|string|max:100|unique:materials,sap_material_code',
                'material_desc'     => 'required|string|max:255',
                'material_uom'      => 'nullable|string|max:20',
                'material_category' => 'nullable|string|max:100',
            ];
        } elseif ($this->material_mode === 'edit') {
            $rules = [
                'selected_material_id' => 'required|exists:materials,id',
                'material_code'        => 'required|string|max:100',
                'material_desc'        => 'required|string|max:255',
                'material_uom'         => 'nullable|string|max:20',
                'material_category'    => 'nullable|string|max:100',
            ];
        } elseif ($this->material_mode === 'add_to_mi') {
            $rules = [
                'selected_material_id' => 'required|exists:materials,id',
                'mat_selected_mi_id'   => 'required|exists:material_issues,id',
                'mat_quantity_sap'     => 'required|numeric|min:0',
                'mat_val_currency'     => 'nullable|numeric|min:0',
                'mat_wbs_element'      => 'nullable|string|max:100',
            ];
        }

        $this->validate($rules);

        try {
            if ($this->material_mode === 'new') {
                Material::create([
                    'sap_material_code'    => $this->material_code,
                    'material_description' => $this->material_desc,
                    'uom'                  => $this->material_uom,
                    'category'             => $this->material_category,
                ]);
                session()->flash('success', 'Material baru berhasil ditambahkan!');
            } elseif ($this->material_mode === 'edit') {
                $material = Material::find($this->selected_material_id);
                $material->update([
                    'sap_material_code'    => $this->material_code,
                    'material_description' => $this->material_desc,
                    'uom'                  => $this->material_uom,
                    'category'             => $this->material_category,
                ]);
                session()->flash('success', 'Material berhasil diupdate!');
            } elseif ($this->material_mode === 'add_to_mi') {
                MaterialIssuesItems::create([
                    'material_issue_id' => $this->mat_selected_mi_id,
                    'material_id'       => $this->selected_material_id,
                    'quantity_sap'      => $this->mat_quantity_sap,
                    'val_currency'      => $this->mat_val_currency,
                    'wbs_element'       => $this->mat_wbs_element,
                ]);
                session()->flash('success', 'Material berhasil ditambahkan ke Material Issue!');
            }

            $this->reset([
                'selected_material_id',
                'material_code',
                'material_desc',
                'material_uom',
                'material_category',
                'mat_selected_mi_id',
                'mat_quantity_sap',
                'mat_val_currency',
                'mat_wbs_element'
            ]);
            $this->loadDropdowns();
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function saveItem()
    {
        $rules = [
            'item_quantity_sap' => 'required|numeric|min:0',
            'item_val_currency' => 'nullable|numeric|min:0',
            'item_wbs_element'  => 'nullable|string|max:100',
        ];

        if ($this->item_mi_mode === 'existing_mi') {
            $rules['item_selected_mi_id'] = 'required|exists:material_issues,id';
        } else {
            $rules['item_selected_project_id'] = 'required|exists:projects,id';
            $rules['item_sap_doc_no']   = 'required|string|max:100';
            $rules['item_posting_date'] = 'required|date';
        }

        if ($this->item_material_mode === 'existing') {
            $rules['item_material_id'] = 'required|exists:materials,id';
        } else {
            $rules['item_new_material_code'] = 'required|string|max:100';
            $rules['item_new_material_desc'] = 'required|string|max:255';
        }

        $this->validate($rules);

        try {
            DB::transaction(function () {
                // Get or create Material Issue
                if ($this->item_mi_mode === 'existing_mi') {
                    $materialIssueId = $this->item_selected_mi_id;
                } else {
                    $materialIssue = MaterialIssues::create([
                        'project_id'   => $this->item_selected_project_id,
                        'sap_doc_no'   => $this->item_sap_doc_no,
                        'posting_date' => $this->item_posting_date,
                        'header_text'  => $this->item_header_text,
                    ]);
                    $materialIssueId = $materialIssue->id;
                }

                // Get or create Material
                if ($this->item_material_mode === 'existing') {
                    $materialId = $this->item_material_id;
                } else {
                    $material = Material::firstOrCreate(
                        ['sap_material_code' => $this->item_new_material_code],
                        [
                            'material_description' => $this->item_new_material_desc,
                            'uom'                  => $this->item_new_material_uom,
                            'category'             => $this->item_new_material_category,
                        ]
                    );
                    $materialId = $material->id;
                }

                // Create Item
                MaterialIssuesItems::create([
                    'material_issue_id' => $materialIssueId,
                    'material_id'       => $materialId,
                    'quantity_sap'      => $this->item_quantity_sap,
                    'val_currency'      => $this->item_val_currency,
                    'wbs_element'       => $this->item_wbs_element,
                ]);
            });

            $this->reset([
                'item_selected_mi_id',
                'item_selected_project_id',
                'item_sap_doc_no',
                'item_posting_date',
                'item_header_text',
                'item_material_id',
                'item_new_material_code',
                'item_new_material_desc',
                'item_new_material_uom',
                'item_new_material_category',
                'item_quantity_sap',
                'item_val_currency',
                'item_wbs_element'
            ]);
            $this->loadDropdowns();
            session()->flash('success', 'Item berhasil ditambahkan!');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function loadMaterialForEdit()
    {
        if ($this->selected_material_id) {
            $material = Material::find($this->selected_material_id);
            if ($material) {
                $this->material_code     = $material->sap_material_code;
                $this->material_desc     = $material->material_description;
                $this->material_uom      = $material->uom;
                $this->material_category = $material->category;
            }
        }
    }

    public function render()
    {
        return view('livewire.akuntansi.manual-input');
    }
}
