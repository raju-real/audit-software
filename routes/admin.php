<?php

use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StepQuestionController;
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
    Route::resource('designations',DesignationController::class);
    Route::resource('staffs',StaffController::class);
    // Audit step
    Route::resource('audit-steps', AuditStepController::class);
    Route::controller(AuditStepController::class)->group(function () {
        Route::put('update-step-status/{id}', 'updateStepStatus')->name('update-step-status');
        Route::post('sort-audit-steps', 'sortSteps')->name('sort-audit-steps');
    });
    Route::controller(StepQuestionController::class)->group(function () {
        Route::get('question-list/{step_slug}', 'questionList')->name('question-list');
        Route::get('add-question/{step_slug}', 'addQuestion')->name('add-question');
        Route::post('store-question', 'storeQuestion')->name('store-question');
        Route::get('edit-question/{question_slug}','editQuestion')->name('edit-question');
        Route::put('update-question/{question_slug}','updateQuestion')->name('update-question');
        Route::delete('delete-question/{question_slug}','deleteQuestion')->name('delete-question');
        Route::put('update-question-status/{id}', 'updateQuestionStatus')->name('update-question-status');
        Route::post('sort-questions', 'sortQuestions')->name('sort-questions');
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
