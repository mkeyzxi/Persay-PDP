<?php

namespace App\Livewire\Akuntansi;

use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProjectExecutionImport;

class ProjectExecution extends Component
{
    use WithFileUploads;

    /**
     * File Excel dari user
     */
    public $executionFile;

    /**
     * Validasi file upload
     */
    protected function rules()
    {
        return [
            'executionFile' => 'required|mimes:xlsx,xls,csv|max:10240', // max 10MB
        ];
    }

    /**
     * Proses upload & import Excel
     */
    public function uploadExecution()
    {
        $this->validate();

        try {
            $import = new ProjectExecutionImport();

            Excel::import($import, $this->executionFile);

            /**
             * Jika tidak ada project yang cocok
             */
            if (!$import->projectFound()) {
                session()->flash(
                    'error',
                    'Project yang sesuai dengan dokumen yang Anda kirimkan tidak ditemukan.'
                );
            } else {
                session()->flash(
                    'success',
                    'Data Project Execution berhasil diperbarui.'
                );
            }

            // Reset file input
            $this->reset('executionFile');

        } catch (\Exception $e) {
            session()->flash(
                'error',
                'Gagal memproses file: ' . $e->getMessage()
            );
        }
    }

    /**
     * Render halaman
     */
    public function render()
    {
        return view('livewire.akuntansi.project-execution');
    }
}
