<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatPack extends Model
{
    protected $fillable = [
        'matname', 'packname', 'stdrateperhr', 'status'
    ];

    public function getlist(){
        $matpacklist = array();
        $matpackRawlist = self::orderBy('matname')->orderBy('packname')->get();
        foreach ($matpackRawlist as $matpackObj) {
            $matpacklist[$matpackObj->id] =
                $matpackObj->matname . " - " . $matpackObj->packname;
        }
        return $matpacklist;
    }
}
