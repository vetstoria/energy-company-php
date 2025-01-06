<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeterReadingController;
use App\Http\Controllers\PricePlanComparatorController;
use App\Http\Controllers\CostController;
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
Route::get('/readings/{smartMeterId}', [MeterReadingController::class, 'getReading']);
Route::post('/readings', [MeterReadingController::class, 'storeReadings']);
Route::get('price-plan/{smartMeterId}/recommendations', [PricePlanComparatorController::class, 'recommendations']);
Route::get('price-plan/{smartMeterId}/comparisons', [PricePlanComparatorController::class, 'comparisons']);
