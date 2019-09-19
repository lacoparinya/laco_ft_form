<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogPackMsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_pack_ms', function (Blueprint $table) {
            $table->increments('id');
            $table->date('process_date');
            $table->integer('method_id');
            $table->integer('package_id');
            $table->integer('order_id');
            $table->integer('std_pack_id');
            $table->float('overalltargets');
            $table->float('targetperday');
            $table->float('houroverall');;
            $table->float('hourperday');
            $table->string('note');
            $table->string('status',20);
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
        Schema::dropIfExists('log_pack_ms');
    }
}
