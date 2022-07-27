<?php

namespace App\Observers;

use App\Models\Material;

class MaterialObserver
{
    public function updating(Material $model)
    {
        if ($model->isDirty('price') && $model->old_price != $model->getOriginal('price')) {
            $model->old_price = $model->getOriginal('price');
        }
    }
}
