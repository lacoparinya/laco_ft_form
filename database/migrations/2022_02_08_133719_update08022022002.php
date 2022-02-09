<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update08022022002 extends Migration
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
                $table->string('front_stamp')->nullable();
                $table->string('front_locstamp')->nullable();
                $table->string('back_stamp')->nullable();
                $table->string('back_locstamp')->nullable();
            }
        );

        Schema::table(
            'package_infos',
            function (Blueprint $table) {
                $table->string('front_stamp')->nullable();
                $table->string('front_locstamp')->nullable();
                $table->string('back_stamp')->nullable();
                $table->string('back_locstamp')->nullable();
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
        if (Schema::hasColumn('pack_paper_packages', 'front_stamp')) {
            Schema::table('pack_paper_packages', function (Blueprint $table) {
                $table->dropColumn('product_fac');
            });
        }
        if (Schema::hasColumn('pack_paper_packages', 'front_locstamp')) {
            Schema::table('pack_paper_packages', function (Blueprint $table) {
                $table->dropColumn('product_fac');
            });
        }
        if (Schema::hasColumn('pack_paper_packages', 'back_stamp')) {
            Schema::table('pack_paper_packages', function (Blueprint $table) {
                $table->dropColumn('product_fac');
            });
        }
        if (Schema::hasColumn('pack_paper_packages', 'back_locstamp')) {
            Schema::table('pack_paper_packages', function (Blueprint $table) {
                $table->dropColumn('product_fac');
            });
        }
        if (Schema::hasColumn('package_infos', 'front_stamp')) {
            Schema::table('package_infos', function (Blueprint $table) {
                $table->dropColumn('product_fac');
            });
        }
        if (Schema::hasColumn('package_infos', 'front_locstamp')) {
            Schema::table('package_infos', function (Blueprint $table) {
                $table->dropColumn('product_fac');
            });
        }
        if (Schema::hasColumn('package_infos', 'back_stamp')) {
            Schema::table('package_infos', function (Blueprint $table) {
                $table->dropColumn('product_fac');
            });
        }
        if (Schema::hasColumn('package_infos', 'back_locstamp')) {
            Schema::table('package_infos', function (Blueprint $table) {
                $table->dropColumn('product_fac');
            });
        }
    }
}
