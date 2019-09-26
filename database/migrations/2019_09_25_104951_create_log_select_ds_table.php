<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogSelectDsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_select_ds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('log_select_m_id');
            $table->datetime('process_datetime');
            $table->float('workhours');
            $table->float('input_kg');
            $table->float('output_kg');
            $table->float('sum_in_kg');
            $table->float('sum_kg');
            $table->float('yeild_percent');
            $table->integer('num_pk');
            $table->integer('num_pf');
            $table->integer('num_pst');
            $table->integer('num_classify');
            $table->integer('line_a')->nullable();
            $table->integer('line_b')->nullable();
            $table->integer('line_classify')->nullable();
            $table->integer('line_classify_unit')->nullable();
            $table->string('grade')->nullable();
            $table->string('ref_note')->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('log_select_ds');
    }
}
