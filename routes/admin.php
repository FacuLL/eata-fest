<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminAccepted;
use App\Http\Middleware\UserType;
use Inertia\Inertia;

Route::group(['prefix' => 'admin'], function () {

    Route::post('/register', 'App\Http\Controllers\Admin\RegisteredAdminController@store')->name('admin-register');

    Route::get('/register', 'App\Http\Controllers\Admin\RegisteredAdminController@create')->name('doctor-register');

    Route::get('/login', 'App\Http\Controllers\Admin\AuthenticatedSessionController@create')->name('doctor-login');
            
    Route::post('/login', 'App\Http\Controllers\Admin\AuthenticatedSessionController@store')->name('admin-login');

    Route::post('logout', 'App\Http\Controllers\Admin\AuthenticatedSessionController@destroy')->name('admin-logout');

    Route::middleware(['auth:admin', 'verified', AdminAccepted::class, UserType::class])->group(static function () {
            // General routes
            Route::get('/dashboard', function(Request $request) {
                return Inertia::render('Admin/AdminDashboard', ['user_type' => $request->user_type]);
            })->name('admin-dashboard');
            Route::post('/game', 'App\Http\Controllers\Admin\GameController@store');
    });

    
 
 });