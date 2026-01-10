<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\WebHomeController;
use Illuminate\Support\Facades\Route;

//admin
Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/do-login', [AuthController::class, 'doLogin'])->name('do.login');
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

        // Admin - Tourist Management (using WebAuthController)
Route::get('/tourists', [WebAuthController::class, 'touristIndex'])
    ->name('tourists');

Route::delete('/tourists/{id}', [WebAuthController::class, 'touristDelete'])
    ->name('tourists.delete');

    });
});

//website
Route::get('/', [WebHomeController::class, 'home'])->name('home');
Route::get('/about', [WebHomeController::class, 'about'])->name('about');
Route::get('/services', [WebHomeController::class, 'services'])->name('services');
Route::get('/registration', [WebAuthController::class, 'registration'])->name('web.registration');
Route::post('/do-registration', [WebAuthController::class, 'doRegistration'])->name('web.do.registration');
Route::get('/login', [WebAuthController::class, 'login'])->name('web.login');
Route::post('/do-login', [WebAuthController::class, 'doLogin'])->name('web.do.login');
Route::group(['middleware' => 'touristAuth'], function () {
    Route::get('/logout', [WebAuthController::class, 'logout'])->name('web.logout');
    Route::get('/contact-us', [WebHomeController::class, 'contact'])->name('contact');

       Route::get('/profile', [WebAuthController::class, 'profile'])->name('web.profile');
});
