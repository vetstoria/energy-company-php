<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeterReadingController;
use App\Http\Controllers\PricePlanComparatorController;
use App\Helpers\ModelHelper;
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

Route::get('/readings/read/{smartMeterId}', [MeterReadingController::class, 'getReading']);

Route::post('/readings/store', [MeterReadingController::class, 'storeReadings']);
Route::get('price-plans/recommend/{smartMeterId}/{limit?}', [PricePlanComparatorController::class, 'recommendCheapestPricePlans']);
Route::get('price-plans/compare-all/{smartMeterId}',[PricePlanComparatorController::class, 'compareCostForEachPricePlan']);
