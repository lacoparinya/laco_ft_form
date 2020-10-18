<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStampMsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stamp_ms', function (Blueprint $table) {
            $table->increments('id');
            $table->date('process_date');
            $table->integer('shift_id');
            $table->integer('mat_pack_id');
            $table->integer('stamp_machine_id');
            $table->float('rateperhr')->nullable();
            $table->string('order_no',150)->nullable();
            $table->date('pack_date')->nullable();
            $table->integer('staff_target')->nullable();
            $table->string('staff_operate', 150)->nullable();
            $table->integer('staff_actual')->nullable();
            $table->string('note', 250)->nullable();
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
        Schema::dropIfExists('stamp_ms');
    }
}
