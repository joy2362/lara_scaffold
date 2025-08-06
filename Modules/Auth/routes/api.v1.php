<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\Api\V1\AuthController;

Route::controller(AuthController::class)->name('auth.')->group(function () {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
    Route::post('forget-password', 'forgetPassword')->name('forget.password');
    Route::get('verify-reset-otp', 'verifyResetOtp')->name('verify.reset.otp');
    Route::post('reset-password', 'resetPassword')->name('reset.password');
});
