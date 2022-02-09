<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PlanGroupSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plan_groups')->insert(['name' => 'japan', 'desc' => 'Japan', 'status' => 'Active']);
        DB::table('plan_groups')->insert(['name' => 'usa', 'desc' => 'USA', 'status' => 'Active']);
        DB::table('plan_groups')->insert(['name' => 'other', 'desc' => 'Other', 'status' => 'Active']);
    }
}
