<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserScoreResource;
use App\Models\UserScore;
use Illuminate\Support\Facades\Auth;

class UserScoreController extends Controller
{
    public function index()
    {
        $scoreBoard = UserScore::orderBy('rank')->take(10)->get();

        if (Auth::guard('sanctum')->check()) {
            $user = Auth::guard('sanctum')->user();
            if (! $scoreBoard->contains($user)) {
                $scoreBoard->pop();

                $scoreBoard->push(UserScore::firstWhere('id', $user->id));
            }
        }

        return UserScoreResource::collection($scoreBoard);
    }
}
