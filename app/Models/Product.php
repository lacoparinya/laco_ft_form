<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'sqlpackagesrv';
    
    protected $fillable = ['customer_id', 'product_group_id', 'name', 'desc', 'SAP', 'shelf_life', 'status'];

    public function customer()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'customer_id');
    }

    public function productgroup()
    {
        return $this->hasOne('App\Models\ProductGroup', 'id', 'product_group_id');
    }

    public function packagings()
    {
        return $this->hasMany('App\Models\Packaging', 'product_id');
    }
}
