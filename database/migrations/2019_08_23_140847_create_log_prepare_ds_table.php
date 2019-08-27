<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogPrepareDsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_prepare_ds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('log_prepare_m_id');
            $table->integer('pre_prod_id');
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
        Schema::dropIfExists('log_prepare_ds');
    }
}
