<?php

namespace App\Observers;

use App\Models\Bid;
use App\Notifications\BidSelected;

class BidObserver
{
    public function creating(Bid $model)
    {
        $model->valid = $model->project->min_bid_value <= $model->amount;
    }

    public function updating(Bid $model)
    {
        if ($model->isDirty('amount')) {
            $model->valid = $model->project->min_bid_value <= $model->amount;
            $model->edit_count++;
            if ($model->isDirty('subscription_id'))
                $model->edit_count = 1;
            $model->edit_history = array_merge($model->edit_history, [$model->getOriginal('amount')]);
        }
    }

    public function updated(Bid $model)
    {
        if ($model->isDirty('approved_at') && is_null($model->getOriginal('approved_at'))) {
            $model->notify(new BidSelected);
        }
    }
}
