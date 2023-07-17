<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class NormalCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::truncate();

        for ($i = 1; $i <= 200 ; $i++) {
            if($i != 1 && $i != 2 && $i != 3 && $i != 4 && $i != 5 && $i != 100 )
            DB::table('normal_cards')->insert([
                'card_id' => $i,
            ]);
        }
    }
}
