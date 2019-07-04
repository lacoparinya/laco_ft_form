<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StdPreProd extends Model
{

    protected $fillable = ['pre_prod_id','std_rate_per_h_m','note','status'];

    public function preprod()
    {
        return $this->hasOne('App\PreProd', 'id', 'pre_prod_id');
    }
}
