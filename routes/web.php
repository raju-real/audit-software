<?php

use Illuminate\Support\Facades\Route;

Route::view('login','admin.admin_login')->name('login');
Route::middleware('auth')->group(function () {
    //
});

