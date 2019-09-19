<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogPackM extends Model
{
    protected $fillable = [
        'process_date', 'method_id', 'package_id', 'order_id',
        'std_pack_id', 'overalltargets', 'targetperday', 'houroverall', 'hourperday', 'note', 'status'
    ];

    public function method()
    {
        return $this->hasOne('App\Method', 'id', 'method_id');
    }

    public function package()
    {
        return $this->hasOne('App\Package', 'id', 'package_id');
    }

    public function order()
    {
        return $this->hasOne('App\Order', 'id', 'order_id');
    }

    public function stdpack()
    {
        return $this->hasOne('App\StdPack', 'id', 'std_pack_id');
    }

    public function logpackd()
    {
        return $this->hasMany('App\LogPackD', 'log_pack_m_id');
    }
}