<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogPstSelectM extends Model
{
    protected $fillable = [
        'process_date', 'product_id', 'shift_id', 'pst_type_id', 'std_process_id', 'hourperday', 'targetperday', 'ref_note', 'note', 'status'
    ];

    public function pstproduct()
    {
        return $this->hasOne('App\PstProduct', 'id', 'product_id');
    }

    public function shift()
    {
        return $this->hasOne('App\Shift', 'id', 'shift_id');
    }

    public function logpstselectd()
    {
        return $this->hasMany('App\LogPstSelectD', 'log_pst_select_m_id');
    }

    public function stdselectpst()
    {
        return $this->hasOne('App\StdSelectPst', 'id', 'std_process_id');
    }

    public function psttype()
    {
        return $this->hasOne('App\PstType', 'id', 'pst_type_id');
    }
}
