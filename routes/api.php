<?php

use App\Http\Controllers\API\Admin\BatchController;
use App\Http\Controllers\API\Admin\MajorController;
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
    $routes->delete('{id}', [BatchController::class, 'delete']);
});
Route::group(['prefix' => 'major'], function ($routes) {
    $routes->get('', [MajorController::class, 'list']);
    $routes->post('', [MajorController::class, 'store']);
    $routes->delete('{id}', [MajorController::class, 'delete']);
});
// });
