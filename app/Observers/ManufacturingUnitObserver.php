<?php

namespace App\Observers;

use App\Models\Location;
use App\Models\ManufacturingUnit;

class ManufacturingUnitObserver
{
    public function saving(ManufacturingUnit $model)
    {
        $pincode = Location::fetch($model->pincode);
        if ($pincode) {
            $model->latitude = $pincode->latitude;
            $model->longitude = $pincode->longitude;
        }
        else {
            $model->latitude = null;
            $model->longitude = null;
        }
    }
}
