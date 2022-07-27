<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class Dashboard extends Component
{
    public function mount()
    {
//        return redirect()->route('admin.materials.index');
    }

    public function render()
    {
        return view('livewire.admin.dashboard')->layout('layouts.admin.app-layout');
    }
}
