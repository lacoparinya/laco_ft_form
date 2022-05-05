<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackPaperPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pack_paper_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pack_paper_id');
            $table->integer('packaging_id');
            $table->string('lot', 50)->nullable();
            $table->string('pack_date_format', 50)->nullable();
            $table->string('exp_date_format', 50)->nullable();
            $table->string('extra_stamp', 100)->nullable();
            $table->string('front_img')->nullable();
            $table->string('back_img')->nullable();
            $table->string('front_stamp')->nullable();
            $table->string('front_locstamp')->nullable();
            $table->string('back_stamp')->nullable();
            $table->string('back_locstamp')->nullable();

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
        Schema::dropIfExists('pack_paper_packages');
    }
}
