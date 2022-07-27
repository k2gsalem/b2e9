<?php

namespace App\Http\Livewire\Supplier\Plans;

use App\Models\Plan;
use App\Models\PlanTransaction;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public $user;
    public $plans;

    public function mount(Request $request)
    {
        $this->user = $request->user();
        $this->plans = Plan::query()->active()->orderBy('order_pos')->get();
    }

    public function render()
    {
        return view('livewire.supplier.plans.index');
    }

    public function selectPlan($plan_id)
    {
        $plan = Plan::query()->active()->findOrFail($plan_id);

        $gst_amount = round($plan->sale_amount * 0.18, 2);
        $transaction = new PlanTransaction([
            'plan_id' => $plan->id,
            'amount' => $plan->sale_amount,
            'gst_amount' => $gst_amount,
            'final_amount' => round($gst_amount + $plan->sale_amount, 2),
            'mode' => 'EASEBUZZ'
        ]);
        $this->user->subscriptions()->save($transaction);

        return redirect()->route('supplier.plans.buy', ['plan_transaction' => $transaction->id]);
    }

    public function getRecordsQuery()
    {
        $query = Subscription::query()
            ->where('user_id', Auth::user()->id)
            ->orderByDesc('id');

        return $query;
    }

    public function getRecordsProperty()
    {
        return $this->getRecordsQuery()->get();
    }

    public function recordClicked($id)
    {
        return redirect()->route('supplier.plans.invoice', $id);
    }
}
