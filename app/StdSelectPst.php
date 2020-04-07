<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StdSelectPst extends Model
{
    protected $fillable = ['pst_product_id','std_rate_per_h_m','note','status'];

    public function pstproduct()
    {
        return $this->hasOne('App\PstProduct', 'id', 'pst_product_id');
    }
}
