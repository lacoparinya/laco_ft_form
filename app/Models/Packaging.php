<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Packaging extends Model
{
    protected $connection = 'sqlpackagesrv';
    
    protected $fillable = ['product_id','start_date','end_date','version','desc','inner_weight_g','number_per_pack','outer_weight_kg','status'];

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

    public function package()
    {
        return $this->belongsToMany(
            'App\Models\Package',
            'packaging_packages',
            'packaging_id',
            'package_id'
        );
    }

    public function stamp()
    {
        return $this->belongsToMany(
            'App\Models\Stamp',
            'packaging_stamps',
            'packaging_id',
            'stamp_id'
        );
    }

    public function packmachine()
    {
        return $this->belongsToMany(
            'App\Models\PackMachine',
            'packaging_pack_machines',
            'packaging_id',
            'pack_machine_id');
    }

    public function packagestamptxt()
    {
        return $this->hasMany('App\Models\PackageExp', 'packaging_id');
    }
}
