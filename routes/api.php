<?php

use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

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

Route::post('auth/register', [\App\Http\Controllers\Api\V1\AuthController::class, 'register']);
Route::post('auth/login/{mode?}', [\App\Http\Controllers\Api\V1\AuthController::class, 'login']);
Route::post('emailRegister', [\App\Http\Controllers\Api\V1\AuthController::class, 'emailRegister']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('users/{id}', function ($id) {        $user = User::findOrFail($id);
        return response()->json($user);
    });
    Route::post('logout', [UserController::class, 'logout']);
    // Route::get('users/{user}', [UserController::class, 'getUserName']);
   
    Route::get('profile/{user:username?}', [UserController::class, 'profile']);
    Route::get('getProfile/{user:username?}', [UserController::class, 'getProfile']);
    // Route::match(['put', 'patch'], 'profile',[UserController::class, 'updateProfile']);
    Route::post('profile', [UserController::class, 'updateProfile']);
    // Route::patch('newUpdateProfile', [UserController::class, 'newUpdateProfile']);
    Route::post('update-password', [UserController::class, 'updatePassword']);


    Route::apiResource('project',ProjectController::class);
  



});
