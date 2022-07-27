<?php

namespace App\Http\Livewire\Customer\Projects;

use App\Models\Location;
use App\Models\ManufacturingUnit;
use App\Models\Package;
use App\Models\Project;
use App\Models\ProjectTransaction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Details extends Component
{
    use AuthorizesRequests;

    public $project;
    public $publish_date;
    public $publish_time;
    public $closing_date;
    public $closing_time;

    public $packages;
    public $package;

    public $instantPublish = false;

    public function mount(Project $project)
    {
        $this->authorize('view', $project);
        $this->project = $project;
        $this->publish_date = Carbon::parse($project->publish_at)->format('Y-m-d');
        $this->publish_time = Carbon::parse($project->publish_at)->format('H:i:s');
        $this->closing_date = Carbon::parse($project->close_at)->format('Y-m-d');
        $this->closing_time = Carbon::parse($project->close_at)->format('H:i:s');
        $this->instantPublish = $project->instant_publish;

        $this->packages = Package::query()->where('active', 1)->orderBy('order_pos')->get();
        $this->package = $this->packages->count() ? $this->packages->first() : null;
    }

    public function render()
    {
        $attachments = $this->project->getMedia('attachments');
        return view('livewire.customer.projects.details', compact('attachments'));
    }

    public function rules()
    {
        return [
            'instantPublish' => ['boolean'],
            'publish_date' => [
                'required', 'date',
//                'after:'.now()->addDays("-1")->format('Y-m-d')
            ],
            'publish_time' => [
                'required_with_all:publish_date', 'string',
//                function($attribute, $value, $fail) {
//                    if (Carbon::parse($this->publish_date.' '.$value) < now()) {
//                        $fail('The Publish Time must be greater than now');
//                    }
//                }
            ],
            'closing_date' => [
                'required_with_all:publish_date,publish_time', 'date',
            ],
            'closing_time' => [
                'required_with_all:publish_date,publish_time,closing_date', 'string',
                function($attribute, $value, $fail) {
                    if (Carbon::parse($this->closing_date.' '.$value) < now()->addHours(3) || Carbon::parse($this->closing_date.' '.$value) < Carbon::parse($this->publish_date.' '.$this->publish_time)->addHours(3)) {
                        $fail('The Closing Time must be greater than 3 hrs from publish time');
                    }
                }
            ],
        ];
    }

    public function updated($field)
    {
        switch ($field) {
            case 'publish_date':
            case 'publish_time':
            case 'closing_date':
            case 'closing_time':
                $this->validateOnly('publish_date');
                $this->validateOnly('publish_time');
                $this->validateOnly('closing_date');
                $this->validateOnly('closing_time');
                break;
        }
    }

    public function selectPackage($id)
    {
        $this->package = Package::query()->active()->findOrFail($id);
    }

    public function checkout(Request $request)
    {
        $this->validate();

        $project = $this->project;
        $project->publish_at = Carbon::parse($this->publish_date.' '.$this->publish_time);
        $project->close_at = Carbon::parse($this->closing_date.' '.$this->closing_time);
        $project->instant_publish = false;
        if ($this->instantPublish) {
            $project->publish_at = now();
            $project->instant_publish = true;
        }
        $project->save();

        $transaction = new ProjectTransaction([
            'package_id' => $this->package->id,
            'bids' => $this->package->bids,
            'base_amount' => $this->package->sale_amount,
            'gst_amount' => $this->package->gst_amount,
            'final_amount' => $this->package->final_amount,
            'mode' => 'EASEBUZZ'
        ]);
        $project->transactions()->save($transaction);

        $this->package = null;

        return redirect()->route('customer.projects.pay', ['project_transaction' => $transaction->id]);
    }
}
