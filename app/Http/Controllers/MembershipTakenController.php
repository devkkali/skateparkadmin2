<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterMembershipTakenRequest;
use App\Http\Requests\UpdateMembershipTakenRequest;
use App\Models\MembershipTaken;
use App\Models\MembershipType;
use App\Models\MembershipUser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MembershipTakenController extends Controller
{
    public function RegisterMembershipTaken(RegisterMembershipTakenRequest $request, $user_id)
    {
        try {
            $user = MembershipUser::select()->where('id', '=', $user_id)->first();
            
            if ($user==null) {
                $error_type['membership_taken'] = ['Not Found'];
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
                    'membership_user_id' => $user->id,
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
                'message' => 'Invalid data sent 2',
                "details" => $error_type,
            ], 422);
            return $response;
        }
    }


    public function UpdateMembershipTaken(UpdateMembershipTakenRequest $request, $id)
    {
        try {
            $mt = MembershipTaken::select()->where('id', '=', $id)->first();

            if ($mt == null) {
                $error_type['membership_taken'] = ['Not Found'];
                $response = response()->json([
                    'error' => 'true',
                    'message' => 'Invalid data sent',
                    "details" => $error_type,
                ], 422);
                return $response;
            }
            $mt->paid = $request->input('paid');
            $mt->save();
            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => $mt,
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


    public function DeleteMembershipTaken($id)
    {
        try {
            $mt = MembershipTaken::select()->where('id', '=', $id)->first();

            if ($mt == null) {
                $error_type['membership_taken'] = ['Not Found'];
                $response = response()->json([
                    'error' => 'true',
                    'message' => 'Invalid data sent',
                    "details" => $error_type,
                ], 422);
                return $response;
            }
            // $m->name = $request->input('name');
            $mt->delete();
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
