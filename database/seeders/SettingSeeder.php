<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Setting::truncate();

        DB::table('settings')->insert([
            'item' => "first_interval_cost",
            'value' => "0",
        ]);
        DB::table('settings')->insert([
            'item' => "increment_cost",
            'value' => "0",
        ]);
        DB::table('settings')->insert([
            'item' => "sock_cost",
            'value' => "0",
        ]);
        DB::table('settings')->insert([
            'item' => "water_cost",
            'value' => "0",
        ]);
        DB::table('settings')->insert([
            'item' => "first_interval_time",
            'value' => "0",
        ]);
        DB::table('settings')->insert([
            'item' => "additional_time",
            'value' => "0",
        ]);
        DB::table('settings')->insert([
            'item' => "isbill",
            'value' => "0",
        ]);
    }
}
