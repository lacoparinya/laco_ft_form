<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mcheckweight;
use App\WeightReport;
use App\Weight1Report;
use App\Weight2Report;
use App\Weight3Report;
use App\CheckWeightData;

class SyncCheckWeight extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:checkwegiht';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync data from Check weight to mainDB';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ini_set('memory_limit', '256M');

        $mechines = array(4, 1, 2, 3);

        foreach ($mechines as $mechine_id) {



            $mcheckweight = Mcheckweight::find($mechine_id);
            $str = $mcheckweight->desc;
            $dataweight = null;
            $Obj = CheckWeightData::where('mcheckweight_id', $mechine_id)->orderBy('id', 'desc')->first();
            $lastid = 0;
            if (empty($Obj)) {
                $lastid = 0;
            } else {
                $lastid = $Obj->report_id;
            }
            if ($str == 'WeightReport') {
                $dataweight = new WeightReport();
            } elseif ($str == 'Weight1Report') {
                $dataweight = new Weight1Report();
            } elseif ($str == 'Weight2Report') {
                $dataweight = new Weight2Report();
            } elseif ($str == 'Weight3Report') {
                $dataweight = new Weight3Report();
            }

            echo $lastid;

            $last = $dataweight::where('id', '>', $lastid)->count();
            $perpage = 100;

            $allpage = $last / $perpage;

            for ($i = 0; $i <= $allpage; $i++) {
                $datas = $dataweight
                    ->where('id', '>', $lastid)
                    ->orderBy('id', 'ASC')
                    ->offset($perpage * $i)
                    ->limit($perpage)
                    ->get();

                $maintmp = array();
                foreach ($datas as $dataOBj) {
                    $tmp = array();
                    $tmp['mcheckweight_id'] = $mechine_id;
                    $tmp['report_id'] = $dataOBj->id;
                    $tmp['datetime'] = $dataOBj->datetime;
                    $tmp['prod_name'] = $dataOBj->prod_name;
                    $tmp['cus_name'] = $dataOBj->cus_name;
                    $tmp['weight_st'] = $dataOBj->weight_st;
                    $tmp['weight_read'] = $dataOBj->weight_read;
                    $tmp['weight_check'] = $dataOBj->weight_check;
                    $tmp['code1_st'] = $dataOBj->code1_st;
                    $tmp['code1_read'] = $dataOBj->code1_read;
                    $tmp['code1_check'] = $dataOBj->code1_check;
                    $tmp['code2_st'] = $dataOBj->code2_st;
                    $tmp['code2_read'] = $dataOBj->code2_read;
                    $tmp['code2_check'] = $dataOBj->code2_check;
                    $tmp['overall_status'] = $dataOBj->overall_status;

                    $maintmp[] = $tmp;
                    //echo ".";
                }
                CheckWeightData::insert($maintmp);
                echo $i . ">";
            }
        }
        /*

        $mymech = $mcheckweight->desc;

        $last = WeightReport::count();
        $perpage = 100;

        $allpage = $last/$perpage;

        for ($i=0; $i <= $allpage; $i++) {
            $datas = Weight2Report::
                ->where('id','>')
                ->orderBy('id','ASC')
                ->offset($perpage* $i)
                ->limit($perpage)
                ->get();
            $maintmp = array();
            foreach ($datas as $dataOBj) {
                $tmp = array();
                $tmp['mcheckweight_id'] = $mechine_id;
                $tmp['report_id'] = $dataOBj->id;
                $tmp['datetime'] = $dataOBj->datetime ;
                $tmp[ 'prod_name'] = $dataOBj->prod_name;
                $tmp[ 'cus_name'] = $dataOBj->cus_name;
                $tmp[ 'weight_st'] = $dataOBj->weight_st;
                $tmp[ 'weight_read'] = $dataOBj->weight_read;
                $tmp[ 'weight_check'] = $dataOBj->weight_check;
                $tmp[ 'code1_st'] = $dataOBj->code1_st;
                $tmp[ 'code1_read'] = $dataOBj->code1_read;
                $tmp[ 'code1_check'] = $dataOBj->code1_check;
                $tmp[ 'code2_st'] = $dataOBj->code2_st;
                $tmp[ 'code2_read'] = $dataOBj->code2_read;
                $tmp[ 'code2_check'] = $dataOBj->code2_check;
                $tmp['overall_status'] = $dataOBj->overall_status;

                $maintmp[] = $tmp;
                //echo ".";
            }
            CheckWeightData::insert($maintmp);
            echo $i.">";
        }
        */
    }
}
