<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FtMaster extends Model
{
    protected $fillable = [
        'name', 'process_date', 'product_id', 'note'
    ];

    public function product()
    {
        return $this->hasOne('App\Product','id','product_id');
    }
}
