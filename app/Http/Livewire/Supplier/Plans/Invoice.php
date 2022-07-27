<?php

namespace App\Http\Livewire\Supplier\Plans;

use App\Models\Subscription;
use Livewire\Component;

class Invoice extends Component
{
    public $subscription;

    public function mount(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function render()
    {
        return view('livewire.supplier.plans.invoice');
    }
}
