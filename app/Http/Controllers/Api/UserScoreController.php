<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserScoreResource;
use App\Models\UserScore;
use Illuminate\Http\Request;

class UserScoreController extends Controller
{
    public function index(Request $request)
    {
        $scoreBoard = UserScore::orderBy('rank')->take(10)->get();

        if (! $scoreBoard->contains($request->user())) {
            $scoreBoard->pop();

            $scoreBoard->push(UserScore::firstWhere('id', $request->user()->id));
        }

        return UserScoreResource::collection($scoreBoard);
    }
}
