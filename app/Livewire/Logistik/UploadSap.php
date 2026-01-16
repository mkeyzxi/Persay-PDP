<?php

namespace App\Livewire\Logistik;

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
            Excel::import(new SapImport, $this->sapFile);
            $this->reset('sapFile');
            session()->flash('success', 'Data SAP berhasil diimport dari Excel! 🎉');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.logistik.upload-sap');
    }
}
