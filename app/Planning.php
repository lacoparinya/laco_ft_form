<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    protected $fillable = [
        'job_id', 'plan_date', 'product_id', 'target_man', 'target_value', 'note'
    ];

    public function job()
    {
        return $this->hasOne('App\Job', 'id', 'job_id');
    }

    public function product()
    {
        return $this->hasOne('App\Product', 'id', 'product_id');
    }
}
