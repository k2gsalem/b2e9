<?php

namespace App\Transformers\V1;

use App\Models\UserLocation;
use League\Fractal\TransformerAbstract;

class UserLocationTransformer extends TransformerAbstract
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
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(UserLocation $model)
    {
        return [
            'id'=>(int)$model->id,
            'lat'=>$model->lat,
            'lng'=>$model->lng,
            'title'=>$model->title,
            'user_id'=>(int)$model->user_id,
            'user_name'=>'-',
            // 'user_name'=>$model->getFilamentName,
        ];
    }
}
