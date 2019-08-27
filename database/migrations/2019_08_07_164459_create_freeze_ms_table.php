<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreezeMsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freeze_ms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id');
            $table->date('process_date');
            $table->float('targets');
            $table->integer('iqf_job_id');
            $table->float('start_RM');
            $table->float('recv_RM');
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
        Schema::dropIfExists('freeze_ms');
    }
}
