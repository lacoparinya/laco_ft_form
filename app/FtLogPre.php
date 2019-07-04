<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FtLogPre extends Model
{
    protected $fillable = [
        'pre_prod_id','std_pre_prod_id','process_date','process_time','shift_id',
        'workhours','targets','input','output','input_sum','output_sum','num_pre',
        'num_iqf','num_all','note','status'
    ];

    public function preprod()
    {
        return $this->hasOne('App\PreProd', 'id', 'pre_prod_id');
    }

    public function stdpreprod()
    {
        return $this->hasOne('App\StdPreProd', 'id', 'std_pre_prod_id');
    }

    public function shift()
    {
        return $this->hasOne('App\Shift', 'id', 'shift_id');
    }
}
