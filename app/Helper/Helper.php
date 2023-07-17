<?php

namespace App\Helper;

use App\Models\Dictionary;
use App\Models\MembershipUser;
use App\Models\NormalCard;
use App\Models\PackageTaken;
use App\Models\PackageUser;
use App\Models\ParkingIn;
use App\Models\Setting;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class Helper
{

    public static function CostCalculation($type, $card_id)
    {
        $first_interval_cost = Setting::where('item', 'first_interval_cost')->first();
        $increment_cost = Setting::where('item', 'increment_cost')->first();
        $first_interval_time = Setting::where('item', 'first_interval_time')->first();
        $additional_time = Setting::where('item', 'additional_time')->first();

        


        switch ($type) {
            case ('package'):
                $pa = PackageUser::with('packageTaken')->where('card_id', $card_id)->first()->toArray();
                $package_status['card_id'] = $card_id;
                $package_status['type'] = 'package';
                $cost = last($pa['package_taken'])['cost'];
                $package_status['cost'] = $cost;
                $paid = last($pa['package_taken'])['paid'];
                $package_status['paid'] = $paid;
                $package_status['amount'] = 0;

                if ($paid < $cost) {
                    $package_status['remaining_payment'] = $cost - $paid;
                } else {
                    $package_status['remaining_payment'] = 0;
                }
                $exp_date = Carbon::parse(last($pa['package_taken'])['end_date']);
                if (Carbon::now() < $exp_date) {
                    $package_status['expired'] = 0;
                    $package_status['remaining_days'] = $exp_date->diffForHumans(Carbon::now());
                } else {
                    $package_status['expired'] = 1;
                    $package_status['remaining_days'] = $exp_date->diffForHumans(Carbon::now());
                }

                $parking_in_data = ParkingIn::with('parkingInGroup')
                    ->where('card_id', $card_id)
                    ->first()
                    ->toArray();
                $package_status['in_time'] = $parking_in_data['in_time'];
                $total_time = Carbon::now()->diffInMinutes(Carbon::parse($parking_in_data['in_time']));
                $sock_cost_at_time = (int)$parking_in_data['sock_cost_at_time'];
                $socks = (int)$parking_in_data['socks'];
                $water_cost_at_time = (int)$parking_in_data['water_cost_at_time'];
                $water = (int)$parking_in_data['water'];

                $package_status['socks'] = $socks;
                $package_status['socks_total'] = $sock_cost_at_time * $socks;
                $package_status['waters'] = $water;
                $package_status['water_total'] = $water_cost_at_time * $water;
                $package_status['socks_cost_at_time']=$sock_cost_at_time;
                $package_status['water_cost_at_time']=$water_cost_at_time;

                $package_status['name'] = $parking_in_data['name'];
                $package_status['phone_no'] = $parking_in_data['phone_no'];
                $package_status['entry_date_time'] = $parking_in_data['in_time'];
                $package_status['deposit'] = $parking_in_data['deposite'];
                $package_status['no_of_client'] = $parking_in_data['no_of_client'];


                $time_cost = 0;
                $i = 0;
                $players = $parking_in_data['parking_in_group'];

                foreach ($players as $key => $player) {
                    // echo $i;
                    $p[$key]['id'] = $player['id'];
                    $p[$key]['player_in_id'] = $player['parking_in_id'];
                    $p[$key]['in_time'] = $player['in_time'];
                    $p[$key]['out_time'] = $player['out_time'];

                    if ($player['interval'] != null) {
                        $p[$key]['interval'] = $player['interval'];
                    } else {
                        $interval = CarbonInterval::seconds(Carbon::now()->diffInSeconds($player['in_time']))->cascade();
                        
                        $p[$key]['interval'] = $interval->d."d : ".$interval->h."h : ".$interval->i."m : ".$interval->s."s";                    
                    }
                    if ($player['out_time'] != null) {
                        $p[$key]['total_time'] = Carbon::parse($player['out_time'])->diffInMinutes(Carbon::parse($player['in_time']));
                    } else {
                        $p[$key]['total_time'] = Carbon::now()->diffInMinutes(Carbon::parse($player['in_time']));
                    }
                    $p[$key]['time_cost'] = 0;





                    // $package_status['total_time' . $i] = Carbon::now()->diffInMinutes(Carbon::parse($player['in_time']));
                    $time_cost = 0;
                    $i++;
                    // echo'hi';
                }

                $package_status['time_cost'] = 0;
                $package_status['total'] = $package_status['time_cost'] + $package_status['water_total'] + $package_status['socks_total'];

                $package_status = Arr::add($package_status, 'players', $p);

                return $package_status;

                break;
            case ('membership'):
                $m = MembershipUser::with('membershipTaken')->where('card_id', $card_id)->first()->toArray();
                $membership_status['card_id'] = $card_id;
                $membership_status['type'] = 'membership';
                $cost = last($m['membership_taken'])['cost'];
                $membership_status['cost'] = $cost;
                $amount = last($m['membership_taken'])['paid'];
                $membership_status['paid'] = '';
                $membership_status['amount'] = $amount;

                // if ($paid < $cost) {
                //     $membership_status['remaining_payment'] = $cost - $paid;
                // } else {
                $membership_status['remaining_payment'] = 0;
                // }
                $exp_date = Carbon::parse(last($m['membership_taken'])['end_date']);
                if (Carbon::now() < $exp_date) {
                    $membership_status['expired'] = 0;
                    $membership_status['remaining_days'] = $exp_date->diffForHumans(Carbon::now());
                } else {
                    $membership_status['expired'] = 1;
                    $membership_status['remaining_days'] = $exp_date->diffForHumans(Carbon::now());
                }
                $parking_in_data = ParkingIn::with('parkingInGroup')
                    ->where('card_id', $card_id)
                    ->first()
                    ->toArray();
                $membership_status['in_time'] = $parking_in_data['in_time'];
                $total_time = Carbon::now()->diffInMinutes(Carbon::parse($parking_in_data['in_time']));
                $sock_cost_at_time = (int)$parking_in_data['sock_cost_at_time'];
                $socks = (int)$parking_in_data['socks'];
                $water_cost_at_time = (int)$parking_in_data['water_cost_at_time'];
                $water = (int)$parking_in_data['water'];


                $membership_status['socks'] = $socks;
                $membership_status['socks_total'] = $sock_cost_at_time * $socks;
                $membership_status['waters'] = $water;
                $membership_status['water_total'] = $water_cost_at_time * $water;
                $membership_status['socks_cost_at_time']=$sock_cost_at_time;
                $membership_status['water_cost_at_time']=$water_cost_at_time;


                $membership_status['name'] = $parking_in_data['name'];
                $membership_status['phone_no'] = $parking_in_data['phone_no'];
                $membership_status['entry_date_time'] = $parking_in_data['in_time'];
                $membership_status['deposit'] = $parking_in_data['deposite'];
                $membership_status['no_of_client'] = $parking_in_data['no_of_client'];






                $time_cost = 0;
                $i = 0;
                $players = $parking_in_data['parking_in_group'];

                foreach ($players as $key => $player) {
                    // echo $i;
                    $p[$key]['id'] = $player['id'];
                    $p[$key]['player_in_id'] = $player['parking_in_id'];
                    $p[$key]['in_time'] = $player['in_time'];
                    $p[$key]['out_time'] = $player['out_time'];
                    // $p[$key]['interval'] = $player['interval'];
                    // $p[$key]['total_time'] = Carbon::now()->diffInMinutes(Carbon::parse($player['in_time']));

                    if ($player['interval'] != null) {
                        $p[$key]['interval'] = $player['interval'];
                    } else {

                        $interval = CarbonInterval::seconds(Carbon::now()->diffInSeconds($player['in_time']))->cascade();
                        
                        $p[$key]['interval'] = $interval->d."d : ".$interval->h."h : ".$interval->i."m : ".$interval->s."s";
                    
                    }
                    if ($player['out_time'] != null) {
                        $p[$key]['total_time'] = Carbon::parse($player['out_time'])->diffInMinutes(Carbon::parse($player['in_time']));
                    } else {
                        $p[$key]['total_time'] = Carbon::now()->diffInMinutes(Carbon::parse($player['in_time']));
                    }
                    $p[$key]['time_cost'] = self::calculate_time_cost($p[$key]['total_time'], $amount, $amount, 60, 10);



                    // $package_status['total_time' . $i] = Carbon::now()->diffInMinutes(Carbon::parse($player['in_time']));
                    $time_cost = $time_cost + self::calculate_time_cost(Carbon::now()->diffInMinutes(Carbon::parse($player['in_time'])), $amount, $amount, $first_interval_time['value'], $additional_time['value']);
                    $i++;
                }

                $membership_status['time_cost'] = $time_cost;
                $membership_status['total'] = $membership_status['time_cost'] + $membership_status['water_total'] + $membership_status['socks_total'];

                $membership_status = Arr::add($membership_status, 'players', $p);
                return $membership_status;
                break;
            case ('normal'):
                // $p = PackageUser::with('packageTaken')->where('card_id', $card_id)->first()->toArray();
                // return $p;
                $package_status['card_id'] = $card_id;
                $package_status['type'] = 'normal';
                $cost = 0;
                $package_status['cost'] = $cost;
                $paid = 0;
                $package_status['paid'] = $paid;
                $package_status['amount'] = 0;
                $package_status['remaining_payment'] = 0;



                $package_status['expired'] = 0;
                $package_status['remaining_days'] = null;


                $parking_in_data = ParkingIn::with('parkingInGroup')
                    ->where('card_id', $card_id)
                    ->first()
                    ->toArray();
                $package_status['in_time'] = $parking_in_data['in_time'];
                $total_time = Carbon::now()->diffInMinutes(Carbon::parse($parking_in_data['in_time']));
                $sock_cost_at_time = (int)$parking_in_data['sock_cost_at_time'];
                $socks = (int)$parking_in_data['socks'];
                $water_cost_at_time = (int)$parking_in_data['water_cost_at_time'];
                $water = (int)$parking_in_data['water'];

                $package_status['socks'] = $socks;
                $package_status['socks_total'] = $sock_cost_at_time * $socks;
                $package_status['waters'] = $water;
                $package_status['water_total'] = $water_cost_at_time * $water;
                $package_status['socks_cost_at_time']=$sock_cost_at_time;
                $package_status['water_cost_at_time']=$water_cost_at_time;

                $package_status['name'] = $parking_in_data['name'];
                $package_status['phone_no'] = $parking_in_data['phone_no'];
                $package_status['entry_date_time'] = $parking_in_data['in_time'];
                $package_status['deposit'] = $parking_in_data['deposite'];
                $package_status['no_of_client'] = $parking_in_data['no_of_client'];



                $time_cost = 0;
                $i = 0;
                $players = $parking_in_data['parking_in_group'];

                foreach ($players as $key => $player) {
                    // echo $i;
                    $p[$key]['id'] = $player['id'];
                    $p[$key]['player_in_id'] = $player['parking_in_id'];
                    $p[$key]['in_time'] = $player['in_time'];
                    $p[$key]['out_time'] = $player['out_time'];


                    if ($player['interval'] != null) {
                        $p[$key]['interval'] = $player['interval'];
                    } else {
                        $interval = CarbonInterval::seconds(Carbon::now()->diffInSeconds($player['in_time']))->cascade();
                        // echo $interval;
                        $p[$key]['interval'] = $interval->d."d : ".$interval->h."h : ".$interval->i."m : ".$interval->s."s";
                        // $p[$key]['interval'] = $interval;
                    }
                    if ($player['out_time'] != null) {
                        $p[$key]['total_time'] = Carbon::parse($player['out_time'])->diffInMinutes(Carbon::parse($player['in_time']));
                    } else {
                        $p[$key]['total_time'] = Carbon::now()->diffInMinutes(Carbon::parse($player['in_time']));
                    }




                    $p[$key]['time_cost'] = self::calculate_time_cost($p[$key]['total_time'], $first_interval_cost['value'], $increment_cost['value'], $first_interval_time['value'], $additional_time['value']);
                    // $package_status['total_time' . $i] = Carbon::now()->diffInMinutes(Carbon::parse($player['in_time']));
                    $time_cost = $time_cost + $p[$key]['time_cost'];
                    $i++;
                }

                $package_status['time_cost'] = $time_cost;
                $package_status['total'] = $package_status['time_cost'] + $package_status['water_total'] + $package_status['socks_total']-$parking_in_data['deposite'];



                $package_status = Arr::add($package_status, 'players', $p);

                return $package_status;
                break;
            default:
                return 'asdf';
        }

        // return $cost_detail;
    }

    public static function isIn($card_id)
    {
        $park_in = ParkingIn::where('card_id', '=', $card_id)->first();
        if ($park_in == null) {
            return false;
        }
        return true;
    }

    public static function GetCardStatus($card_id)
    {
        // $card_type="";
        $card_p = PackageUser::where('card_id', '=', $card_id)->first();
        $card_m = MembershipUser::where('card_id', '=', $card_id)->first();
        $card_n = NormalCard::where('card_id', '=', $card_id)->first();
        if ($card_p != null) {
            $card_detail = PackageUser::with('packageTaken')->where('card_id', $card_id)->first()->toArray();
            // return $card_detail;
            $card_status['type'] = 'package';
            $card_status['name'] = $card_detail['name'];
            $card_status['phone'] = $card_detail['phone_no'];

            $exp_date = Carbon::parse(last($card_detail['package_taken'])['end_date']);
            if (Carbon::now() < $exp_date) {
                $card_status['expired'] = 0;
                $card_status['remaining_days'] = $exp_date->diffInHours(Carbon::now());
            } else {
                $card_status['expired'] = 1;
                $card_status['remaining_days'] = $exp_date->diffInHours(Carbon::now());
            }

            $cost = last($card_detail['package_taken'])['cost'];
            $paid = last($card_detail['package_taken'])['paid'];
            if ($paid < $cost) {
                $card_status['remaining_payment'] = $cost - $paid;
            } else {
                $card_status['remaining_payment'] = 0;
            }

            return $card_status;
        } elseif ($card_m != null) {
            $card_detail = MembershipUser::with('membershipTaken')->where('card_id', $card_id)->first()->toArray();
            // return($card_detail);
            $card_status['type'] = 'membership';
            $card_status['name'] = $card_detail['name'];
            $card_status['phone'] = $card_detail['phone_no'];

            $exp_date = Carbon::parse(last($card_detail['membership_taken'])['end_date']);
            // echo $exp_date;
            if (Carbon::now() < $exp_date) {
                $card_status['expired'] = 0;
                $card_status['remaining_days'] = $exp_date->diffInHours(Carbon::now());
            } else {
                $card_status['expired'] = 1;
                $card_status['remaining_days'] = $exp_date->diffInHours(Carbon::now());
            }

            $cost = last($card_detail['membership_taken'])['cost'];
            $paid = last($card_detail['membership_taken'])['paid'];
            if ($paid < $cost) {
                $card_status['remaining_payment'] = $cost - $paid;
            } else {
                $card_status['remaining_payment'] = 0;
            }

            return $card_status;
        } elseif ($card_n != null) {
            $card_status['type'] = 'normal';
            $card_status['expired'] = '';
            $card_status['remaining_days'] = '';
            $card_status['remaining_payment'] = '';
        } else {
            $card_status['type'] = 'no';
        }

        return $card_status;
    }

    public static function calculate_time_cost($total_time_in_min, $first_interval_cost, $increment_interval_cost, $first_interval, $extra_interval)
    {
        // echo $total_time_in_min;
        // echo $first_interval_cost;
        // echo $first_interval;
        
        if ($total_time_in_min < $extra_interval) {
            $totalCost = 0;
        } else {
            $mod = $total_time_in_min % $first_interval;
            $no_of_interval = (int)($total_time_in_min / $first_interval);
            //  return $mod;
            if ($mod >= $extra_interval) {
                $add = $increment_interval_cost;
            } else {
                $add = 0;
            }
            $totalCost = $first_interval_cost + (($no_of_interval - 1) * $increment_interval_cost) + $add;
        }
        return $totalCost;
    }




    public static function PostSuggestionList($name,$phone)
    {

        $user = Dictionary::where('name', $name)
            ->where('phone_no', $phone)
            ->first();

        try {
            if ($user === null) {
                $Suggestion = Dictionary::create([
                    'name' => $name,
                    'phone_no' => $phone,
                ]);
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
}
