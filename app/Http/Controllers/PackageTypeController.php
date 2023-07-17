<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterPackageTypeRequest;
use App\Http\Requests\UpdatePackageTypeRequest;
use App\Models\PackageType;
use Illuminate\Http\Request;

class PackageTypeController extends Controller
{
    public function RegisterPackageType(RegisterPackageTypeRequest $request)
    {
        try {

            $m = PackageType::create([
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


    public function IndexPackageType()
    {
        try {
            $m = PackageType::all();

            // $m = MembershipUser::select()->get();

            // return $m;



            if ($m->isEmpty()) {
                $error_type['package_type'] = ['Not Found'];
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

    public function ShowPackageType($id)
    {
        try {
            // $m=MembershipUser::findOrFail($id);
            $m = PackageType::select()->where('id', '=', $id)->first();

            if ($m == null) {
                $error_type['package_type'] = ['Not Found'];
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

    public function UpdatePackageType(UpdatePackageTypeRequest $request, $id)
    {
        try {
            $m = PackageType::select()->where('id', '=', $id)->first();

            if ($m == null) {
                $error_type['package_type'] = ['Not Found'];
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


    public function DeletePackageType($id)
    {
        try {
            $m = PackageType::select()->where('id', '=', $id)->first();

            if ($m == null) {
                $error_type['package_type'] = ['Not Found'];
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
