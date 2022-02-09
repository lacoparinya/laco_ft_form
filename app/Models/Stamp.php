<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Stamp extends Model
{
    protected $connection = 'sqlpackagesrv';
    
    protected $fillable = ['name', 'desc', 'status'];

    public function packagings()
    {
        return $this->belongsToMany(
            'App\Models\Packaging',
            'packaging_stamps',            
            'stamp_id',
            'packaging_id'
        );
    }
}
