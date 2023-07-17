<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterMembershipTypeRequest;
use App\Http\Requests\UpdateMembershipTypeRequest;
use App\Models\MembershipType;
use App\Models\MembershipUser;
use Illuminate\Http\Request;

class MembershipTypeController extends Controller
{

    public function RegisterMembershipType(RegisterMembershipTypeRequest $request)
    {
        try {

            $m = MembershipType::create([
                'type_name' => $request->input('type_name'),
                'validity_in_day' => $request->input('validity_in_day'),
                'cost' => $request->input('cost'),
            ]);

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


    public function IndexMembershipType()
    {
        try {
            $m = MembershipType::all();

            // $m = MembershipUser::select()->get();

            // return $m;



            if ($m->isEmpty()) {
                $error_type['membership_type'] = ['Not Found'];
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

    public function ShowMembershipType($id)
    {
        try {
            // $m=MembershipUser::findOrFail($id);
            $m = MembershipType::select()->where('id', '=', $id)->first();

            if ($m == null) {
                $error_type['membership_type'] = ['Not Found'];
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

    public function UpdateMembershipType(UpdateMembershipTypeRequest $request, $id)
    {
        try {
            $m = MembershipType::select()->where('id', '=', $id)->first();

            if ($m == null) {
                $error_type['membership_type'] = ['Not Found'];
                $response = response()->json([
                    'error' => 'true',
                    'message' => 'Invalid data sent',
                    "details" => $error_type,
                ], 422);
                return $response;
            }
            $m->type_name = $request->input('type_name');
            $m->validity_in_day = $request->input('validity_in_day');
            $m->cost = $request->input('cost');
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


    public function DeleteMembershipType($id)
    {
        try {
            $m = MembershipType::select()->where('id', '=', $id)->first();

            if ($m == null) {
                $error_type['membership_type'] = ['Not Found'];
                $response = response()->json([
                    'error' => 'true',
                    'message' => 'Invalid data sent',
                    "details" => $error_type,
                ], 422);
                return $response;
            }
            // $m->name = $request->input('name');
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
