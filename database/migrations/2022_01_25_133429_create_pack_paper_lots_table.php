<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackPaperLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pack_paper_lots', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pack_paper_id');
            $table->date('pack_date')->nullable();
            $table->date('exp_date')->nullable();
            $table->string('lot',50)->nullable();
            $table->integer('frombox')->nullable();
            $table->integer('tobox')->nullable();
            $table->integer('nbox')->nullable();
            $table->integer('nbag')->nullable();
            $table->float('pweight')->nullable();
            $table->float('fweight')->nullable();
            $table->integer('pallet')->nullable();
            $table->integer('pbag')->nullable();
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
        Schema::dropIfExists('pack_paper_lots');
    }
}
