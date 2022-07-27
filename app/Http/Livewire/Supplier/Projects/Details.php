<?php

namespace App\Http\Livewire\Supplier\Projects;

use App\Models\Bid;
use App\Models\Project;
use App\Traits\LivewireAlert;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Details extends Component
{
    use LivewireAlert;

    public $user;
    public $project;
    public $my_bid;

    public $mus;
    public $mu_ids = [];

    public function rules()
    {
        return [
            'my_bid.manufacturing_unit_id' => [
                'required',
                Rule::in($this->mu_ids)
            ],
            'my_bid.amount' => ['required', 'numeric'],
        ];
    }

    public function mount(Request $request, Project $project)
    {
        $this->user = $request->user();
        $this->project = $project;
        $this->fetchMyBid();

        $this->mus = request()->user()
            ->manufacturing_units()
            ->select('*')
            ->distance($project->manufacturing_unit->toArray())
            ->having('distance', '<=', $project->location_preference)
            ->get();
        $this->mu_ids = request()->user()
            ->manufacturing_units()
            ->select('*')
            ->distance($project->manufacturing_unit->toArray())
            ->having('distance', '<=', $project->location_preference)
            ->pluck('id');
    }

    public function render(Request $request)
    {
        $attachments = $this->project->getMedia('attachments');
        return view('livewire.supplier.projects.details', compact('attachments'));
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function fetchMyBid()
    {
        $this->my_bid = $this->project->bids()->whereBelongsTo(request()->user())->orderBy('amount')->first();
        if (is_null($this->my_bid))
            $this->my_bid = new Bid([
                'manufacturing_unit_id' => auth()->user()->manufacturing_unit->id
            ]);
    }

    public function submitBid()
    {
        $this->validate();

        $subscription = $this->user->subscription;
        /*if ($this->project->current_bid_value && $this->project->current_bid_value <= $this->my_bid->amount) {
            $this->addError('my_bid.amount', 'Bid amount must be lesser than current bid value');
            return;
        }*/

        if (
            $subscription
            && (
                $this->my_bid->exists
                    ? $subscription->additional_bids - $subscription->used_additional_bids > 0
                    : $subscription->fresh_bids - $subscription->used_fresh_bids > 0
            )
        )
        {
            $this->my_bid->fill([
                'project_id' => $this->project->id,
                'user_id' => request()->user()->id,
                'subscription_id' => $subscription->id,
            ]);
//            dd($this->my_bid->save());
            $this->my_bid->save();
//            $this->fetchMyBid();
//            $this->project->refresh();
            $this->project->current_bid_value = null;
            $this->success('Your BID updated successfully');
            return redirect(request()->header('Referer'));
        }
        else
            return redirect()->route('supplier.plans.index');
    }
}
