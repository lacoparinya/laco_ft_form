<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $connection = 'sqlpackagesrv';
    
    protected $fillable = ['package_type_id', 'name', 'desc', 'size', 'image', 'relate_id',  'stamp_format',  'status', 'sapnote', 'note2'];

    public function packagetype()
    {
        return $this->hasOne('App\Models\PackageType', 'id', 'package_type_id');
    }

    public function packagings()
    {
        return $this->belongsToMany(
            'App\Models\Packaging',
            'packaging_packages',
            'package_id',
            'packaging_id'        
        );
    }
}
