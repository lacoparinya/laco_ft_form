<?php

namespace App\Console\Commands;

use App\Mail\FtDataEmail;
use App\FtLog;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class GenDailyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen:dailyreport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Daily Report';

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
        $emaillist = config('myconfig.emaillist');

        $obj = array();
        $current_date = date('Y-m-d', strtotime('-1 days'));

        $obj['subject'] = '[FT-Form] รายงานสรุปงานคัด ประจำวันที่ '. $current_date;


        
        $data = FtLog::where('process_date', $current_date)->orderBy('time_seq')->get();

        $obj['data'] = $data;

        Mail::to($emaillist)->send(new FtDataEmail($obj));

    }
}
