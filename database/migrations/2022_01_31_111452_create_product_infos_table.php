<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_infos', function (Blueprint $table) {
            $table->increments('id');         
            $table->integer('packaging_id')->nullable();
            $table->string('cable_img')->nullable();
            $table->string('inbox_img')->nullable();
            $table->string('pallet_img')->nullable();
            $table->string('artwork_img')->nullable();            
            $table->string('product_fac')->nullable();
            $table->integer('pallet_base')->nullable();
            $table->integer('pallet_low')->nullable();
            $table->integer('pallet_height')->nullable();
            $table->string('pack_thai_year',10)->nullable();
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
        Schema::dropIfExists('product_infos');
    }
}
