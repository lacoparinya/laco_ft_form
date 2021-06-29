<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeedDropSelectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seed_drop_selects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shift_id');
            $table->date('check_date');
            $table->string('material');
            $table->float('input_w')->nullable();
            $table->float('output_w')->nullable();
            $table->float('incline_a')->nullable();
            $table->float('incline_m')->nullable();
            $table->float('beltrecheck_a')->nullable();
            $table->float('beltrecheck_m')->nullable();
            $table->float('beltautoweight_a')->nullable();
            $table->float('beltautoweight_m')->nullable();
            $table->float('underbelt_a')->nullable();
            $table->float('underbelt_m')->nullable();
            $table->float('total_a')->nullable();
            $table->float('total_m')->nullable();
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
        Schema::dropIfExists('seed_drop_selects');
    }
}
