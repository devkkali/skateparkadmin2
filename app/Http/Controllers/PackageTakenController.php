<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterPackageTakenRequest;
use App\Http\Requests\UpdatePackageTakenRequest;
use App\Models\PackageTaken;
use App\Models\PackageType;
use App\Models\PackageUser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PackageTakenController extends Controller
{
    public function RegisterPackageTaken(RegisterPackageTakenRequest $request, $user_id)
    {
        try {
            $user = PackageUser::select()->where('id', '=', $user_id)->first();
            
            if ($user==null) {
                $error_type['package_taken'] = ['Not Found'];
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
                    'package_user_id' => $user->id,
                    'package_type_id' => $request->input('package_type_id'),
                    'starting_date' => $request->input('starting_date', Carbon::now()),
                    // 'end_date' => null,
                    'cost' => $package_type->cost,
                    'paid' => $request->input("paid"),

                ]);

                $ti = PackageTaken::findOrFail($t->id);
                $start = Carbon::parse($ti->starting_date);

                $ti->end_date = $start->addDay($package_type->validity_in_day);
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


    public function UpdatePackageTaken(UpdatePackageTakenRequest $request, $id)
    {
        try {
            $mt = PackageTaken::select()->where('id', '=', $id)->first();

            if ($mt == null) {
                $error_type['package_taken'] = ['Not Found'];
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


    public function DeletePackageTaken($id)
    {
        try {
            $mt = PackageTaken::select()->where('id', '=', $id)->first();

            if ($mt == null) {
                $error_type['package_taken'] = ['Not Found'];
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



public function getphpversion(){
    return app()->version();

}


}
