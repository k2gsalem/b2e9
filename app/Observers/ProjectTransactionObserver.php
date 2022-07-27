<?php

namespace App\Observers;

use App\Models\PlanTransaction;
use App\Models\ProjectTransaction;
use App\Notifications\ProjectInvoicePaid;
use Illuminate\Support\Str;

class ProjectTransactionObserver
{
    public function creating(ProjectTransaction $model)
    {
        $model->uuid = 'B2EP'.Str::upper(Str::random(6).Str::random(6));

//        $latest_project_transaction = ProjectTransaction::query()->whereNotNull('invoice_id')
//            ->latest('invoice_id')->first();
//        $latest_plan_transaction = PlanTransaction::query()->whereNotNull('invoice_id')
//            ->latest('invoice_id')->first();
//        $latest_project_transaction_id = $latest_project_transaction ? $latest_project_transaction->invoice_id : 0;
//        $latest_plan_transaction_id = $latest_plan_transaction ? $latest_plan_transaction->invoice_id : 0;
//        $model->uuid = ($latest_plan_transaction_id > $latest_project_transaction_id ? $latest_plan_transaction_id : $latest_project_transaction_id) + 1;
    }

    public function updated(ProjectTransaction $model)
    {
        if ($model->isDirty('paid_at')
            && is_null($model->getOriginal('paid_at'))
            && !is_null($model->paid_at)) {

            $latest_project_transaction = ProjectTransaction::query()->whereNotNull('invoice_id')
                ->latest('invoice_id')->first();
            $latest_plan_transaction = PlanTransaction::query()->whereNotNull('invoice_id')
                ->latest('invoice_id')->first();
            $latest_project_transaction_id = $latest_project_transaction ? $latest_project_transaction->invoice_id : 0;
            $latest_plan_transaction_id = $latest_plan_transaction ? $latest_plan_transaction->invoice_id : 0;
            $model->invoice_id = ($latest_plan_transaction_id > $latest_project_transaction_id ? $latest_plan_transaction_id : $latest_project_transaction_id) + 1;
            $model->invoice_id = str_pad($model->invoice_id < 17 ? 17 : $model->invoice_id, 5, "0", STR_PAD_LEFT);
            $model->saveQuietly();
            
            $model->project->enableToEligibleUsers();
            $model->project->user->notify(new ProjectInvoicePaid($model));
        }
    }
}
