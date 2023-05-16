<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\Game;
use Auth;
use Inertia\Inertia;

class RegisteredUserController extends Controller {

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
        $user = Auth::guard('user')->user();
        dd($user);
        if ($user) {
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
            return redirect('admin/dashboard');
        }
    }

}