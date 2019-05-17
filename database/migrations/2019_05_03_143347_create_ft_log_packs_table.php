<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFtLogPacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ft_log_packs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id');
            $table->date('process_date');
            $table->integer('timeslot_id');
            $table->integer('time_seq');
            $table->integer('shift_id');
            $table->integer('method_id');
            $table->integer('package_id');
            $table->integer('order_id');
            $table->integer('std_pack_id');
            $table->float('output_pack');
            $table->float('output_pack_sum');
            $table->float('input_kg');
            $table->float('output_kg');
            $table->float('input_kg_sum');
            $table->float('output_kg_sum');
            $table->float('productivity');
            $table->float('yeild_percent');
            $table->integer('num_pack');
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
        Schema::dropIfExists('ft_log_packs');
    }
}
