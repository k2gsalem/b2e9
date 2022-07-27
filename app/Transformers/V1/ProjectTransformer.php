<?php

namespace App\Transformers\V1;

use App\Models\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
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
    public function transform(Project $model)
    {
        return [
            //            
            'id'=>$model->id,
            'user_id'=>$model->user_id,
            'manufacturing_unit_id'=>$model->manufacturing_unit_id,
            'title'=>$model->title,
            'part_name'=>$model->part_name,
            'drawing_number'=>(int)$model->drawing_number,
            'delivery_date'=>$model->delivery_date,
            'location_preference'=>$model->location_preference,
            'raw_material_price'=>$model->raw_material_price,
            'description'=>$model->description,
            'publish_at'=>$model->publish_at,
            'close_at'=>$model->close_at,
            'active'=>$model->active,
            'instant_publish'=>$model->instant_publish,
            'created_at'=>$model->created_at,
            'updated_at'=>$model->updated_at,
            'attachments'=>$model->getFirstMediaUrl('attachments') ?: null,
        ];
    }
}
