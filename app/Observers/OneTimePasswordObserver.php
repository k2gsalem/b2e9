<?php

namespace App\Observers;

use App\Models\OneTimePassword;

class OneTimePasswordObserver
{
    public function creating(OneTimePassword $model)
    {
        $model->code = $model->generate();
    }
}
