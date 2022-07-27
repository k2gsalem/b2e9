<?php

namespace App\Observers;

use App\Interfaces\MustVerifyPhone;
use App\Models\User;
use App\Notifications\UserAccountCreated;
use App\Notifications\UserAccountUpdated;
use App\Notifications\UserPasswordChanged;
use App\Notifications\UserProfileUpdated;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class UserObserver
{
    public function creating(User $model)
    {
        $model->referral_code = Str::upper(Str::random(4).Str::random(4));
    }

    public function created(User $model)
    {
        $model->notify((new UserAccountCreated));
    }

    public function updated(User $model)
    {
        if ($model->isDirty('password')) {
            $model->notify(new UserPasswordChanged);
        }
        if ($model->isDirty('fcm_token')) {
            if (!is_null($model->fcm_token)) {
                User::query()->where('fcm_token', $model->fcm_token)
                    ->where('id', '<>', $model->id)
                    ->update(['fcm_token' => null]);
            }
        }
        if ($model->isDirty(['name', 'phone', 'email'])) {
            error_log("updating from user observer ".$model->name." (".$model->email.")");
            $model->notify((new UserAccountUpdated));

            if ($model->isDirty('email') && $model instanceof MustVerifyEmail) {
                $model->forceFill([
                    'email_verified_at' => null,
                ])->saveQuietly();
                $model->sendEmailVerificationNotification();
            }

            if ($model->isDirty('phone') && $model instanceof MustVerifyPhone) {
                $model->forceFill([
                    'phone_verified_at' => null,
                ])->saveQuietly();
            }
        }
        if ($model->isDirty('active') && !$model->active) {
            DB::table('sessions')->where('user_id', $model->id)->delete();
        }
    }
}
