<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageInfo extends Model
{
    protected $fillable = ['packaging_id', 'pack_date_format', 'exp_date_format', 'extra_stamp', 
    'front_img','back_img','front_stamp', 'front_locstamp', 'back_stamp', 'back_locstamp'];

    public function packaging()
    {
        return $this->hasOne('App\Models\Packaging', 'id', 'packaging_id');
    }
    
}
