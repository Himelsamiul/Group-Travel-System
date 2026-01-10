<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebHomeController;
use Illuminate\Support\Facades\Route;

//admin
Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/do-login', [AuthController::class, 'doLogin'])->name('do.login');
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});

//website
Route::get('/', [WebHomeController::class, 'home'])->name('home');
Route::get('/about', [WebHomeController::class, 'about'])->name('about');
Route::get('/contact-us', [WebHomeController::class, 'contact'])->name('contact');
Route::get('/services', [WebHomeController::class, 'services'])->name('services');
