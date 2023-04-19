<?php

namespace App\Http\Controllers\Api;

use App\Actions\CreateGame;
use App\Enums\GameDifficulty;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class GameController extends Controller
{
    /**
     * Create new game
     *
     * @return void
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'difficulty' => ['required', 'string', new Enum(GameDifficulty::class)],
        ]);

        abort_if($request->user()->gameInProgress()->exists(), 400, 'A game is already in progress');

        [$l, $h] = (GameDifficulty::from($validated['difficulty']))->bounds();

        $word = Word::whereRaw('LENGTH(word) >= ?', [$l])
            ->whereRaw('LENGTH(word) <= ?', [$h])
            // ->whereNotIn([])
            ->inRandomOrder()
            ->first();

        abort_if(is_null($word), 400, 'There are no unplayed words left');

        $game = (new CreateGame())->handle($request->user(), $word);

        return new GameResource($game);
    }

    /**
     * Get current game
     *
     * @return void
     */
    public function show(Request $request)
    {
        $game = $request->user()->gameInProgress;

        abort_if(is_null($game), 400, 'There is no game in progress');

        return new GameResource($game);
    }
}
