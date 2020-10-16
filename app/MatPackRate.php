<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatPackRate extends Model
{
    protected $fillable = [
        'mat_pack_id', 'stamp_machine_id', 'rateperhr', 'status'
    ];

    public function matpack()
    {
        return $this->hasOne('App\MatPack', 'id', 'mat_pack_id');
    }

    public function stampmachine()
    {
        return $this->hasOne('App\StampMachine', 'id', 'stamp_machine_id');
    }
}
