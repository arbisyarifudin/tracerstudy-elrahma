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
use App\Http\Controllers\API\Member\BatchController as MemberBatchController;
use App\Http\Controllers\API\Member\MajorController as MemberMajorController;
use App\Http\Controllers\API\Member\ProfileController as MemberProfileController;
use App\Http\Controllers\API\Member\EducationController as MemberEducationController;
use App\Http\Controllers\API\Member\JobController as MemberJobController;
use App\Http\Controllers\API\Member\FeedbackController as MemberFeedbackController;
use App\Http\Controllers\API\Member\FormController as MemberFormController;
use App\Http\Controllers\API\Member\ContentController as MemberContentController;
use App\Models\Alumni;
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
    $routes->post('register', [AuthController::class, 'register']);
    // $routes->post('refresh-token', [AuthController::class, 'refreshToken'])
    //     ->middleware('auth:sanctum')
    //     ->name('api.auth.refresh-token');
});

/* USER */
Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function ($routes) {
    $routes->get('profile', function (Request $request) {

        $user = $request->user();
        // if ($user->type === 'Alumni') {
        //     $user->alumni = Alumni::with([
        //         'major',
        //         'batch'
        //     ])->where('user_id', $user->id)->first();
        // }
        return [
            'message' => 'User profile.',
            'data' => $user
        ];
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
    // public/alumni
    $routes->group(['prefix' => 'alumni'], function ($routes) {
        $routes->get('', [MemberAlumniController::class, 'list']);
        $routes->get('{id}', [MemberAlumniController::class, 'show']);
    });
    // public/batch
    $routes->group(['prefix' => 'batch'], function ($routes) {
        $routes->get('', [MemberBatchController::class, 'list']);
    });
    $routes->group(['prefix' => 'major'], function ($routes) {
        $routes->get('', [MemberMajorController::class, 'list']);
    });
    $routes->group(['prefix' => 'content'], function ($routes) {
        $routes->get('', [MemberContentController::class, 'list']);
        $routes->get('{slug}', [MemberContentController::class, 'showBySlug']);
    });
});

/* ADMIN */
Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'for-admin']], function ($routes) {
    // admin/batch
    $routes->group(['prefix' => 'batch'], function ($routes) {
        $routes->get('', [BatchController::class, 'list']);
        $routes->post('', [BatchController::class, 'store']);
        $routes->put('{id}', [BatchController::class, 'update']);
        $routes->delete('{id}', [BatchController::class, 'delete']);
    });
    // admin/major
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

/* Alumni */
Route::group(['prefix' => 'member'], function ($routes) {
    $routes->group(['middleware' => ['auth:sanctum', 'for-member']], function ($routes) {
        // member/alumni
        $routes->group(['prefix' => 'alumni'], function ($routes) {
            $routes->get('', [MemberAlumniController::class, 'list']);
            $routes->get('{id}', [MemberAlumniController::class, 'show']);
        });
        // member/profile
        $routes->group(['prefix' => 'profile'], function ($routes) {
            $routes->get('', [MemberProfileController::class, 'show']);
            $routes->put('', [MemberProfileController::class, 'update']);
        });
        // member/education
        $routes->group(['prefix' => 'education'], function ($routes) {
            $routes->get('', [MemberEducationController::class, 'list']);
            // $routes->get('{id}', [MemberEducationController::class, 'show']);
            $routes->post('', [MemberEducationController::class, 'store']);
            $routes->put('{id}', [MemberEducationController::class, 'update']);
            $routes->delete('{id}', [MemberEducationController::class, 'delete']);
        });
        // member/job
        $routes->group(['prefix' => 'job'], function ($routes) {
            $routes->get('', [MemberJobController::class, 'list']);
            // $routes->get('{id}', [MemberJobController::class, 'show']);
            $routes->post('', [MemberJobController::class, 'store']);
            $routes->put('{id}', [MemberJobController::class, 'update']);
            $routes->delete('{id}', [MemberJobController::class, 'delete']);
        });
        // member/feedback
        $routes->group(['prefix' => 'feedback'], function ($routes) {
            $routes->get('', [MemberFeedbackController::class, 'show']);
            $routes->put('', [MemberFeedbackController::class, 'update']);
        });
        // member/form
        $routes->group(['prefix' => 'form'], function ($routes) {
            // $routes->get('', [MemberFormController::class, 'list']);
            // $routes->get('{id}', [MemberFormController::class, 'show']);
            // $routes->post('', [MemberFormController::class, 'store']);
            $routes->post('submit', [MemberFormController::class, 'submit']);
            $routes->get('active', [MemberFormController::class, 'showActive']);
            // $routes->put('{id}', [MemberFormController::class, 'update']);
        });
    });
});
