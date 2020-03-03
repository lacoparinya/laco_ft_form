<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogPstSelectDsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_pst_select_ds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('log_pst_select_m_id');
            $table->datetime('process_datetime');
            $table->float('workhours')->nullable();
            $table->float('input_kg')->nullable();
            $table->float('output_kg')->nullable();
            $table->float('sum_in_kg')->nullable();
            $table->float('sum_kg')->nullable();
            $table->float('yeild_percent')->nullable();
            $table->integer('num_classify')->nullable();
            $table->string('grade',20)->nullable();
            $table->string('ref_note',100)->nullable();
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
        Schema::dropIfExists('log_pst_select_ds');
    }
}
