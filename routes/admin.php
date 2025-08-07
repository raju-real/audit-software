<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Admin\AdminLogin;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\AuditorActivityController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\FinancialYearController;
use App\Http\Controllers\Admin\AuditStepController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\StepQuestionController;
use App\Http\Controllers\Admin\SupervisorActivityController;
use App\Http\Controllers\Admin\TwoFactorAuthController;
use App\Http\Controllers\Admin\TwoFactorSetupController;
use App\Http\Controllers\XlPreview;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'admin.auth.app2')->name('home');
Route::post('admin-login', AdminLogin::class)->middleware('throttle:5,1')->name('admin-login');

Route::view('permission-denied', 'admin.permission_denied')->name('admin.permission-denied');

Route::controller(TwoFactorController::class)->middleware('auth')->group(function () {
    Route::get('/2fa/verify', 'show')->name('admin.2fa.verify');
    Route::post('/2fa/verify', 'verify')->name('admin.2fa.verify.post');
});

Route::group(['as' => 'admin.', 'middleware' => ['auth', '2fa.verified']], function () {

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

    Route::resource('designations', DesignationController::class);
    Route::resource('staffs', StaffController::class);
    Route::controller(StaffController::class)->group(function () {
        Route::put('update-staff-status/{id}', 'updateStaffStatus')->name('update-staff-status');
    });
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
        Route::get('edit-question/{question_slug}', 'editQuestion')->name('edit-question');
        Route::put('update-question/{question_slug}', 'updateQuestion')->name('update-question');
        Route::delete('delete-question/{question_slug}', 'deleteQuestion')->name('delete-question');
        Route::put('update-question-status/{id}', 'updateQuestionStatus')->name('update-question-status');
        Route::post('sort-questions', 'sortQuestions')->name('sort-questions');
    });
    Route::resource('organizations', OrganizationController::class);
    Route::controller(OrganizationController::class)->group(function () {
        Route::put('update-organization-status/{id}', 'updateOrganizationStatus')->name('update-organization-status');
    });
    Route::resource('financial-years', FinancialYearController::class);

    // ===================================================================
    // AUDITOR ACTIVITY ROUTES
    // ===================================================================
    Route::controller(AuditorActivityController::class)->group(function () {
        Route::get('auditor-audits', 'auditList')->name('auditor-audits');
        Route::get('auditor-audit-steps/{audit_id}', 'auditSteps')->name('auditor-audit-steps');
        Route::get('auditor-step-questions/{step_id}', 'stepQuestions')->name('auditor-step-questions');
        Route::get('auditor-preview-questions/{step_id}', 'previewQuestions')->name('auditor-preview-questions');
        Route::put('submit-answer/{step_id}', 'submitAnswer')->name('submit-answer');
        Route::get('auditor-step-details/{step_id}', 'stepDetails')->name('auditor-step-details');
        Route::get('audit-wise-auditor-balance-sheet/{audit_id}', 'balanceSheet')->name('audit-wise-auditor-balance-sheet');
        Route::post('auditor-upload-balance-sheet/{audit_id}', 'uploadBalanceSheet')->name('auditor-upload-balance-sheet');
    });
    // ===================================================================
    // Supervisor ACTIVITY ROUTES
    // ===================================================================
    Route::controller(SupervisorActivityController::class)->group(function () {
        Route::get('supervisor-audits', 'auditList')->name('supervisor-audits');
        Route::get('supervisor-audit-steps/{audit_id}', 'auditSteps')->name('supervisor-audit-steps');
        Route::get('review-step-answer/{step_id}', 'reviewStepAnswer')->name('review-step-answer');
        Route::get('supervised-step-status', 'changeStatus')->name('supervised-step-status');
        Route::post('supervisor-return-audit/{step_id}', 'returnAudit')->name('supervisor-return-audit');
        Route::post('supervisor-reject-audit/{step_id}', 'rejectAudit')->name('supervisor-reject-audit');
        Route::get('audit-wise-supervisor-balance-sheet/{audit_id}', 'balanceSheet')->name('audit-wise-supervisor-balance-sheet');
    });
    // ===================================================================
    // ONLY FOR ADMINISTRATOR ROUTES
    // ===================================================================
    Route::middleware('administrator')->group(function () {
        Route::resource('audits', AuditController::class);
        Route::controller(AuditController::class)->group(function () {
            Route::put('update-audit-status/{id}', 'updateAuditStatus')->name('update-audit-status');
            Route::get('audit-wise-activators', 'auditActivators')->name('audit-wise-activators');
            Route::get('audit-wise-balance-sheet/{audit_id}', 'balanceSheet')->name('audit-wise-balance-sheet');
        });
        // Settings
        Route::controller(SettingController::class)->group(function () {
            Route::get('site-settings', 'siteSettings')->name('site-settings');
            Route::put('update-site-settings', 'updateSiteSettings')->name('update-site-settings');
        });
    });

    Route::post('xl-file-preview', XlPreview::class)->name('xl-file-preview');

});


Route::get('logout', function () {
    Auth::logout();
    Session::reflash();
    return redirect()->route('home');
})->name('admin.logout');

Route::get('bulk-operation', function () {
    //
});
