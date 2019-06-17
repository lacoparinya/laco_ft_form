<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFtLogFreezesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ft_log_freezes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id');
            $table->date('process_date');
            $table->time('process_time');
            $table->float('workhours');
            $table->float('targets');
            $table->integer( 'iqf_job_id');
            $table->float('start_RM');
            $table->float('current_RM');
            $table->float('use_RM');
            $table->float('output_custom1');
            $table->float('output_custom2');
            $table->float('output_custom3');
            $table->float('output_custom4');
            $table->float('output_custom5');
            $table->float('output_custom6');
            $table->float('output_custom7');
            $table->float('output_custom8');
            $table->float('output_sum');
            $table->float('output_all_sum');
            $table->float('recv_RM');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ft_log_freezes');
    }
}
