<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Admin\AdminLogin;
use App\Http\Controllers\Admin\AuditStepController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'admin.admin_login')->name('home');
Route::post('admin-login', AdminLogin::class)->middleware('throttle:5,1')->name('admin-login');

Route::group(['as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('dashboard', 'dashboard')->name('dashboard');
    });
    Route::controller(ProfileController::class)->group(function () {
        Route::get('profile', 'profile')->name('profile');
        Route::put('update-profile', 'updateProfile')->name('update-profile');
        Route::view('mobile-verification', 'admin.profile.verify_mobile')->name('mobile-verification');
        Route::post('send-verification-code', 'sendVerificationCode')->name('send-verification-code');
        Route::post('verify-code', 'verifyCode')->name('verify-code');
    });
    // Audit step
    Route::controller(AuditStepController::class)->group(function() {

    });
    // Only for administrator
    Route::middleware('administrator')->group(function () {
        // Settings
        Route::controller(SettingController::class)->group(function () {
            Route::get('site-settings', 'siteSettings')->name('site-settings');
            Route::put('update-site-settings', 'updateSiteSettings')->name('update-site-settings');
        });
    });
});


Route::get('logout', function () {
    Auth::logout();
    Session::reflash();
    return redirect()->route('home');
})->name('admin.logout');

Route::get('bulk-operation', function () {
    //
});
