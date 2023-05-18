<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Middleware\UserType;
use App\Models\Participant;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome');

Route::get('/participant/register', function () {
    return Inertia::render('Participant/Register');
})->name('participant-register');

Route::get('/participant/code', function (Request $request) {
    $participant = Participant::where('dni', $request->dni)->first();
    if (!$participant) return redirect()->back();
    return Inertia::render('Participant/Code', ['code' => $participant->id]);
})->name('participant-code');

Route::post('/participant/register', 'App\Http\Controllers\Participant\ParticipantController@store')->name('participant-register');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    UserType::class
])->group(function () {
    Route::get('/dashboard', function (Request $request) {
        return Inertia::render('Dashboard', ['user_type' => $request->user_type]);
    })->name('dashboard');
});

require 'admin.php';
