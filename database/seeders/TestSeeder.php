<?php

namespace Database\Seeders;

use App\Models\ParkingIn;
use App\Models\ParkingInGroup;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 20000; $i++) {

            DB::table('normal_cards')->insert([
                'card_id' => $i,
            ]);
        }
        for ($i = 1; $i <= 20000; $i++) {

            $park = ParkingIn::create([
                'card_id' => $i,
                'name' => "a",
                'phone_no' => "a",
                'deposite' => 200,
                'in_time' => Carbon::now(),
                'paid_amount' => 0,
                'sock_cost_at_time' => 0,
                'water_cost_at_time' => 0,
                'socks' => 0,
                'water' => 0,
                'no_of_client' => 1,
            ]);


            // echo 'hi';
            $parkInGroup = ParkingInGroup::create([
                'parking_in_id' => $park->id,
                'in_time' => Carbon::now(),
                'out_time' => null,
                'interval' => null,

            ]);
        }
    }
}
