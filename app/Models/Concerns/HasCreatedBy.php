<?php

namespace App\Models\Concerns;

trait HasCreatedBy
{
    protected static function bootHasCreatedBy()
    {
        static::creating(function ($model) {
            $model->{'created_by'} = auth()->id();
        });
    }
}



?>
