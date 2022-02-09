<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanRptDsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_rpt_ds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('plan_rpt_m_id');
            $table->integer('plan_group_id');
            $table->integer('num_delivery_plan')->nullable();
            $table->integer('num_confirm')->nullable();
            $table->integer('num_packed')->nullable();
            $table->integer('num_wait')->nullable();
            $table->integer('num_unconfirm')->nullable();
            $table->integer('num_unpacked')->nullable();
            $table->string('note', 1000)->nullable();
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
        Schema::dropIfExists('plan_rpt_ds');
    }
}
