<?php

namespace App\Http\Livewire\Customer\Bids;

use App\Models\BidReview;
use App\Models\Project;
use App\Traits\LivewireAlert;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use LivewireAlert;

    protected $listeners = [
        'closeDetails', 'approve', 'submitReview', 'approved'
    ];

    public $project;
    public $bid_id;

    public function render()
    {
        return view('livewire.customer.bids.index');
    }

    public function getBidsProperty()
    {
        return $this->project->bids()->valid()->orderBy('amount')->limit($this->project->transaction->bids)->get();
    }

    public function getBidProperty()
    {
        return $this->project->bids()->find($this->bid_id);
    }

    public function closeDetails()
    {
        $this->reset('bid_id');
    }

    public function approve()
    {
        $this->confirm(
            'Are you sure to approve this supplier?',
            [
                'confirmButtonText' => 'Yes, Approve',
                'onConfirmed' => 'approved',
                'cancelButtonText' => 'Cancel',
            ]
        );
    }

    public function approved()
    {
        if ($this->bid && is_null($this->project->selected_bid)) {
            $this->bid->approved_at = now();
            $this->bid->save();
            $this->success('Approved successfully');
        }
    }

    public function submitReview($data)
    {
        $this->bid->reviews()->save(new BidReview($data));
        $this->success('Submitted successfully');
    }
}
