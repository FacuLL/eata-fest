<?php

namespace App\Http\Controllers\Transaction;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Validator;
use App\Models\Participant;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TransactionController extends Controller {
    /**
     * Create a new registered user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Fortify\Contracts\RegisterResponse
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
                    'game' => 'required|integer|min:0',
                    'participant' => 'required|integer|min:0',
                    'points' => 'required|integer|min:1',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        $id = Auth::guard('sanctum')->user()->id;
        $game = Game::with(['users' => function ($query) use ($id) {
            $query->where('id', '=', $id);
        }])->find($request->game);
        if (!$game) return redirect()->back();
        $participant = Participant::find($request->participant);
        if (!$participant) return redirect()->back();
        $transaction = Transaction::create([
            'user_id' => $id,
            'game_id' => $game->id,
            'participant_id' => $participant->id,
            'points' => $request->points
        ]);
        $participant->update(['points' => ($participant->points + $request->points)]);
        return redirect('dashboard/transaction?id='.(string)$transaction->id.'&success=true');
    }

}