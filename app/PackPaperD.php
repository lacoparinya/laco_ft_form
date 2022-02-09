<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackPaperD extends Model
{
    protected $fillable = ['pack_paper_id','pack_date','exp_date','weight_with_bag','all_weight','all_bpack','cablecover','note'];

    public function packpaper()
    {
        return $this->hasOne('App\PackPaper', 'id', 'pack_paper_id');
    }
}
