<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'desc','product_group_id'
    ];

    public function productgroup()
    {
        return $this->hasOne('App\ProductGroup', 'id', 'product_group_id');
    }
}
