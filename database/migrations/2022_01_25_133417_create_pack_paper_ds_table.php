<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackPaperDsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pack_paper_ds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pack_paper_id');
            $table->date('pack_date')->nullable();
            $table->date('exp_date')->nullable();
            $table->string('weight_with_bag', 150)->nullable();
            $table->float('all_weight')->nullable();
            $table->integer('all_bpack')->nullable();
            $table->string('cablecover',100)->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('pack_paper_ds');
    }
}
