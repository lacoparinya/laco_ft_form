<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StampM extends Model
{

    protected $fillable = [
        'process_date', 'shift_id', 'mat_pack_id', 'stamp_machine_id', 'rateperhr',
        'targetperjob', 'order_no', 'pack_date', 
        'staff_target', 'staff_operate', 'staff_actual', 'note', 'status'
    ];

    public function shift()
    {
        return $this->hasOne('App\Shift', 'id', 'shift_id');
    }

    public function matpack()
    {
        return $this->hasOne('App\MatPack', 'id', 'mat_pack_id');
    }

    public function stampmachine()
    {
        return $this->hasOne('App\StampMachine', 'id', 'stamp_machine_id');
    }

    public function stampd()
    {
        return $this->hasMany('App\StampD', 'stamp_m_id');
    }
}
