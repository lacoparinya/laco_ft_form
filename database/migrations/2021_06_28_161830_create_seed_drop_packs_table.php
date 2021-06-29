<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeedDropPacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seed_drop_packs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('method_id');
            $table->integer('shift_id');
            $table->date('check_date');
            $table->float('cabin')->nullable();
            $table->float('belt_start')->nullable();
            $table->float('belt_Intralox')->nullable();
            $table->float('weight_head')->nullable();
            $table->float('pack_part')->nullable();
            $table->float('shaker')->nullable();
            $table->float('table')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('seed_drop_packs');
    }
}
