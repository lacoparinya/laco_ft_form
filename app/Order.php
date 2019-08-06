<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_no', 'loading_date','note'
    ];

    public function orderdetail()
    {
        return $this->hasMany('App\OrderDetail', 'order_id');
    }
}
