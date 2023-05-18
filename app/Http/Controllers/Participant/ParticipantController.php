<?php

namespace App\Http\Controllers\Participant;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Validator;
use App\Models\Participant;
use Inertia\Inertia;

class ParticipantController extends Controller {
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
                    'dni' => 'required|unique:participants,dni|integer|digits:8',
                    'grade' => 'required|integer|between:1,7',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        $participant = Participant::create([
                    'name' => $request['name'],
                    'dni' => (int)$request['dni'],
                    'grade' => (int)$request['grade'],
        ]);
        return Inertia::render('Participant/Code', ['code' => $participant->id, 'success' => true]);
    }

}