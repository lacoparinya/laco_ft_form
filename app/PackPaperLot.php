<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackPaperLot extends Model
{
    protected $fillable = ['pack_paper_id','pack_date','exp_date','lot','frombox','tobox','nbox','nbag','pweight','fweight','pallet','pbag','note','cablecover','pattern_pallet'];

    public function packpaper()
    {
        return $this->hasOne('App\PackPaper', 'id', 'pack_paper_id');
    }

}
