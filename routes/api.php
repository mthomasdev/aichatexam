<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Auth\CampaignController;
use App\Http\Controllers\Auth\VoucherController;
use App\Http\Controllers\Auth\ImageController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [CustomerAuthController::class,'customerLogin']);

Route::middleware('auth:api')->group(function () {
    Route::get('me', [CustomerAuthController::class,'me']);
    

    /* Campaigns */
    Route::get('campaigns', [CampaignController::class, 'campaigns']);
    Route::get('ongoing-campaigns', [CampaignController::class, 'ongoingCampaigns']);

    /* Voucher */
    Route::get('get-voucher/{campaign_id}', [VoucherController::class,'getVoucher']);


    /* Image */
    Route::post('validate-image', [ImageController::class,'validateImage']);
});
