<?php

namespace App\Livewire\Logistik;

use App\Models\Projects;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SapImport;
use App\Models\MaterialIssues;
use App\Models\MaterialIssuesItems;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;

class UploadSap extends Component
{
    // upload via excel
    use WithFileUploads;
    public $sapFile;

    // Validation rules for Excel upload
    protected function rules()
    {
        return [
            'sapFile' => 'required|mimes:xlsx,xls,csv',
        ];
    }

    // Validation rules for manual form
    protected function manualRules()
    {
        return [
            // Project
            'spk_number'   => 'required|string|max:100',
            'wbs_number'   => 'nullable|string|max:100',
            'project_name' => 'nullable|string|max:255',
            'vendor_name'  => 'nullable|string|max:255',
            'unit_code'    => 'nullable|string|max:50',
            'fiscal_year'  => 'nullable|integer|min:2000|max:2100',
            // Material Issue
            'sap_doc_no'   => 'required|string|max:100',
            'posting_date' => 'required|date',
            'header_text'  => 'nullable|string|max:500',
            // Material Issue Item
            'quantity_sap'     => 'required|numeric|min:0',
            'val_currency'     => 'nullable|numeric|min:0',
            'item_wbs_element' => 'nullable|string|max:100',
        ];
    }

    public function uploadSap()
    {
        $this->validate();

        try {
            Excel::import(new SapImport, $this->sapFile);
            $this->reset('sapFile');
            session()->flash('success', 'Data SAP berhasil diimport dari Excel! 🎉');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    // PROJECT
    public $spk_number;
    public $wbs_number;
    public $project_name;
    public $vendor_name;
    public $unit_code;
    public $fiscal_year;

    // MATERIAL ISSUE (HEADER)
    public $sap_doc_no;
    public $posting_date;
    public $header_text;

    // MATERIAL ISSUE ITEM
    public $quantity_sap;
    public $val_currency;
    public $item_wbs_element;

    public function save()
    {
        $this->validate($this->manualRules());

        try {
            DB::transaction(function () {

                // 1️⃣ PROJECT
                $project = Projects::firstOrCreate(
                    ['spk_number' => $this->spk_number],
                    [
                        'wbs_number'   => $this->wbs_number,
                        'project_name' => $this->project_name,
                        'vendor_name'  => $this->vendor_name,
                        'unit_code'    => $this->unit_code,
                        'fiscal_year'  => $this->fiscal_year,
                        'status'       => 'DRAFT',
                        'created_by'   => \Illuminate\Support\Facades\Auth::id(),
                    ]
                );

                // 2️⃣ MATERIAL ISSUE (HEADER)
                $materialIssue = MaterialIssues::create([
                    'project_id'   => $project->id,
                    'sap_doc_no'   => $this->sap_doc_no,
                    'posting_date' => $this->posting_date,
                    'header_text'  => $this->header_text,
                ]);

                // 3️⃣ MATERIAL ISSUE ITEM
                MaterialIssuesItems::create([
                    'material_issue_id' => $materialIssue->id,
                    'quantity_sap'      => $this->quantity_sap,
                    'val_currency'      => $this->val_currency,
                    'wbs_element'       => $this->item_wbs_element,
                ]);
            });

            // Reset manual form fields
            $this->reset([
                'spk_number',
                'wbs_number',
                'project_name',
                'vendor_name',
                'unit_code',
                'fiscal_year',
                'sap_doc_no',
                'posting_date',
                'header_text',
                'quantity_sap',
                'val_currency',
                'item_wbs_element',
            ]);

            session()->flash('success', 'Data berhasil disimpan seperti SAP 🌱');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.logistik.upload-sap');
    }
}
