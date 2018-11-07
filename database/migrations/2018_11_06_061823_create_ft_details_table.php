<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFtDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ft_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ft_master_id');
            $table->integer('shift_id');
            $table->time('process_time');
            $table->float('input_kg');
            $table->float('output_kg');
            $table->float('sum_kg');
            $table->float('yeild_precent');
            $table->integer('num_pk');
            $table->integer('num_pf');
            $table->integer('num_pst');
            $table->integer('num_classify');
            $table->integer('line_a');
            $table->integer('line_b');
            $table->integer('line_classify');
            $table->integer('line_classify_unit');
            $table->text('note');
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
        Schema::dropIfExists('ft_details');
    }
}
