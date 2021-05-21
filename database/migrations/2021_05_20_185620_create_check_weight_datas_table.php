<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckWeightDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_weight_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mcheckweight_id');
            $table->integer('report_id');
            $table->datetime('datetime')->nullable();
            $table->string('prod_name',100)->nullable();
            $table->string('cus_name',100)->nullable();
            $table->float('weight_st')->nullable();
            $table->float('weight_read')->nullable();
            $table->string('weight_check',100)->nullable();
            $table->string('code1_st',100)->nullable();
            $table->string('code1_read',100)->nullable();
            $table->string('code1_check',100)->nullable();
            $table->string('code2_st',100)->nullable();
            $table->string('code2_read',100)->nullable();
            $table->string('code2_check',100)->nullable();
            $table->string('overall_status',100)->nullable();
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
        Schema::dropIfExists('check_weight_datas');
    }
}
