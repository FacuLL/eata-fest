<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Middleware\UserType;
use App\Models\Game;
use App\Models\Participant;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

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

Route::get('/ranking', function () {
    $participants = Participant::offset(0)->limit(20)->orderBy('points', 'desc')->get();
    return Inertia::render('Ranking', ["participants" => $participants]);
})->name('ranking');

Route::post('/participant/register', 'App\Http\Controllers\Participant\ParticipantController@store')->name('participant-register');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    UserType::class
])->group(function () {
    Route::get('/dashboard', function (Request $request) {
        $user = Auth::guard('sanctum')->user();
        return Inertia::render('Dashboard', ['user_type' => $request->user_type, 'games' => $user->games]);
    })->name('dashboard');
    Route::get('/dashboard/game', function (Request $request) {
        $error = null;
        $id = Auth::guard('sanctum')->user()->id;
        $game = Game::with(['users' => function ($query) use ($id) {
            $query->where('id', '=', $id);
        }])->find($request->id);
        if (!$game) return null;
        $participant = Participant::find($request->participant);
        if ($request->participant && !$participant) $error = 'Participante no encontrado';
        return Inertia::render('Game', ['user_type' => $request->user_type, 'game' => $game, 'participant' => $participant, 'error' => $error]);
    })->name('dashboard-game');
    Route::post('/dashboard/transaction', 'App\Http\Controllers\Transaction\TransactionController@store');
    Route::get('/dashboard/transaction', function (Request $request) {
        $transaction = Transaction::with(['game', 'user', 'participant'])->find($request->id);
        if (!$transaction) redirect()->back();
        return Inertia::render('Transaction', ['user_type' => $request->user_type, 'transaction' => $transaction, 'success' => $request->success]);
    })->name('dashboard-transaction');
});

require 'admin.php';
