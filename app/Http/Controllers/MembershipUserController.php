<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterMembershipUserRequest;
use App\Http\Requests\UpdateMembershipUserRequest;
use App\Models\MembershipTaken;
use App\Models\MembershipType;
use App\Models\MembershipUser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MembershipUserController extends Controller
{
    //

    public function RegisterMembershipUser(RegisterMembershipUserRequest $request)
    {
        // return $request->input('card_id');
        try {
            try {
                $m = MembershipUser::create([
                    'card_id' => $request->input('card_id'),
                    'name' => $request->input('name'),
                    'phone_no' => $request->input('phone_no'),
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
                $membership_type = MembershipType::findOrFail($request->input('membership_type_id'));

                $t = MembershipTaken::create([
                    'membership_user_id' => $m->id,
                    'membership_type_id' => $request->input('membership_type_id'),
                    'starting_date' => $request->input('starting_date', Carbon::now()),
                    // 'end_date' => null,
                    'cost' => $membership_type->cost,
                    'paid' => $request->input("paid"),

                ]);

                $ti = MembershipTaken::findOrFail($t->id);
                $start = Carbon::parse($ti->starting_date);

                $ti->end_date = $start->addDay($membership_type->validity_in_day);
                $ti->save();
            } catch (\Exception $exception) {
                $m->delete();
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

    public function IndexMembershipUser()
    {
        try {
            // $m = MembershipUser::all();

            // $m = MembershipUser::select()->get();

            // return $m;
            $m = MembershipUser::with('membershipTaken.membershipType')
                // ->orderBy('year.desc', 'asc')
                ->get();




            if ($m->isEmpty()) {
                $error_type['membership_user'] = ['Not Found'];
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
                'details' => $m,
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

    public function ShowMembershipUser($id)
    {
        try {
            // $m=MembershipUser::findOrFail($id);
            // $m = MembershipUser::select()->where('id', '=', $id)->first();
            // $m = MembershipUser::with('membershipTaken:membership_user_id,id,membership_type_id,starting_date,end_date,cost,paid')
            $m = MembershipUser::with('membershipTaken.membershipType')
                ->where("id", $id)
                ->get();

            // return $m;

            if ($m->isEmpty()) {
                $error_type['membership_user'] = ['Not Found'];
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
                'details' => $m,
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


    public function UpdateMembershipUser(UpdateMembershipUserRequest $request, $id)
    {
        try {
            $m = MembershipUser::select()->where('id', '=', $id)->first();

            if ($m == null) {
                $error_type['membership_user'] = ['Not Found'];
                $response = response()->json([
                    'error' => 'true',
                    'message' => 'Invalid data sent',
                    "details" => $error_type,
                ], 422);
                return $response;
            }
            // $m->card_id = $request->input('card_id');
            $m->name = $request->input('name');
            $m->phone_no = $request->input('phone_no');
            $m->save();
            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => $m,
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


    public function DeleteMembershipUser($id)
    {
        try {
            $m = MembershipUser::select()->where('id', '=', $id)->first();

            if ($m == null) {
                $error_type['membership_user'] = ['Not Found'];
                $response = response()->json([
                    'error' => 'true',
                    'message' => 'Invalid data sent',
                    "details" => $error_type,
                ], 422);
                return $response;
            }
            // $m->name = $request->input('name');
            // return $m;
            $m->delete();
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
