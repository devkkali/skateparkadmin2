<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterMembershipTypeRequest;
use App\Http\Requests\RegisterMembershipUserRequest;
use App\Http\Requests\RegisterMultipleCardsRequest;
use App\Models\MembershipType;
use App\Models\MembershipUser;
use App\Models\NormalCard;
use App\Models\PackageUser;
use App\Models\ParkingIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{
    public function RegisterMultipleCards(RegisterMultipleCardsRequest $request)
    {
        $cards = $request->input('cards');
        $cards = array_unique($cards);

        $cardsuccess = [];
        $cardfailure = [];

        try {
            foreach ($cards as $card) {
                if (NormalCard::where('card_id', '=', $card)->exists() || $card == "" || MembershipUser::where('card_id', '=', $card)->exists() || PackageUser::where('card_id', '=', $card)->exists()) {
                    array_push($cardfailure, $card);
                } else {

                    // if (MembershipCard::where('card_id', '=', $card)->exists()) {
                    //     array_push($cardfailure, $card);
                    // }elseif (PackageCard::where('card_id', '=', $card)->exists()) {
                    //     array_push($cardfailure, $card);
                    // }

                    array_push($cardsuccess, $card);
                }
            }

            foreach ($cardsuccess as $cardsucc) {
                $c = NormalCard::create([
                    'card_id' => $cardsucc,
                ]);
            }

            $success['cardsuccess'] = $cardsuccess;
            $success['cardfailure'] = $cardfailure;
            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => $success,
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


    public function GetAllNormalCards()
    {
        try {
            // $cards = DB::table('normal_cards')
            //     ->leftJoin('parking_ins', function ($join) {
            //         $join->on('normal_cards.card_id', '=', 'parking_ins.card_id');
            //     })
            //     ->select(DB::raw('normal_cards.id, normal_cards.card_id, CASE WHEN parking_ins.card_id IS NOT NULL THEN 1 ELSE 0 END AS status'))
            //     ->orderBy('status', 'DESC')
            //     ->orderBy('id', 'ASC')
            //     ->get();

            $a = DB::table('normal_cards')
                ->leftJoin('parking_ins', function ($join) {
                    $join->on('normal_cards.card_id', '=', 'parking_ins.card_id');
                })
                ->select(DB::raw('normal_cards.id, CONCAT(normal_cards.card_id," (N))"), CASE WHEN parking_ins.card_id IS NOT NULL THEN 1 ELSE 0 END AS status'))
                ->orderBy('status', 'DESC')
                ->orderBy('id', 'ASC');

            $b = DB::table('membership_users')
                ->leftJoin('parking_ins', function ($join) {
                    $join->on('membership_users.card_id', '=', 'parking_ins.card_id');
                })
                ->select(DB::raw('membership_users.id,  CONCAT(membership_users.card_id," (M)"), CASE WHEN parking_ins.card_id IS NOT NULL THEN 1 ELSE 0 END AS status'))
                ->union($a)
                ->orderBy('status', 'DESC')
                ->orderBy('id', 'ASC');

            $c = DB::table('package_users')
                ->leftJoin('parking_ins', function ($join) {
                    $join->on('package_users.card_id', '=', 'parking_ins.card_id');
                })
                ->select(DB::raw('package_users.id, CONCAT(package_users.card_id," (P)") as card_id, CASE WHEN parking_ins.card_id IS NOT NULL THEN 1 ELSE 0 END AS status'))
                ->union($b)
                ->orderBy('status', 'DESC')
                ->orderBy('id', 'ASC')
                ->get();
            
            // return $a;


            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => $c,
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

    public function ChangeCardParkOff($card_id)
    {
        // remaining work
        // insert in record file
        try {
            $card = ParkingIn::where('card_id', $card_id)->first();
            $card->delete();

            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => '',
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

    public function DeleteNormalCard($card_id)
    {
        try {
            $card = NormalCard::where('card_id', $card_id)->first();
            $parkedrecord = ParkingIn::where('card_id', $card_id)->first();
            if ($card != null) {
                $card->delete();
            }
            if ($parkedrecord != null) {
                $parkedrecord->delete();
            }



            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => '',
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
}
