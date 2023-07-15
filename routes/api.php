<?php

use App\Http\Controllers\ArticlesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group(['prefix'=>'v1','middleware'=>'cors'], function (){

    //AUTH ROUTES,'middleware' =>['auth:api']
    Route::group(['prefix' => 'auth'], function (){
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware(['jwt.cookie','jwt'])->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware(['jwt.cookie','jwt'])->name('refresh');
    });

    Route::middleware(['jwt.cookie','jwt','auth:api'])->group(function () {
        // Add your protected routes here
        Route::get('user', function (Request $request) {
            return $request->user();
        });
        Route::apiResource('articles', ArticlesController::class);
        Route::put('/profile/edit',[ProfileController::class, 'updateProfile']);
        Route::patch('/profile/edit',[ProfileController::class, 'updateProfile']);
        Route::put('/profile/preferences/edit',[ProfileController::class, 'updateProfilePreference']);
        Route::patch('/profile/preferences/edit',[ProfileController::class, 'updateProfilePreference']);

    });   
});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
