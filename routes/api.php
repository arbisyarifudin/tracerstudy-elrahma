<?php

use App\Http\Controllers\Api\AuthController;

/* ADMIN */
use App\Http\Controllers\API\Admin\AlumniController;
use App\Http\Controllers\API\Admin\BatchController;
use App\Http\Controllers\API\Admin\FormController;
use App\Http\Controllers\API\Admin\MajorController;
use App\Http\Controllers\API\Admin\ProvinceController;
use App\Http\Controllers\API\Admin\RegencyController;

/* MEMBER */
use App\Http\Controllers\API\Member\AlumniController as MemberAlumniController;

/* LARAVEL */
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

/* AUTH */

Route::group(['prefix' => 'auth'], function ($routes) {
    $routes->post('login', [AuthController::class, 'login']);
    $routes->post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    // $routes->post('refresh-token', [AuthController::class, 'refreshToken'])
    //     ->middleware('auth:sanctum')
    //     ->name('api.auth.refresh-token');
});

/* USER */
Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function ($routes) {
    $routes->get('profile', function (Request $request) {
        return [
            'message' => 'User profile.',
            'data' => $request->user()
        ];
    });
});

/* ADMIN */
Route::group(['prefix' => 'admin', 'middleware' => 'auth:sanctum'], function ($routes) {
    $routes->group(['prefix' => 'batch'], function ($routes) {
        $routes->get('', [BatchController::class, 'list']);
        $routes->post('', [BatchController::class, 'store']);
        $routes->put('{id}', [BatchController::class, 'update']);
        $routes->delete('{id}', [BatchController::class, 'delete']);
    });
    $routes->group(['prefix' => 'major'], function ($routes) {
        $routes->get('', [MajorController::class, 'list']);
        $routes->post('', [MajorController::class, 'store']);
        $routes->put('{id}', [MajorController::class, 'update']);
        $routes->delete('{id}', [MajorController::class, 'delete']);
    });
    $routes->group(['prefix' => 'alumni'], function ($routes) {
        $routes->get('', [AlumniController::class, 'list']);
        $routes->get('{id}', [AlumniController::class, 'show']);
        $routes->post('', [AlumniController::class, 'store']);
        $routes->put('{id}', [AlumniController::class, 'update']);
        $routes->delete('{id}', [AlumniController::class, 'delete']);
    });

    $routes->group(['prefix' => 'form'], function ($routes) {
        $routes->get('', [FormController::class, 'list']);
        $routes->get('{id}', [FormController::class, 'show']);
        $routes->get('{id}/detail', [FormController::class, 'showDetail']);
        $routes->post('', [FormController::class, 'store']);
        $routes->put('{id}', [FormController::class, 'update']);
        $routes->put('{id}/detail', [FormController::class, 'updateDetail']);
        $routes->delete('{id}', [FormController::class, 'delete']);
    });
});

Route::group(['prefix' => 'province'], function ($routes) {
    $routes->get('', [ProvinceController::class, 'list']);
});
Route::group(['prefix' => 'regency'], function ($routes) {
    $routes->get('', [RegencyController::class, 'list']);
});

/* Public */
Route::group(['prefix' => 'public'], function ($routes) {
    $routes->group(['prefix' => 'alumni'], function ($routes) {
        $routes->get('', [MemberAlumniController::class, 'list']);
        $routes->get('{id}', [MemberAlumniController::class, 'show']);
    });
});

/* Alumni */
Route::group(['prefix' => 'member'], function ($routes) {
    $routes->group(['middleware' => ['auth:sanctum', 'for-member']], function ($routes) {
        $routes->group(['prefix' => 'alumni'], function ($routes) {
            $routes->get('', [MemberAlumniController::class, 'list']);
            $routes->get('{id}', [MemberAlumniController::class, 'show']);
        });
    });
});
