<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pack_papers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('packaging_id')->nullable();
            $table->string('order_no',100)->nullable();
            $table->integer('exp_month')->nullable();
            $table->string('weight_with_bag')->nullable();
            $table->string('cable_img')->nullable();
            $table->string('inbox_img')->nullable();
            $table->string('pallet_img')->nullable();
            $table->string('artwork_img')->nullable();
            $table->string('product_fac')->nullable();
            $table->date('loading_date')->nullable();
            $table->integer('pallet_base')->nullable();
            $table->integer('pallet_low')->nullable();
            $table->integer('pallet_height')->nullable();
            $table->string('pack_thai_year',10)->nullable();
            $table->integer('revise_version')->nullable();
            $table->integer('relation_id')->nullable();
            $table->string('status', 50)->default('Active');
            $table->string('plan_version', 100);
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
        Schema::dropIfExists('pack_papers');
    }
}
