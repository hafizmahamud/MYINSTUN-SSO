<?php

use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\User\AccountController;
use App\Http\Controllers\Frontend\User\DashboardController;
use App\Http\Controllers\Frontend\User\ProfileController;

/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/error', [HomeController::class, 'error'])->name('error');
Route::get('contact', [ContactController::class, 'index'])->name('contact');
Route::post('contact/send', [ContactController::class, 'send'])->name('contact.send');

/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 * These routes can not be hit if the password is expired
 */
Route::group(['middleware' => ['auth', 'password_expires']], function () {
    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        // User Dashboard Specific
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        // User Account Specific
        Route::get('profile', [DashboardController::class, 'profile'])->name('profile');
        Route::post('profile/update', [DashboardController::class, 'updateProfile'])->name('profile.update');

	Route::get('account', [AccountController::class, 'index'])->name('account');

        // User Profile Specific
        Route::get('profilepassword', [DashboardController::class, 'profilepassword'])->name('profilepassword');
        Route::post('profilepassword/update', [DashboardController::class, 'update'])->name('profilepassword.update');
    });
});
// register user
Route::get('register', [DashboardController::class, 'viewRegister'])->name('register');
Route::post('register/post', [DashboardController::class, 'register'])->name('register.post');
