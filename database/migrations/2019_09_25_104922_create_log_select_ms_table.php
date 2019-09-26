<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogSelectMsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_select_ms', function (Blueprint $table) {
            $table->increments('id');
            $table->date('process_date');
            $table->integer('product_id');
            $table->integer('shift_id');
            $table->integer('std_process_id');
            $table->float('hourperday')->nullable();
            $table->float('targetperday')->nullable();
            $table->string('ref_note')->nullable();
            $table->string('note')->nullable();
            $table->string('status', 20);
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
        Schema::dropIfExists('log_select_ms');
    }
}
