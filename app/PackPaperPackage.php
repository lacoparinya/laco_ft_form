<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackPaperPackage extends Model
{
    protected $fillable = [
        'pack_paper_id','packaging_id','lot',
        'pack_date_format','exp_date_format',
        'extra_stamp','front_img','back_img',
        'front_stamp', 'front_locstamp', 'back_stamp', 'back_locstamp'
    ];

    public function packpaper()
    {
        return $this->hasOne('App\PackPaper', 'id', 'pack_paper_id');
    }

    public function packaging()
    {
        return $this->hasOne('App\Models\Package', 'id', 'packaging_id');
    }
}
