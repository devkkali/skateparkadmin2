<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MembershipTakenController;
use App\Http\Controllers\MembershipTypeController;
use App\Http\Controllers\MembershipUserController;
use App\Http\Controllers\PackageTakenController;
use App\Http\Controllers\PackageTypeController;
use App\Http\Controllers\PackageUserController;
use App\Http\Controllers\ParkInController;
use App\Http\Controllers\SettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['middleware' => ['XssSanitizer']], function () {
    Route::post('/login',[LoginController::class, 'RootLogin']);
    Route::get('/me',[LoginController::class,'me'])->middleware('auth:user-api');

    Route::get('/get_all_users',[LoginController::class,'GetAllUsers']);
    Route::post('/get_all_users',[LoginController::class,'CreateUsers']);
    Route::put('/get_all_users/{id}',[LoginController::class,'UpdateUser']);
    Route::delete('/get_all_users/{id}',[LoginController::class,'DeleteUser']);


    Route::post('/register_cards',[CardController::class,'RegisterMultipleCards']);




    Route::post('/membership_type',[MembershipTypeController::class,'RegisterMembershipType']);
    Route::get('/membership_type',[MembershipTypeController::class,'IndexMembershipType']);
    Route::get('/membership_type/{id}',[MembershipTypeController::class,'ShowMembershipType']);
    Route::put('/membership_type/{id}',[MembershipTypeController::class,'UpdateMembershipType']);
    Route::delete('/membership_type/{id}',[MembershipTypeController::class,'DeleteMembershipType']);




    Route::post('/membership_user',[MembershipUserController::class,'RegisterMembershipUser']);
    Route::get('/membership_user',[MembershipUserController::class,'IndexMembershipUser']);
    Route::get('/membership_user/{id}',[MembershipUserController::class,'ShowMembershipUser']);
    Route::put('/membership_user/{id}',[MembershipUserController::class,'UpdateMembershipUser']);
    Route::delete('/membership_user/{id}',[MembershipUserController::class,'DeleteMembershipUser']);


    Route::post('/membership_taken/{user_id}',[MembershipTakenController::class,'RegisterMembershipTaken']);
    // Route::get('/membership_taken/{id}',[MembershipTakenController::class,'ShowMembershipTaken']);
    Route::put('/membership_taken/{id}',[MembershipTakenController::class,'UpdateMembershipTaken']);
    Route::delete('/membership_taken/{id}',[MembershipTakenController::class,'DeleteMembershipTaken']);




    Route::post('/package_type',[PackageTypeController::class,'RegisterPackageType']);
    Route::get('/package_type',[PackageTypeController::class,'IndexPackageType']);
    Route::get('/package_type/{id}',[PackageTypeController::class,'ShowPackageType']);
    Route::put('/package_type/{id}',[PackageTypeController::class,'UpdatePackageType']);
    Route::delete('/package_type/{id}',[PackageTypeController::class,'DeletePackageType']);




    Route::post('/package_user',[PackageUserController::class,'RegisterPackageUser']);
    Route::get('/package_user',[PackageUserController::class,'IndexPackageUser']);
    Route::get('/package_user/{id}',[PackageUserController::class,'ShowPackageUser']);
    Route::put('/package_user/{id}',[PackageUserController::class,'UpdatePackageUser']);
    Route::delete('/package_user/{id}',[PackageUserController::class,'DeletePackageUser']);


    Route::post('/package_taken/{user_id}',[PackageTakenController::class,'RegisterPackageTaken']);
    // Route::get('/package_taken/{id}',[PackageTakenController::class,'ShowPackageTaken']);
    Route::put('/package_taken/{id}',[PackageTakenController::class,'UpdatePackageTaken']);
    Route::delete('/package_taken/{id}',[PackageTakenController::class,'DeletePackageTaken']);

    Route::get('/php',[PackageTakenController::class,'getphpversion']);





    Route::get('/park_in_check/{card_id}',[ParkInController::class,'ParkinCheck']);

    Route::post('/park_in/{card_id}',[ParkInController::class,'Parkin']);


    Route::get('/park_out_check/{card_id}',[ParkInController::class,'ParkoutCheck']);
    
    Route::get('/park_out_add_player/{card_id}',[ParkInController::class,'ParkoutAddPlayer']);



    Route::delete('/park_out_del_player/{player_id}',[ParkInController::class,'ParkoutDeletePlayer']);
    
    Route::get('/park_out_single_player/{player_id}',[ParkInController::class,'ParkingOutSinglePlayer']);
    




    Route::post('/park_out_add_water/{card_id}',[ParkInController::class,'ParkingOutAddWater']);
    
    Route::post('/park_out_edit_water/{card_id}',[ParkInController::class,'ParkingOutEditWater']);

    Route::post('/park_out_add_socks/{card_id}',[ParkInController::class,'ParkingOutAddSocks']);
    
    Route::post('/park_out_edit_socks/{card_id}',[ParkInController::class,'ParkingOutEditSocks']);

    Route::post('/park_out_add_deposit/{card_id}',[ParkInController::class,'ParkingOutAddDeposit']);
    
    Route::post('/park_out_edit_deposit/{card_id}',[ParkInController::class,'ParkingOutEditDeposit']);
   
    Route::post('/park_out/{card_id}',[ParkInController::class,'ParkingOutFinal']);





    Route::post('/set_first_interval_cost',[SettingController::class,'SetFirstIntervalCost']);
    Route::post('/set_increment_cost',[SettingController::class,'SetIncrementCost']);
    Route::post('/set_sock_cost',[SettingController::class,'SetSockCost']);
    Route::post('/set_water_cost',[SettingController::class,'SetWaterCost']);
    Route::post('/set_first_interval_time',[SettingController::class,'SetFirstIntervalTime']);
    Route::post('/set_additional_time',[SettingController::class,'SetAdditionalTime']);


    Route::post('/get_first_interval_cost',[SettingController::class,'GetFirstIntervalCost']);
    Route::get('/get_all_settings',[SettingController::class,'GetAllSettings']);

    Route::get('/switch_isbill',[SettingController::class,'SwitchIsBill']);

    // Route::get('/package_user',[PackageUserController::class,'IndexPackageUser']);


    Route::get('/get_all_normal_cards',[CardController::class,'GetAllNormalCards']);
    Route::delete('/change_card_park_off/{card_id}',[CardController::class,'ChangeCardParkOff']);
    Route::delete('/delete_normal_card/{card_id}',[CardController::class,'DeleteNormalCard']);
    
    
    
    
    
    Route::post('/get_parking_records',[HistoryController::class,'GetParkingRecords']);

    Route::post('/get_sales_report',[HistoryController::class,'GetSalesRepost']);
    // Route::delete('/delete_normal_card/{card_id}',[CardController::class,'DeleteNormalCard']);

    Route::get('/get_suggestion_list',[HistoryController::class,'GetSuggestionList']);
    Route::post('/get_suggestion_list',[HistoryController::class,'PostSuggestionList']);

    Route::get('/downloadapk',[SettingController::class,'downloadapk']);

    Route::get('/copy',[SettingController::class,'copy']);



});