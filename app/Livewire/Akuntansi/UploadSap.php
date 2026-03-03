<?php

namespace App\Livewire\Akuntansi;

use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SapImport;
use Livewire\WithFileUploads;

class UploadSap extends Component
{
    use WithFileUploads;

    public $sapFile;

    protected function rules()
    {
        return [
            'sapFile' => 'required|mimes:xlsx,xls,csv',
        ];
    }

    public function uploadSap()
    {
        $this->validate();

        try {
            $importer = new SapImport;
            Excel::import($importer, $this->sapFile);
            $this->reset('sapFile');
            session()->flash('success', $importer->getSummary());
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.akuntansi.upload-sap');
    }
}
