<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name', 'desc', 'kgsperpack', 'numperbox', 'status'
    ];

    public function logpack()
    {
        return $this->hasMany('App\FtLogPack', 'package_id');
    }
}
