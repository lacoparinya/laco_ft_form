<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id','method_id','package_id','total_pack','total_kg','note'
    ];

    public function order()
    {
        return $this->hasOne('App\Order', 'id', 'order_id');
    }

    public function method()
    {
        return $this->hasOne('App\Method', 'id', 'method_id');
    }

    public function package()
    {
        return $this->hasOne('App\Package', 'id', 'package_id');
    }
}
