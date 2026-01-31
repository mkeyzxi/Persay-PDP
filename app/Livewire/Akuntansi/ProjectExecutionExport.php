<?php

namespace App\Livewire\Akuntansi;

use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProjectExport;

class ProjectExecutionExport extends Component
{
    public $selectedStatus = 'SEMUA';
    public function export()
    {
        return Excel::download(new ProjectExport($this->selectedStatus), "Laporan_Proyek_{$this->selectedStatus}_" . date('Y-m-d') . '.xlsx');
    }
    public function render()
    {
        return view('livewire.akuntansi.project-execution-export');
    }
}
