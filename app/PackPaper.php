<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackPaper extends Model
{
    protected $fillable = ['packaging_id','order_no','exp_month','cable_img',
    'inbox_img','pallet_img','status', 'weight_with_bag', 'loading_date', 'product_fac','pallet_base','pallet_low','pallet_height'];

    public function packaging()
    {
        return $this->hasOne('App\Models\Packaging', 'id', 'packaging_id');
    }

    public function packpaperds()
    {
        return $this->hasMany('App\PackPaperD', 'pack_paper_id');
    }

    public function packpaperpackages(){
        return $this->hasMany('App\PackPaperPackage', 'pack_paper_id');
    }

    public function packpaperdlots()
    {
        return $this->hasMany('App\PackPaperLot', 'pack_paper_id');
    }
}
