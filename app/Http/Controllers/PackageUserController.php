<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterPackageUserRequest;
use App\Http\Requests\UpdatePackageUserRequest;
use App\Models\PackageTaken;
use App\Models\PackageType;
use App\Models\PackageUser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PackageUserController extends Controller
{
    public function RegisterPackageUser(RegisterPackageUserRequest $request)
    {
        try {
            try {
                $m = PackageUser::create([
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
                $package_type = PackageType::findOrFail($request->input('package_type_id'));

                $t = PackageTaken::create([
                    'package_user_id' => $m->id,
                    'package_type_id' => $request->input('package_type_id'),
                    'starting_date' => $request->input('starting_date',Carbon::now()),
                    // 'end_date' => null,
                    'cost' => $package_type->cost,
                    'paid' => $request->input("paid"),

                ]);

                $ti =PackageTaken::findOrFail($t->id);
                $start= Carbon::parse($ti->starting_date);

                $ti->end_date = $start->addDay($package_type->validity_in_day);
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

    public function IndexPackageUser()
    {
        try {
            // $m = MembershipUser::all();

            // $m = MembershipUser::select()->get();

            // return $m;
            $m = PackageUser::with('packageTaken.packageType')->get();




            if ($m->isEmpty()) {
                $error_type['package_user'] = ['Not Found'];
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

    public function ShowPackageUser($id)
    {
        try {
            // $m=MembershipUser::findOrFail($id);
            // $m = MembershipUser::select()->where('id', '=', $id)->first();
            // $m = PackageUser::with('packageTaken:package_user_id,id,package_type_id,starting_date,end_date,cost,paid')
            // $m = PackageUser::with('packageTaken')
            $m = PackageUser::with('packageTaken.packageType')
            ->where("id",$id)
            ->get();

            // return $m;

            if ($m->isEmpty()) {
                $error_type['package_user'] = ['Not Found'];
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


    public function UpdatePackageUser(UpdatePackageUserRequest $request, $id)
    {
        
        try {
            $m = PackageUser::select()->where('id', '=', $id)->first();
            // return $m;
            if ($m == null) {
                $error_type['package_user'] = ['Not Found'];
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


    public function DeletePackageUser($id)
    {
        try {
            $m = PackageUser::select()->where('id', '=', $id)->first();

            if ($m == null) {
                $error_type['package_user'] = ['Not Found'];
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
