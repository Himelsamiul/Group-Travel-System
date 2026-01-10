<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\WebHomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\PlaceController;
use App\Http\Controllers\Backend\HotelController;
use App\Http\Controllers\Backend\TransportationController;
use App\Http\Controllers\Backend\TourPackageController;

//admin
Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/do-login', [AuthController::class, 'doLogin'])->name('do.login');
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

        // Admin - Tourist Management (using WebAuthController)
Route::get('/tourists', [WebAuthController::class, 'touristIndex'])->name('tourists');
Route::delete('/tourists/{id}', [WebAuthController::class, 'touristDelete'])->name('tourists.delete');
    //place 
Route::get('/places', [PlaceController::class, 'index'])->name('places.index');
Route::post('/places', [PlaceController::class, 'store'])->name('places.store');
Route::get('/places/{id}/edit', [PlaceController::class, 'edit'])->name('places.edit');
Route::put('/places/{id}', [PlaceController::class, 'update'])->name('places.update');
Route::delete('/places/{id}', [PlaceController::class, 'destroy'])->name('places.destroy');
// hotel
Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
Route::post('/hotels', [HotelController::class, 'store'])->name('hotels.store');
Route::get('/hotels/{id}/edit', [HotelController::class, 'edit'])->name('hotels.edit');
Route::put('/hotels/{id}', [HotelController::class, 'update'])->name('hotels.update');
Route::delete('/hotels/{id}', [HotelController::class, 'destroy'])->name('hotels.destroy');

// transportation
Route::get('/transportations', [TransportationController::class, 'index'])->name('transportations.index');
Route::post('/transportations', [TransportationController::class, 'store'])->name('transportations.store');
Route::get('/transportations/{id}/edit', [TransportationController::class, 'edit'])->name('transportations.edit');
Route::put('/transportations/{id}', [TransportationController::class, 'update'])->name('transportations.update');
Route::delete('/transportations/{id}', [TransportationController::class, 'destroy'])->name('transportations.destroy');

    Route::get('/tour-packages', [TourPackageController::class, 'index'])->name('tour-packages.index');
    Route::get('/tour-packages/create', [TourPackageController::class, 'create'])->name('tour-packages.create');
    Route::post('/tour-packages', [TourPackageController::class, 'store'])->name('tour-packages.store');
    Route::get('/tour-packages/{id}/edit', [TourPackageController::class, 'edit'])->name('tour-packages.edit');
    Route::put('/tour-packages/{id}', [TourPackageController::class, 'update'])->name('tour-packages.update');
    Route::delete('/tour-packages/{id}', [TourPackageController::class, 'destroy'])->name('tour-packages.destroy');

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
