<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update31012022 extends Migration
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
                $table->string('weight_with_bag')->nullable();
            }
        );

        if (Schema::hasColumn('pack_paper_packages', 'pack_date_format')) {
            Schema::table('pack_paper_packages', function (Blueprint $table) {
                $table->dropColumn('pack_date_format');
            });
        }

        if (Schema::hasColumn('pack_paper_packages', 'exp_date_format')) {
            Schema::table('pack_paper_packages', function (Blueprint $table) {
                $table->dropColumn('exp_date_format');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('pack_papers', 'weight_with_bag')) {
            Schema::table('pack_papers', function (Blueprint $table) {
                $table->dropColumn('weight_with_bag');
            });
        }
    }
}
