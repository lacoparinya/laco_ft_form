<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StdProcess extends Model
{
    protected $fillable = [
        'product_id', 'std_rate','status'
    ];

    public function product()
    {
        return $this->hasOne('App\Product', 'id', 'product_id');
    }
}
