<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreezeDsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freeze_ds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('freeze_m_id');
            $table->datetime('process_datetime');
            $table->float('current_RM');
            $table->float('use_RM');
            $table->float('output_custom1');
            $table->float('output_custom2');
            $table->float('output_custom3');
            $table->float('output_custom4');
            $table->float('output_custom5');
            $table->float('output_custom6');
            $table->float('output_custom7');
            $table->float('output_custom8');
            $table->float('output_sum');
            $table->float('output_all_sum');
            $table->string('note');
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
        Schema::dropIfExists('freeze_ds');
    }
}
