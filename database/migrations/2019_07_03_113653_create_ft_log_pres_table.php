<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFtLogPresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ft_log_pres', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pre_prod_id');
            $table->integer('std_pre_prod_id');
            $table->date('process_date');
            $table->time('process_time');
            $table->integer('shift_id');
            $table->float('workhours');
            $table->float('targets');
            $table->float('input');
            $table->float('output');
            $table->float('input_sum');
            $table->float('output_sum');
            $table->integer('num_pre');
            $table->integer('num_iqf');
            $table->integer('num_all');
            $table->string('note');
            $table->string('status',20);
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
        Schema::dropIfExists('ft_log_pres');
    }
}
