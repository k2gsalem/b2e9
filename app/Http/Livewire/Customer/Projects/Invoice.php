<?php

namespace App\Http\Livewire\Customer\Projects;

use App\Models\Project;
use Livewire\Component;

class Invoice extends Component
{
    public $project;

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function render()
    {
        return view('livewire.customer.projects.invoice');
    }
}
