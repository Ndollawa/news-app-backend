<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\Auth\AuthController;
use App\Http\Controllers\v1\Articles\ArticlesController;
use App\Http\Controllers\v1\Profile\ProfileController;

Route::group(['prefix'=>'v1','middleware'=>'cors'], function (){

    //AUTH ROUTES,'middleware' =>['auth:api'],'auth:api'
    Route::group(['prefix' => 'auth'], function (){
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware(['jwt','auth:api'])->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware(['jwt.cookie','jwt'])->name('refresh');
    });
    Route::middleware(['jwt.cookie','jwt','auth:api'])->group(function () {
        // Add your protected routes here
        Route::get('user', function (Request $request) {
            return $request->user();
        });
        Route::put('/profile/update',[ProfileController::class, 'updateProfile']);
        Route::patch('/profile/update',[ProfileController::class, 'updateProfile']);
        Route::put('/profile/preferences/update',[ProfileController::class, 'updateProfilePreference']);
        Route::patch('/profile/preferences/update',[ProfileController::class, 'updateProfilePreference']);

        });   
    Route::get('/articles',[ArticlesController::class,'index']);
    Route::get('/articles/authors',[ArticlesController::class,'getAuthors']);
    Route::get('/articles/sources',[ArticlesController::class,'getSources']);
});



?>