<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFtLogIqfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ft_log_iqfs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id');
            $table->date('process_date');
            $table->integer('timeslot_id');
            $table->integer('time_seq');
            $table->float('workhours');
            $table->integer('shift_id');
            $table->integer('mechine_id');
            $table->integer('iqf_job_id');
            $table->float('input_kg');
            $table->float('output_kg');
            $table->integer('num_man');
            $table->float('manhours');
            $table->float('productivity');
            $table->text('note');
            $table->integer('std_iqf_id');
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
        Schema::dropIfExists('ft_log_iqfs');
    }
}
