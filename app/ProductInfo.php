<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductInfo extends Model
{
    protected $fillable = ['packaging_id','cable_img','inbox_img','pallet_img','product_fac','pallet_base','pallet_low','pallet_height'];

    public function package()
    {
        return $this->hasOne('App\Models\Package', 'id', 'packaging_id');
    }
}
