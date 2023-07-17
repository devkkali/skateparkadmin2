<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Http\Requests\ParkingInRequest;
use App\Models\History;
use App\Models\ParkingIn;
use App\Models\ParkingInGroup;
use App\Models\Setting;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ParkInController extends Controller
{
    //
    public function ParkinCheck($card_id)
    {
        try {

            #check if card is package, member or normal
            #check if card is in or out


            #return card type
            #return if card is expired or not
            #return validity time period
            #return pending payment


            $card_status = Helper::GetCardStatus($card_id);
            // return $card_status;
            $card_status = Arr::add($card_status, 'card_id', $card_id);



            // $card['isin']=0;
            if (Helper::isIn($card_id)) {
                $card_status = Arr::add($card_status, 'isin', 1);
            } else {
                $card_status = Arr::add($card_status, 'isin', 0);
            }

            // return $card_status;


            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => $card_status,
            ], 200);
        } catch (\Exception $exception) {
            $error_type['error'] = $exception;
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }
    }

    public function Parkin(ParkingInRequest $request, $card_id)
    {
        #check if card is member, package, normal
        #
        $first_interval_cost = Setting::where('item', 'first_interval_cost')->first();
        $increment_cost = Setting::where('item', 'increment_cost')->first();
        $sock_cost = Setting::where('item', 'sock_cost')->first();
        $water_cost = Setting::where('item', 'water_cost')->first();
        $first_interval_time = Setting::where('item', 'first_interval_time')->first();
        $additional_time = Setting::where('item', 'additional_time')->first();
        $isbill = Setting::where('item', 'isbill')->first();


        $card_status = Helper::GetCardStatus($card_id);
        // return $card_status['type'];
        if ($card_status['type'] == 'no') {
            $error_type['card'] = ['Card not found'];
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }

        if ($card_status['type'] == 'normal') {
            $name_of_client = $request->input('name', 'Anonymous');
            $phone_no_of_client = $request->input('phone_no', '0');
            $no_client = $request->input('no_of_client');
            $deposit = $request->input('deposit', 0);
            if ($request->input('deposit') == "") {
                $deposit = 0;
            }
        } else {
            $name_of_client = $card_status['name'];
            $phone_no_of_client = $card_status['phone'];
            $no_client = 1;
            $deposit = $request->input('deposit');
            if ($card_status['type'] == 'package' || $request->input('deposit') == "") {
                $deposit = 0;
            }
        }



        // return $no_client;

        if ($card_status['type'] != 'normal') {
            // $no_client = 1;
            if ($card_status['expired'] == 1) {
                $error_type['expired'] = ['Card is Expired'];
                $response = response()->json([
                    'error' => 'true',
                    'message' => 'Invalid data sent',
                    "details" => $error_type,
                ], 422);
                return $response;
            }
        }

        if (Helper::isIn($card_id)) {
            $error_type['card'] = ['Card is Already inside'];
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }


        try {

            try {
                $park = ParkingIn::create([
                    'card_id' => $card_id,
                    'name' => $name_of_client,
                    'phone_no' => $phone_no_of_client,
                    'deposite' => $deposit,
                    'in_time' => Carbon::now(),
                    'paid_amount' => 0,
                    'sock_cost_at_time' => $sock_cost['value'],
                    'water_cost_at_time' => $water_cost['value'],
                    'socks' => $request->input('socks', 0),
                    'water' => 0,
                    'no_of_client' => $no_client,
                ]);
            } catch (\Exception $exception) {
                $error_type['error'] = $exception;
                $response = response()->json([
                    'error' => 'true',
                    'message' => 'Invalid data sent',
                    "details" => $error_type,
                ], 422);
                return $response;
            }

            try {
                $count = $park->no_of_client;

                // return $count;

                for ($i = 0; $i < $count; $i++) {
                    // echo 'hi';
                    $parkInGroup = ParkingInGroup::create([
                        'parking_in_id' => $park->id,
                        'in_time' => Carbon::now(),
                        'out_time' => null,
                        'interval' => null,

                    ]);
                }



                $inputSuggestion = Helper::PostSuggestionList($name_of_client, $phone_no_of_client);

                return response()->json([
                    'error' => 'false',
                    'message' => 'success',
                    'details' => "",
                ], 200);
            } catch (\Exception $exception) {
                $park->delete();
                $error_type['error'] = $exception;
                $response = response()->json([
                    'error' => 'true',
                    'message' => 'Invalid data sent 2',
                    "details" => $error_type,
                ], 422);
                return $response;
            }
        } catch (\Exception $exception) {
            $error_type['error'] = $exception;
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }
    }

    public function ParkoutAddPlayer($card_id)
    {
        try {
            $card_status = Helper::GetCardStatus($card_id);
            $card_id_original = ParkingIn::where('card_id', $card_id)->first();

            if (Helper::isIn($card_id)) {
                $card_status = Arr::add($card_status, 'isin', 1);
            } else {
                $error_type['error'] = 'card is not inside';
                $response = response()->json([
                    'error' => 'true',
                    'message' => 'Invalid data sent',
                    "details" => $error_type,
                ], 422);
                return $response;
            }
            // return $card_status['id'];

            try {
                // echo $card_status['id'];
                if ($card_status['type'] == 'normal') {
                    // return $card_status;
                    $parkInGroup = ParkingInGroup::create([
                        'parking_in_id' => $card_id_original['id'],
                        'in_time' => Carbon::now(),
                        'out_time' => null,
                        'interval' => null,
                    ]);
                    $card_id_original->no_of_client = $card_id_original['no_of_client'] + 1;
                    $card_id_original->save();
                }
            } catch (\Exception $exception) {
                $error_type['error'] = $exception;
                $response = response()->json([
                    'error' => 'true',
                    'message' => 'Invalid data sent2',
                    "details" => $error_type,
                ], 422);
                return $response;
            }



            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => $card_status,
            ], 200);
        } catch (\Exception $exception) {
            $error_type['error'] = $exception;
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }
    }

    public function ParkoutDeletePlayer($player_id)
    {

        try {
            $player = ParkingInGroup::where('id', '=', $player_id)->first();
            if ($player != null) {
                $card_id_original = ParkingIn::where('id', $player->parking_in_id)->first();
                $card_id_original->no_of_client = $card_id_original['no_of_client'] - 1;
                $card_id_original->save();

                $player->delete();
                return response()->json([
                    'error' => 'false',
                    'message' => 'success',
                    'details' => '',
                ], 200);
            }
        } catch (\Exception $exception) {
            $error_type['error'] = $exception;
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }
    }


    public function ParkoutCheck($card_id)
    {
        try {

            $card_status = Helper::GetCardStatus($card_id);

            // return $card_status;

            if (Helper::isIn($card_id)) {
                $card_status = Arr::add($card_status, 'isin', 1);
            } else {
                $error_type['error'] = ['card is not inside'];
                $response = response()->json([
                    'error' => 'true',
                    'message' => 'Invalid data sent 1',
                    "details" => $error_type,
                ], 422);
                return $response;
            }

            // return $card_status;

            switch ($card_status['type']) {
                case ('package'):
                    $cost_detail = Helper::CostCalculation('package', $card_id);
                    // return $cost_detail;
                    break;
                case ('membership'):
                    $cost_detail = Helper::CostCalculation('membership', $card_id);
                    // return $cost_detail;
                    break;
                case ('normal'):
                    $cost_detail = Helper::CostCalculation('normal', $card_id);
                    // return $cost_detail;
                    break;
                default:
                    return 'asdf';
            }


            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => $cost_detail,
            ], 200);
        } catch (\Exception $exception) {
            $error_type['error'] = $exception;
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent 2',
                "details" => $error_type,
            ], 422);
            return $response;
        }
    }

    public function ParkingOutSinglePlayer($player_id)
    {
        try {
            $player = ParkingInGroup::where('id', '=', $player_id)->first();
            if ($player == null) {
                $error_type['card'] = ['Card not found'];
                $response = response()->json([
                    'error' => 'true',
                    'message' => 'Invalid data sent',
                    "details" => $error_type,
                ], 422);
                return $response;
            }

            if ($player->out_time == null) {

                $player->out_time = Carbon::now();

                $interval = CarbonInterval::seconds(Carbon::now()->diffInSeconds($player->in_time))->cascade();

                $player->interval = $interval->d . "d : " . $interval->h . "h : " . $interval->i . "m : " . $interval->s . "s";

                $player->save();
                return response()->json([
                    'error' => 'false',
                    'message' => 'success',
                    'details' => '',
                ], 200);
            } else {

                $error_type['out'] = ['Already out'];
                $response = response()->json([
                    'error' => 'true',
                    'message' => 'Invalid data sent',
                    "details" => $error_type,
                ], 422);
                return $response;
            }
        } catch (\Exception $exception) {
            $error_type['error'] = $exception;
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }
    }



    public function ParkingOutAddWater($card_id, Request $request)
    {
        if ($request->input('value') == "" || $request->input('value') < 0) {
            $error_type['add_water'] = ['Please enter valid data'];
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }
        try {
            $park = ParkingIn::where("card_id", $card_id)->first();
            $oldwater = $park->water;
            $park->water = $oldwater + $request->input("value");
            $park->save();

            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => "",
            ], 200);
        } catch (\Exception $exception) {
            $error_type['error'] = $exception;
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }
    }

    public function ParkingOutEditWater($card_id, Request $request)
    {
        if ($request->input('value') == "" || $request->input('value') < 0) {
            $error_type['edit_water'] = ['Please enter valid data'];
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }

        try {
            $park = ParkingIn::where("card_id", $card_id)->first();
            $park->water = $request->input("value");
            $park->save();

            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => "",
            ], 200);
        } catch (\Exception $exception) {
            $error_type['error'] = $exception;
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }
    }



    public function ParkingOutAddSocks($card_id, Request $request)
    {
        if ($request->input('value') == "" || $request->input('value') < 0) {
            $error_type['add_socks'] = ['Please enter valid data'];
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }
        try {
            $park = ParkingIn::where("card_id", $card_id)->first();
            $oldsocks = $park->socks;
            $park->socks = $oldsocks + $request->input("value");
            $park->save();

            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => "",
            ], 200);
        } catch (\Exception $exception) {
            $error_type['error'] = $exception;
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }
    }

    public function ParkingOutEditSocks($card_id, Request $request)
    {
        if ($request->input('value') == "" || $request->input('value') < 0) {
            $error_type['edit_socks'] = ['Please enter valid data'];
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }

        try {
            $park = ParkingIn::where("card_id", $card_id)->first();
            $park->socks = $request->input("value");
            $park->save();

            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => "",
            ], 200);
        } catch (\Exception $exception) {
            $error_type['error'] = $exception;
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }
    }



    public function ParkingOutAddDeposit($card_id, Request $request)
    {
        if ($request->input('value') == "" || $request->input('value') < 0) {
            $error_type['add_deposit'] = ['Please enter valid data'];
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }
        try {
            $park = ParkingIn::where("card_id", $card_id)->first();
            $olddeposit = $park->deposite;
            $park->deposite = $olddeposit + $request->input("value");
            $park->save();

            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => "",
            ], 200);
        } catch (\Exception $exception) {
            $error_type['error'] = $exception;
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }
    }

    public function ParkingOutEditDeposit($card_id, Request $request)
    {
        if ($request->input('value') == "" || $request->input('value') < 0) {
            $error_type['edit_deposit'] = ['Please enter valid data'];
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }
        try {
            $park = ParkingIn::where("card_id", $card_id)->first();
            $park->deposite = $request->input("value");
            $park->save();

            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => "",
            ], 200);
        } catch (\Exception $exception) {
            $error_type['error'] = $exception;
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }
    }


    public function ParkingOutFinal($card_id, Request $request)
    {
        try {
            $card_status = Helper::GetCardStatus($card_id);
            if (Helper::isIn($card_id)) {
                $card_status = Arr::add($card_status, 'isin', 1);
            } else {
                $error_type['error'] = ['card is not inside'];
                $response = response()->json([
                    'error' => 'true',
                    'message' => 'Invalid data sent',
                    "details" => $error_type,
                ], 422);
                return $response;
            }

            switch ($card_status['type']) {
                case ('package'):
                    $cost_detail = Helper::CostCalculation('package', $card_id);
                    // return $cost_detail;
                    break;
                case ('membership'):
                    $cost_detail = Helper::CostCalculation('membership', $card_id);
                    // return $cost_detail;
                    break;
                case ('normal'):
                    $cost_detail = Helper::CostCalculation('normal', $card_id);
                    // return $cost_detail;
                    break;
                default:
                    return 'asdf';
            }
            // return $cost_detail;

            try {

                $interval = CarbonInterval::seconds(Carbon::now()->diffInSeconds($cost_detail["in_time"]))->cascade();
                $intervalToSave = $interval->d . "d : " . $interval->h . "h : " . $interval->i . "m : " . $interval->s . "s";

                $History = History::create([

                    'recorded_time' => Carbon::now(),
                    'card_id' => $cost_detail["card_id"],
                    'name' => $cost_detail["name"],
                    'phone_no' => $cost_detail["phone_no"],
                    'no_of_client' => $cost_detail["no_of_client"],
                    'socks' => $cost_detail["socks"],
                    'sock_cost_at_time' => $cost_detail["socks_cost_at_time"],
                    'sock_cost_total' =>  $cost_detail["socks"] * $cost_detail["socks_cost_at_time"],
                    'water' => $cost_detail["waters"],
                    'water_cost_at_time' => $cost_detail["water_cost_at_time"],
                    'water_cost_total' =>  $cost_detail["waters"] * $cost_detail["water_cost_at_time"],
                    'in_time' =>  $cost_detail["in_time"],
                    'out_time' =>  Carbon::now(),
                    'interval' =>  $intervalToSave,
                    'paid_amount' =>  $request->input('paid_amount'),

                ]);

                $delCard = ParkingIn::where("card_id", $card_id)->first();
                $delCard->delete();

                return response()->json([
                    'error' => 'false',
                    'message' => 'success',
                    'details' => "",
                ], 200);
            } catch (\Exception $exception) {
                $error_type['error'] = $exception;
                $response = response()->json([
                    'error' => 'true',
                    'message' => 'Invalid data sent',
                    "details" => $error_type,
                ], 422);
                return $response;
            }






















            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => $cost_detail,
            ], 200);
        } catch (\Exception $exception) {
            $error_type['error'] = $exception;
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }
    }


















    public function cost(Request $request)
    {
        return Helper::calculate_time_cost($request->input('total_time_in_min'), $request->input('first_interval_cost'), $request->input('increment_interval_cost'), $request->input('first_interval'), $request->input('extra_interval'));
    }
}
