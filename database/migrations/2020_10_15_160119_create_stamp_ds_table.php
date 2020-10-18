<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStampDsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stamp_ds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stamp_m_id');
            $table->datetime('process_datetime');
            $table->float('output');
            $table->float('outputSum');
            $table->integer('staff_actual')->nullable();
            $table->string('note')->nullable();
            $table->string('problem')->nullable();
            $table->string('img_path',150)->nullable();
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
        Schema::dropIfExists('stamp_ds');
    }
}
