<?php

namespace App\Transformers\V1;

// use App\Models\ActivityTemplate;
use App\Models\User;
use League\Fractal\TransformerAbstract;
use Propaganistas\LaravelPhone\PhoneNumber;

class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        'sports', 'activityTemplate', 'byEndorsements', 'toEndorsements', 'sports', 'activities', 'activity', 'locationHistories', 'location', 'notificationSetting'
        // 'feedback','sports','locations','activities','location','followerRequests','followingRequests','followers','followings'
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $model)
    {
        // $pc = $model->activity()->onlyTrashed()->count();
        // $hc = $model->activities()->onlyTrashed()->count();
        // $tc = $pc + $hc;
        // $phone = $model->phone ? PhoneNumber::make($model->phone, ['AUTO'])->formatE164() : null;
        return [
            //
            'id' => (int) $model->id,
            'id'=>$model->id,
            'name'=>$model->name,
            'role'=>$model->role,
            'phone'=>$model->phone,
            'phone_verified_at'=>$model->phone_verified_at,
            'email'=>$model->email,
            'email_verified_at'=>$model->email_verified_at,
            'contact_name'=>$model->contact_name,
            'organization_type'=>$model->organization_type,
            'incorporation_date'=>$model->incorporation_date,
            'alternate_phone'=>$model->alternate_phone,
            'gst_number'=>$model->gst_number,
            'gst_phone'=>$model->gst_phone,
            'gst_number_verified_at'=>$model->gst_number_verified_at,
            'sales_turnover'=>$model->sales_turnover,
            'employees_count'=>$model->employees_count,           
            'active'=>$model->active,
            // 'remember_token'=>$model->remember_token,
            // 'fcm_token'=>$model->fcm_token,
            'profile_photo_path'=>$model->profile_photo_path,
            'referral_code'=>$model->referral_code,
            'referrer_id'=>$model->referrer_id,
            'customer_intro'=>$model->customer_intro,
            'supplier_intro'=>$model->supplier_intro,
            'created_at'=>$model->created_at,
            'updated_at'=>$model->updated_at,
        ];
    }
    // public function includesports(User $model)
    // {
    //     return $this->collection($model->sports, new SportTransformer());
    // }
    // public function includeactivityTemplate(User $model)
    // {
    //     return $this->collection($model->activityTemplates, new ActivityTemplateTransformer());
    // }
    // public function includebyEndorsements(User $model)
    // {
    //     return $this->collection($model->byEndorsements, new EndorsementTransformer(['userID' => $model->id]));
    // }
    // public function includetoEndorsements(User $model)
    // {
    //     return $this->collection($model->toEndorsements, new EndorsementTransformer(['userID' => $model->id]));
    // }
    // public function includeactivities(User $model)
    // {
    //     return $this->collection($model->activities, new ActivityTransformer());
    // }
    // public function includeactivity(User $model)
    // {
    //     return $this->collection($model->activity, new ActivityTransformer());
    // }
    // public function includelocationHistories(User $model)
    // {
    //     return $this->collection($model->locationHistories, new LocationHistoryTransformer());
    // }
    // public function includelocation(User $model)
    // {
    //     return $this->item($model->location, new UserLocationTransformer());
    // }
    // public function includenotificationSetting(User $model)
    // {
    //     return $this->item($model->notificationSetting, new NotificationSettingTransformer());
    // }

    // public function includeuser(Activity $model)
    // {
    //     return $this->item($model->user, new UserTransformer());
    // }
}
