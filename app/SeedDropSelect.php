<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeedDropSelect extends Model
{
    protected $fillable = [
        'shift_id',
        'check_date',
        'material',
        'input_w',
        'output_w',
        'incline_a',
        'incline_m',
        'beltrecheck_a',
        'beltrecheck_m',
        'beltautoweight_a',
        'beltautoweight_m',
        'underbelt_a',
        'underbelt_m',
        'total_a',
        'total_m',
        'note'
    ];

    public function shift()
    {
        return $this->hasOne('App\Shift', 'id', 'shift_id');
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $total_a = 0;
            $total_m = 0;
            if(isset($model->incline_a)){
                $total_a += $model->incline_a;
            }
            if (isset($model->beltrecheck_a)) {
                $total_a += $model->beltrecheck_a;
            }
            if (isset($model->beltautoweight_a)) {
                $total_a += $model->beltautoweight_a;
            }
            if (isset($model->underbelt_a)) {
                $total_a += $model->underbelt_a;
            }
            if (isset($model->incline_m)) {
                $total_m += $model->incline_m;
            }
            if (isset($model->beltrecheck_m)) {
                $total_m += $model->beltrecheck_m;
            }
            if (isset($model->beltautoweight_m)) {
                $total_m += $model->beltautoweight_m;
            }
            if (isset($model->underbelt_m)) {
                $total_m += $model->underbelt_m;
            }

            $model->total_a = $total_a;
            $model->total_m = $total_m;
        });

        self::updating(function ($model) {
            $total_a = 0;
            $total_m = 0;
            if (isset($model->incline_a)) {
                $total_a += $model->incline_a;
            }
            if (isset($model->beltrecheck_a)) {
                $total_a += $model->beltrecheck_a;
            }
            if (isset($model->beltautoweight_a)) {
                $total_a += $model->beltautoweight_a;
            }
            if (isset($model->underbelt_a)) {
                $total_a += $model->underbelt_a;
            }
            if (isset($model->incline_m)) {
                $total_m += $model->incline_m;
            }
            if (isset($model->beltrecheck_m)) {
                $total_m += $model->beltrecheck_m;
            }
            if (isset($model->beltautoweight_m)) {
                $total_m += $model->beltautoweight_m;
            }
            if (isset($model->underbelt_m)) {
                $total_m += $model->underbelt_m;
            }

            $model->total_a = $total_a;
            $model->total_m = $total_m;
        });
    }
}
