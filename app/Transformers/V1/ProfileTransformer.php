<?php

namespace App\Transformers\V1;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class ProfileTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
        'location'
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
        'sports','activityTemplate','byEndorsements','toEndorsements','sports','activities','activity','locationHistories','notificationSetting'
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $model)
    {
        $pc = $model->activity()->onlyTrashed()->count();
        $hc = $model->activities()->onlyTrashed()->count();
        $tc = $pc + $hc;
        return [
            //
            'id' =>(int) $model->id,
            'first_name' => $model->first_name,
            'last_name' => $model->last_name,
            'date_of_birth' => $model->date_of_birth,
            'age' => $model->date_of_birth ? $model->age() : 0,
            'gender' => $model->gender,
            'email' => $model->email,
            'phone' =>null,
            'username' => $model->username,
            'photo' => $model->getFirstMediaUrl('avatar') ?: $model->defaultPhotoUrl(),
            'private' => $model->private,
            'phone_verified' => (bool)$model->phone_verified_at ? true :false,
            'email_verified' => (bool)$model->email_verified_at ? true :false,
            'facebook_linked' => (bool)$model->fb_id,
            'google_linked' => (bool)$model->google_id,
            'bio' => $model->bio,
            'followers_count'=> (int)$model->followers_count,
            'followings_count'=> (int)$model->followings_count,
            'activity_count'=>(int)($tc),
            'dob_updated_at'=>$model->dob_updated_at,
            'name_updated_at'=>$model->name_updated_at,
            'username_updated_at'=>$model->username_updated_at,
            // 'name_count'=>(int)$model->name_count,
            // 'username_count'=>(int)$model->username_count,
        ];
    }
    public function includesports(User $model)
    {
        return $this->collection($model->sports, new SportTransformer());
    }
    public function includeactivityTemplate(User $model)
    {
        return $this->collection($model->activityTemplates, new ActivityTemplateTransformer());
    }
    public function includebyEndorsements(User $model)
    {
        return $this->collection($model->byEndorsements, new EndorsementTransformer(['userID'=>$model->id]));
    }
    public function includetoEndorsements(User $model)
    {
        return $this->collection($model->toEndorsements, new EndorsementTransformer(['userID'=>$model->id]));
    }
    public function includeactivities(User $model)
    {
        return $this->collection($model->activities, new ActivityTransformer());
    }
    public function includeactivity(User $model)
    {
        return $this->collection($model->activity, new ActivityTransformer());
    }
    public function includelocationHistories(User $model)
    {
        return $this->collection($model->locationHistories, new LocationHistoryTransformer());
    }
    public function includelocation(User $model)
    {
        return $this->item($model->location, new UserLocationTransformer());
    }
    public function includenotificationSetting(User $model)
    {
        return $this->item($model->notificationSetting, new NotificationSettingTransformer());
    }
}
