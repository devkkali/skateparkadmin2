<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use function GuzzleHttp\Promise\all;

class LoginController extends Controller
{

    public function GetAllUsers()
    {
        // $users= User::all()->except(User::where('role', '=', request('super')));
        $users = User::where('role', '!=', 'super')->get();
        $response = response()->json([
            'error' => 'false',
            'message' => 'success',
            "details" => $users,
        ], 200);
        return $response;
    }

    public function CreateUsers(CreateUserRequest $request)
    {
        DB::table('users')->insert([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
        ]);
    }

    public function UpdateUser(UpdateUserRequest $request, $id)
    {

        $m = User::select()->where('id', '=', $id)->first();
        if ($m == null) {
            $error_type['user'] = ['Not Found'];
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }

        if ($request->input('password') == "" || $request->input('password') == null) {

            $m->name = $request->input('name');
            $m->email = $request->input('email');
            $m->role = $request->input('role');
            $m->save();
        } else {

            $m->name = $request->input('name');
            $m->email = $request->input('email');
            $m->password = Hash::make($request->input('password'));
            $m->role = $request->input('role');
            $m->save();
        }
        return response()->json([
            'error' => 'false',
            'message' => 'success',
            'details' => $m,
        ], 200);
    }
    public function DeleteUser($id)
    {
        $m = User::select()->where('id', '=', $id)->first();
        if ($m == null) {
            $error_type['user'] = ['Not Found'];
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }
        $m->delete();
        return response()->json([
            'error' => 'false',
            'message' => 'success',
            'details' => '',
        ], 200);
    }

    //
    public function me()
    {
        $user = Auth::user();
        return response([
            'message' => 'success',
            'user' => Auth::user(),
        ]);
    }

    public function RootLogin(LoginRequest $request)
    {
        $user = User::where('email', '=', request('email'))->first();
        if ($user == null) {
            $error_type['email'] = ['user not found'];
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }


        if (auth()->guard('user')->attempt(['email' => request('email'), 'password' => request('password')])) {
            config(['auth.guards.api.provider' => 'users']);
            $loginuser = User::select('users.*')->find(auth()->guard('user')->user()->id);

            $success['id'] =  $loginuser->id;
            $success['email'] = $loginuser->email;
            if ($loginuser->role == 'admin') {
                $success['role'] = 'admin';
                $success['token'] =  $loginuser->createToken('Parking', ['admin'])->accessToken;
            } elseif ($loginuser->role == 'user') {
                $success['role'] = 'user';
                $success['token'] =  $loginuser->createToken('Parking', ['user'])->accessToken;
            } elseif ($loginuser->role == 'super') {
                $success['role'] = 'super';
                $success['token'] =  $loginuser->createToken('Parking', ['super'])->accessToken;
            } else {
                $error_type['role'] = ['email/password Wrong'];
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
                'details' => $success
            ], 200);
        } else {

            $error_type['password'] = ['password Wrong'];
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }
    }
}
