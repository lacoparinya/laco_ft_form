<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update08022022001 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'pack_papers',
            function (Blueprint $table) {
                $table->string('product_fac')->nullable();
                $table->date('loading_date')->nullable();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        if (Schema::hasColumn('pack_papers', 'product_fac')) {
            Schema::table('pack_papers', function (Blueprint $table) {
                $table->dropColumn('product_fac');
            });
        }
        if (Schema::hasColumn('pack_papers', 'loading_date')) {
            Schema::table('pack_papers', function (Blueprint $table) {
                $table->dropColumn('loading_date');
            });
        }
    }
}
