<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogPackDsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_pack_ds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('log_pack_m_id');
            $table->integer('shift_id');
            $table->datetime('process_datetime');
            $table->float('workhours');
            $table->float('output_pack');
            $table->float('output_pack_sum');
            $table->float('input_kg');
            $table->float('output_kg');
            $table->float('input_kg_sum');
            $table->float('output_kg_sum');
            $table->float('productivity');
            $table->float('yeild_percent');
            $table->float('num_pack');
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
        Schema::dropIfExists('log_pack_ds');
    }
}
