<?php

namespace App\Livewire;

use App\Models\Projects;
use Livewire\Component;

class StatusProject extends Component
{
    public $projectStatus;
    public $numberStatus;

    public function mount($projectStatus = null)
    {
        $this->projectStatus = $projectStatus;
        if ($projectStatus) {
            $this->numberStatus = Projects::get()->where('status', $projectStatus)->count();
        }
    }

    public function render()
    {
        return view('livewire.status-project', [
            'numberStatus' => $this->numberStatus,
            'projectStatus' => $this->projectStatus,
        ]);
    }
}
