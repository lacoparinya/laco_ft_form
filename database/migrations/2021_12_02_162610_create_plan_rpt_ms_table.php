<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanRptMsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_rpt_ms', function (Blueprint $table) {
            $table->increments('id');
            $table->date('enter_date');
            $table->integer('month');
            $table->integer('year');
            $table->string('note',1000)->nullable();
            $table->string('status', 50)->default('Active');
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
        Schema::dropIfExists('plan_rpt_ms');
    }
}
