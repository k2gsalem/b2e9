<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function scopeSearch($query, $val, $columns = ['title'])
    {
        $query->where(function ($q) use ($val, $columns) {
            foreach ($columns as $i => $column) {
                if ($i < 1)
                    $q->where($column, 'like', '%' . $val . '%');
                else
                    $q->orWhere($column, 'like', '%' . $val . '%');
            }
        });
        return $query;
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeWithAndWhereHas($query, $relation, $constraint){
        return $query->whereHas($relation, $constraint)
            ->with([$relation => $constraint]);
    }
}
