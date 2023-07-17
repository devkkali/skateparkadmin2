<?php

namespace App\Http\Controllers;

use App\Models\Dictionary;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    //

    public function GetParkingRecords(Request $request)
    {
        $type = $request->input("record_type");
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');

        switch ($type) {
            case 'all':

                // $table = DB::table("parking_ins")
                //     ->select(DB::raw("card_id", "name", "phone_no", "no_of_client", "in_time", "in_time", "in_time", "paid_amount"));

                // DB::table("histories")
                //     ->select(DB::raw("card_id", "name", "phone_no", "no_of_client", "in_time", "out_time", "interval", "paid_amount"))
                //     ->union($table)
                //     ->get();

                // return $table;



                // $first = DB::table("parking_ins")
                //     ->select(DB::raw("SELECT `parking_ins.card_id`, `parking_ins.name`, `parking_ins.phone_no`, `parking_ins.no_of_client`, `parking_ins.in_time`, null as 'interval', null as 'interval', `parking_ins.paid_amount`"));

                // $final = DB::table("histories")
                //     ->DB::select(DB::raw(" SELECT `histories.card_id`, `histories.name`, `histories.phone_no`, `histories.no_of_client`, `histories.in_time`, `histories.out_time`, `histories.interval`, `histories.paid_amount`"))
                //     ->union($first)
                //     ->get();

                // return  $final;

                // $first = DB::table('parking_ins')
                //     ->select(DB::raw( 'parking_ins.card_id', 'parking_ins.name', 'parking_ins.phone_no', 'parking_ins.no_of_client', 'parking_ins.in_time', 'parking_ins.in_time', 'parking_ins.in_time', 'parking_ins.paid_amount'));

                // $users = DB::table('histories')
                //     ->select(DB::raw( 'histories.card_id', 'histories.name', 'histories.phone_no', 'histories.no_of_client', 'histories.in_time', 'histories.out_time', 'histories.interval', 'histories.paid_amount'))
                //     ->union($first)
                //     ->get();

                // return $users;

                // $first = DB::table('parking_ins')
                //     ->select('card_id', 'name', 'phone_no', 'no_of_client', 'in_time',  Null, Null, 'paid_amount');

                // $users = DB::table('histories')
                //     ->select('card_id', 'name', 'phone_no', 'no_of_client', 'in_time', 'out_time', 'interval', 'paid_amount')
                //     ->union($first)
                //     ->get();

                // return $users;


                $first = DB::table('parking_ins')->select(['card_id', 'name', 'phone_no', 'no_of_client', 'in_time', DB::raw(" Null as 'out_time', Null as 'interval'"), 'paid_amount'])->whereBetween('in_time', [$from_date, $to_date]);

                $union = DB::table('histories')->select(['card_id', 'name', 'phone_no', 'no_of_client', 'in_time', 'out_time', 'interval', 'paid_amount'])->whereBetween('in_time', [$from_date, $to_date])->unionAll($first)->get();

                return response()->json([
                    'error' => 'false',
                    'message' => 'success',
                    'details' => $union,
                ], 200);















                // $get = DB::select(DB::raw("SELECT `card_id`, `name`, `phone_no`, `no_of_client`, `in_time`, `out_time`, `interval`, `paid_amount` FROM `histories` UNION
                //    SELECT  `card_id`, `name`, `phone_no`,`no_of_client`,`in_time`, null as 'out_time' , null as 'interval', `paid_amount` FROM `parking_ins`"));
                // return $get;







                break;


            case "in":

                $first = DB::table('parking_ins')->select(['card_id', 'name', 'phone_no', 'no_of_client', 'in_time', DB::raw(" Null as 'out_time', Null as 'interval'"), 'paid_amount'])->whereBetween('in_time', [$from_date, $to_date])->get();

                // $union = DB::table('histories')->select(['card_id', 'name', 'phone_no', 'no_of_client', 'in_time', 'out_time', 'interval', 'paid_amount'])->whereBetween('in_time', [$from_date, $to_date])->union($first)->get();

                return response()->json([
                    'error' => 'false',
                    'message' => 'success',
                    'details' => $first,
                ], 200);


                break;
            case "out";

                // $first = DB::table('parking_ins')->select(['card_id', 'name', 'phone_no', 'no_of_client', 'in_time', DB::raw(" Null as 'out_time', Null as 'interval'"), 'paid_amount'])->whereBetween('in_time', [$from_date, $to_date])->get();

                $union = DB::table('histories')->select(['card_id', 'name', 'phone_no', 'no_of_client', 'in_time', 'out_time', 'interval', 'paid_amount'])->whereBetween('in_time', [$from_date, $to_date])->get();

                return response()->json([
                    'error' => 'false',
                    'message' => 'success',
                    'details' => $union,
                ], 200);

                break;


            default:

                break;
        }





        return $type;
    }






    public function GetSalesRepost(Request $request)
    {
        // $type = $request->input("record_type");
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');

        // switch ($type) {
        //     case 'summary':



        // $records = History::whereBetween('recorded_time', [$from_date, $to_date])
        //     ->toSql();

        // $records = History::select(
        //     DB::raw("  (sum(socks)) as total_socks, (sum(no_of_client)) as total_clients,(sum(sock_cost_total)) as total_socks_cost"),
        // )
        //     ->whereBetween('recorded_time', [$from_date, $to_date])
        //     ->orderBy('created_at')
        //     ->groupBy(DB::raw("DATE_FORMAT(recorded_time, '%d')"))
        //     ->get();



        // $records = DB::select(DB::raw("SELECT DATE_FORMAT(recorded_time, '%Y %m %d') as in_time, sum(socks) as total_socks, sum(no_of_client) as total_clients, sum(sock_cost_total) as total_socks_cost from histories where recorded_time between '" . $from_date . "' and '" . $to_date . "' group by DATE_FORMAT(recorded_time, '%Y %m %d')"));



        // $records = History::select(
        //     DB::raw("recorded_time, sum(socks) as total_socks, sum(no_of_client) as total_clients, sum(sock_cost_total) as total_socks_cost
        // from `histories` where `recorded_time` between '?' and '?' group by DATE_FORMAT(recorded_time, '%d')")
        // )->setBindings([$from_date, $to_date])
        //     ->get();


        // $records = History::select(" (sum(socks)) as total_socks, (sum(no_of_client)) as total_clients, (sum(sock_cost_total)) as total_socks_cost")
        // ->whereBetween('recorded_time', [$from_date, $to_date])
        // ->get();

        // return $records;


        // break;

        // case "detail":

        $detail = History::whereBetween('recorded_time', [$from_date, $to_date])
            ->get();

        return response()->json([
            'error' => 'false',
            'message' => 'success',
            'details' => $detail,
        ], 200);
    }

    public function GetSuggestionList()
    {
        try {
            $detail = Dictionary::all();


            return response()->json([
                'error' => 'false',
                'message' => 'success',
                'details' => $detail,
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

    
    public function PostSuggestionList(Request $request)
    {

        $name = $request->input('name');
        $phone = $request->input('phone_no');

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
