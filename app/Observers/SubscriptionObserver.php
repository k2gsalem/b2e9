<?php

namespace App\Observers;

use App\Models\Subscription;

class SubscriptionObserver
{
    public function creating(Subscription $model)
    {
        $model->fresh_bids = $model->plan->fresh_bids;
        $model->additional_bids = $model->plan->additional_bids;
        $model->starts_at = now();
        $model->ends_at = now()->addDays($model->plan->validity_days);
    }
}
