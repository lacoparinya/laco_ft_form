<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ProductGroup extends Model
{
    protected $connection = 'sqlpackagesrv';
    
    protected $fillable = ['name', 'desc', 'status'];

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'product_group_id');
    }
}
