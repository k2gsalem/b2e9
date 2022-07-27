<?php

namespace App\Http\Livewire\Admin\WebsiteSettings;

use App\Models\Setting;
use App\Traits\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Stats extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $visitors;
    public $projects;
    public $clients;
    public $customers;

    public function mount()
    {
        $this->sync();
    }

    public function render()
    {
        return view('livewire.admin.website-settings.stats');
    }

    public function updatedVisitors()
    {
        Setting::set('home_stats_visitors', $this->visitors);
    }

    public function updatedProjects()
    {
        Setting::set('home_stats_projects', $this->projects);
    }

    public function updatedClients()
    {
        Setting::set('home_stats_clients', $this->clients);
    }

    public function updatedCustomers()
    {
        Setting::set('home_stats_customers', $this->customers);
    }

    public function sync()
    {
        $this->visitors = config('settings.home_stats_visitors');
        $this->projects = config('settings.home_stats_projects');
        $this->clients = config('settings.home_stats_clients');
        $this->customers = config('settings.home_stats_customers');
    }
}
