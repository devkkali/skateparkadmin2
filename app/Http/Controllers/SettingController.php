<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function copy()
    {
        for ($i = 0; $i < 10000; $i++) {
            $task = History::first();
            $newTask = $task->replicate();
            $newTask->save();
        }
        echo "coplete";
    }

    public function GetAllSettings()
    {
        try {
            $first_interval_cost = Setting::where('item', 'first_interval_cost')->pluck('value');
            $increment_cost = Setting::where('item', 'increment_cost')->pluck('value');
            $sock_cost = Setting::where('item', 'sock_cost')->pluck('value');
            $water_cost = Setting::where('item', 'water_cost')->pluck('value');
            $first_interval_time = Setting::where('item', 'first_interval_time')->pluck('value');
            $additional_time = Setting::where('item', 'additional_time')->pluck('value');
            $isbill = Setting::where('item', 'isbill')->pluck('value');

            $settings["first_interval_cost"] = $first_interval_cost;
            $settings["increment_cost"] = $increment_cost;
            $settings["sock_cost"] = $sock_cost;
            $settings["water_cost"] = $water_cost;
            $settings["first_interval_time"] = $first_interval_time;
            $settings["additional_time"] = $additional_time;
            $settings["isbill"] = $isbill;

            // $settings=array(
            //     "first_interval_cost"=>$first_interval_cost,
            //     "increment_cost"=>$increment_cost,
            //     "sock_cost"=>$sock_cost
            // );

            // var warning = {
            //     "Remaining Hour": res.data.details.remaining_days + ' Hours',
            //     "Remaining Payment": 'Rs ' + res.data.details.remaining_payment,
            // };


            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => $settings,
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

    public function SetFirstIntervalCost(Request $request)
    {
        if ($request->input('value') == "" || $request->input('value') < 1) {
            // return 'hello';
            $error_type['first_interval_cost'] = ['Please enter valid data'];
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }

        try {
            $firstIntervalCost = Setting::where('item', 'first_interval_cost')->first();
            $firstIntervalCost->value = $request->input('value');
            $firstIntervalCost->save();

            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => $firstIntervalCost,
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
    public function SetIncrementCost(Request $request)
    {
        if ($request->input('value') == "" || $request->input('value') < 1) {
            // return 'hello';
            $error_type['increment_cost'] = ['Please enter valid data'];
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }

        try {
            $increment_cost = Setting::where('item', 'increment_cost')->first();
            $increment_cost->value = $request->input('value');
            $increment_cost->save();

            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => $increment_cost,
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
    public function SetSockCost(Request $request)
    {
        if ($request->input('value') == "" || $request->input('value') < 1) {
            // return 'hello';
            $error_type['sock_cost'] = ['Please enter valid data'];
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }

        try {
            $sock_cost = Setting::where('item', 'sock_cost')->first();
            $sock_cost->value = $request->input('value');
            $sock_cost->save();

            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => $sock_cost,
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
    public function SetWaterCost(Request $request)
    {
        if ($request->input('value') == "" || $request->input('value') < 1) {
            // return 'hello';
            $error_type['water_cost'] = ['Please enter valid data'];
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }

        try {
            $water_cost = Setting::where('item', 'water_cost')->first();
            $water_cost->value = $request->input('value');
            $water_cost->save();

            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => $water_cost,
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
    public function SetFirstIntervalTime(Request $request)
    {
        if ($request->input('value') == "" || $request->input('value') < 1) {
            // return 'hello';
            $error_type['first_interval_time'] = ['Please enter valid data'];
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }

        try {
            $first_interval_time = Setting::where('item', 'first_interval_time')->first();
            $first_interval_time->value = $request->input('value');
            $first_interval_time->save();

            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => $first_interval_time,
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
    public function SetAdditionalTime(Request $request)
    {
        if ($request->input('value') == "" || $request->input('value') < 1) {
            // return 'hello';
            $error_type['additional_time'] = ['Please enter valid data'];
            $response = response()->json([
                'error' => 'true',
                'message' => 'Invalid data sent',
                "details" => $error_type,
            ], 422);
            return $response;
        }

        try {
            $additional_time = Setting::where('item', 'additional_time')->first();
            $additional_time->value = $request->input('value');
            $additional_time->save();

            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => $additional_time,
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


    public function GetFirstIntervalCost()
    {
        try {
            $firstIntervalCost = Setting::where('item', 'first_interval_cost')->first();
            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => $firstIntervalCost,
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


    public function SwitchIsBill()
    {
        try {
            $isbill = Setting::where('item', 'isbill')->first();
            if ($isbill->value == "0") {
                $isbill->value = "1";
            } else {
                $isbill->value = "0";
            }
            $isbill->save();

            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => $isbill,
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



    public function downloadapk()
    {
        $file = public_path() . "/apk/skate.apk";
        // echo $file;

        $headers = ['Content-Type: application/apk'];

        if (file_exists($file)) {
            return Response::download($file, 'skate.apk', $headers);
        } else {
            echo ('File not found.');
        }
    }
}
