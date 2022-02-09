<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update31012022002 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'pack_paper_packages',
            function (Blueprint $table) {

                $table->string('pack_date_format', 50)->nullable();
                $table->string('exp_date_format', 50)->nullable();
        $table->string('extra_stamp', 100)->nullable();
        $table->string('front_img')->nullable();
        $table->string('back_img')->nullable();
            }
        );

        Schema::table(
            'pack_papers',
            function (Blueprint $table) {
                $table->string('cable_img')->nullable();
                $table->string('inbox_img')->nullable();
                $table->string('pallet_img')->nullable();
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
        if (Schema::hasColumn('pack_paper_packages', 'extra_stamp')) {
            Schema::table('pack_paper_packages', function (Blueprint $table) {
                $table->dropColumn('extra_stamp');
            });
        }
        if (Schema::hasColumn('pack_paper_packages', 'front_img')) {
            Schema::table('pack_paper_packages', function (Blueprint $table) {
                $table->dropColumn('front_img');
            });
        }
        if (Schema::hasColumn('pack_paper_packages', 'back_img')) {
            Schema::table('pack_paper_packages', function (Blueprint $table) {
                $table->dropColumn('back_img');
            });
        }
        if (Schema::hasColumn('pack_papers', 'cable_img')) {
            Schema::table('pack_papers', function (Blueprint $table) {
                $table->dropColumn('cable_img');
            });
        }
        if (Schema::hasColumn('pack_papers', 'inbox_img')) {
            Schema::table('pack_papers', function (Blueprint $table) {
                $table->dropColumn('inbox_img');
            });
        }
        if (Schema::hasColumn('pack_papers', 'pallet_img')) {
            Schema::table('pack_papers', function (Blueprint $table) {
                $table->dropColumn('pallet_img');
            });
        }
    }
}
