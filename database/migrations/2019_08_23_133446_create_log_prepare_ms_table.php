<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogPrepareMsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_prepare_ms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pre_prod_id');
            $table->integer('std_pre_prod_id');
            $table->date('process_date');
            $table->float('targetperhr');
            $table->float('target_result');
            $table->float('target_workhours');
            $table->string('note');
            $table->string('status', 20);
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
        Schema::dropIfExists('log_prepare_ms');
    }
}
