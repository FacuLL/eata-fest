<?php

namespace App\Http\Controllers\Game;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Validator;
use App\Models\Game;
use App\Models\User;
use Auth;

class GameController extends Controller {

    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $guard
     * @return void
     */
    public function __construct(StatefulGuard $guard) {
        $this->guard = $guard;
    }

    /**
     * Create a new registered user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laravel\Fortify\Contracts\CreatesNewUsers  $creator
     * @return \Laravel\Fortify\Contracts\RegisterResponse
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'logo_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                                ->withErrors($validator)
                                ->withInput();
        }
        $game = Game::create([
            'name' => $request['name'],
            'logo_id' => $request['logo_id'],
        ]);
        return redirect()->back()->with('success', 'Se creó el juego correctamente');
    }

    public function delete(Request $request) {
        Game::destroy((int)$request->id);
        return redirect()->back()->with('success', 'Se eliminó el juego correctamente');
    }

    public function addUser(Request $request) {
        $game = Game::with('users')->find((int)$request['game']);
        $user = User::find((int)$request['user']);
        if (!$game || !$user) return redirect()->back();
        foreach ($game->users as $theuser) {
            if ($theuser->id == $user->id) return redirect()->back();
        }
        $game->users()->attach($user);
        return redirect()->back();
    }

    public function deleteUser(Request $request) {
        $game = Game::find((int)$request->game);
        $user = User::with('games')->find((int)$request->user);
        if (!$game || !$user) return redirect()->back();
        $game->users()->detach((int)$request->user);
        return redirect()->back();
    }

}