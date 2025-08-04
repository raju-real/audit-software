<?php

use Illuminate\Support\Facades\Route;

Route::view('login','admin.auth.app2')->name('login');
Route::middleware('auth')->group(function () {
    //
});

