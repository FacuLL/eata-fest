<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminAccepted;
use App\Http\Middleware\UserType;
use App\Models\Game;
use App\Models\Participant;
use App\Models\User;
use Inertia\Inertia;

Route::group(['prefix' => 'admin'], function () {

    Route::post('/register', 'App\Http\Controllers\Admin\RegisteredAdminController@store')->name('admin-register');

    Route::get('/register', 'App\Http\Controllers\Admin\RegisteredAdminController@create')->name('doctor-register');

    Route::get('/login', 'App\Http\Controllers\Admin\AuthenticatedSessionController@create')->name('doctor-login');
            
    Route::post('/login', 'App\Http\Controllers\Admin\AuthenticatedSessionController@store')->name('admin-login');

    Route::post('/logout', 'App\Http\Controllers\Admin\AuthenticatedSessionController@destroy')->name('admin-logout');

    Route::middleware(['auth:admin', 'verified', AdminAccepted::class, UserType::class])->group(static function () {
            // General routes
            Route::get('/dashboard', function(Request $request) {
                $users = [];
                if ($request->name) $users = User::with('games')->where('name', 'LIKE', '%'.$request->name.'%')->get();
                $games = Game::all();
                return Inertia::render('Admin/AdminDashboard', ['user_type' => $request->user_type, 'users' => $users, 'games' => $games]);
            })->name('admin-dashboard');
            Route::post('/game', 'App\Http\Controllers\Game\GameController@store')->name('admin-game');
            Route::delete('/game', 'App\Http\Controllers\Game\GameController@delete')->name('admin-game-delete'); 
            Route::post('/user-game', 'App\Http\Controllers\Game\GameController@addUser')->name('admin-user-game');
            Route::delete('/user-game', 'App\Http\Controllers\Game\GameController@deleteUser')->name('admin-user-game-delete');
            Route::get('/ranking', function () {
                $participants = Participant::offset(0)->limit(20)->orderBy('points', 'desc')->get();
                return Inertia::render('Ranking', ["participants" => $participants]);
            })->name('ranking');
    });

    
 
 });