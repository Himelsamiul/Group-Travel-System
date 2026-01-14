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
use App\Http\Controllers\TourController;
use App\Http\Controllers\TourApplicationController;
use App\Http\Controllers\Backend\TourApprovalController;
use App\Http\Controllers\PaymentController;

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
        Route::put('/tourists/{id}/status', [WebAuthController::class, 'toggleTouristStatus'])->name('tourists.toggleStatus');
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
        //packages
        Route::get('/tour-packages', [TourPackageController::class, 'index'])->name('tour-packages.index');
        Route::get('/tour-packages/create', [TourPackageController::class, 'create'])->name('tour-packages.create');
        Route::post('/tour-packages', [TourPackageController::class, 'store'])->name('tour-packages.store');
        Route::get('/tour-packages/{id}/edit', [TourPackageController::class, 'edit'])->name('tour-packages.edit');
        Route::put('/tour-packages/{id}', [TourPackageController::class, 'update'])->name('tour-packages.update');
        Route::delete('/tour-packages/{id}', [TourPackageController::class, 'destroy'])->name('tour-packages.destroy');
        Route::get('/tour-packages/{id}', [TourPackageController::class, 'show'])->name('tour-packages.show');

        // Tour Approvals
        Route::get('/admin/tour-approvals', [TourApprovalController::class, 'index'])->name('admin.tour.approvals');
        Route::post('/admin/tour-approvals/{id}/approve', [TourApprovalController::class, 'approve'])->name('admin.tour.approvals.approve');
        Route::post('/admin/tour-payment/{id}/complete', [TourApprovalController::class, 'complete_payment'])->name('admin.tour.payment.complete');
        Route::post('/admin/tour-accept-cancel-request/{id}', [TourApprovalController::class, 'acceptRequest'])->name('admin.tour.accept.cancel.request');
        Route::post('/admin/tour-approvals/{id}/reject', [TourApprovalController::class, 'reject'])->name('admin.tour.approvals.reject');
            // Reports page
        Route::get('/admin/reports', [TourApprovalController::class, 'report'])->name('admin.reports');
        Route::get('/admin/contact-messages', [WebHomeController::class, 'contactMessages'])->name('admin.contact.messages');
        

    });
});

//website
Route::get('/', [WebHomeController::class, 'home'])->name('home');
Route::get('/about', [WebHomeController::class, 'about'])->name('about');
Route::get('/contact-us', [WebHomeController::class, 'contact'])->name('contact');
Route::post('/contact-us', [WebHomeController::class, 'contactSubmit'])->name('contact.submit');

// Route::get('/services', [WebHomeController::class, 'services'])->name('services');
Route::get('/registration', [WebAuthController::class, 'registration'])->name('web.registration');
Route::post('/do-registration', [WebAuthController::class, 'doRegistration'])->name('web.do.registration');

// Tour listing page
Route::get('/tour-packages', [TourController::class, 'index'])->name('tour.packages');
// Tour details page
Route::get('/tour-packages/{id}', [TourController::class, 'show'])->name('tour.packages.show');
Route::get('/login', [WebAuthController::class, 'login'])->name('web.login');
Route::post('/do-login', [WebAuthController::class, 'doLogin'])->name('web.do.login');
Route::group(['middleware' => 'touristAuth'], function () {
    Route::get('/logout', [WebAuthController::class, 'logout'])->name('web.logout');
    

    Route::get('/profile', [WebAuthController::class, 'profile'])->name('web.profile');
    // Tour application
    Route::post('/tour/{package}/apply', [TourApplicationController::class, 'apply'])->name('tour.apply');
    Route::get('/tour/{package}/apply', [TourApplicationController::class, 'showApplyForm'])->name('tour.apply.form');
    Route::get('/tour/payment/{id}', [PaymentController::class, 'start'])->name('tour.payment.start');
    Route::get('/tour/cancel/{id}', [WebAuthController::class, 'cancel'])->name('tour.booking.cancel');
});
Route::get('/tour/payment/callback', [PaymentController::class, 'callback'])->name('tour.payment.callback');
