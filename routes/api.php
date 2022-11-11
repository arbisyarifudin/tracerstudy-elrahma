<?php

use App\Http\Controllers\API\Admin\AlumniController;
use App\Http\Controllers\API\Admin\BatchController;
use App\Http\Controllers\API\Admin\MajorController;
use App\Http\Controllers\API\Admin\ProvinceController;
use App\Http\Controllers\API\Admin\RegencyController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('auth:sanctum', function ($routes) {
// $routes->group(['prefix' => 'batch'], function ($routes) {
Route::group(['prefix' => 'batch'], function ($routes) {
    $routes->get('', [BatchController::class, 'list']);
    $routes->post('', [BatchController::class, 'store']);
    $routes->put('{id}', [BatchController::class, 'update']);
    $routes->delete('{id}', [BatchController::class, 'delete']);
});
Route::group(['prefix' => 'major'], function ($routes) {
    $routes->get('', [MajorController::class, 'list']);
    $routes->post('', [MajorController::class, 'store']);
    $routes->put('{id}', [MajorController::class, 'update']);
    $routes->delete('{id}', [MajorController::class, 'delete']);
});
Route::group(['prefix' => 'alumni'], function ($routes) {
    $routes->get('', [AlumniController::class, 'list']);
    $routes->get('{id}', [AlumniController::class, 'show']);
    $routes->post('', [AlumniController::class, 'store']);
    $routes->put('{id}', [AlumniController::class, 'update']);
    $routes->delete('{id}', [AlumniController::class, 'delete']);
});
Route::group(['prefix' => 'province'], function ($routes) {
    $routes->get('', [ProvinceController::class, 'list']);
});
Route::group(['prefix' => 'regency'], function ($routes) {
    $routes->get('', [RegencyController::class, 'list']);
});
// });
