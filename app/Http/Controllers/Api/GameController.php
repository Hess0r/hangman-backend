<?php

namespace App\Http\Controllers\Api;

use App\Actions\CreateGame;
use App\Actions\EndGameIfExists;
use App\Actions\Guess;
use App\Enums\GameDifficulty;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Models\Game;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;

class GameController extends Controller
{
    /**
     * Create new game
     */
    public function store(Request $request, EndGameIfExists $endGameIfExistsAction, CreateGame $createGameAction)
    {
        $validated = $request->validate([
            'difficulty' => ['required', 'string', new Enum(GameDifficulty::class)],
        ]);

        $endGameIfExistsAction->handle($request->user()->gameInProgress);

        $difficulty = GameDifficulty::from($validated['difficulty']);

        [$l, $h] = $difficulty->bounds();

        $word = Word::whereRaw('LENGTH(word) >= ?', [$l])
            ->whereRaw('LENGTH(word) <= ?', [$h])
            ->whereNotIn('id', $request->user()->games()->get()->pluck('id')->toArray())
            ->inRandomOrder()
            ->first();

        abort_if(is_null($word), 400, 'There are no unplayed words left in this difficulty');

        $game = $createGameAction->handle($request->user(), $word, $difficulty);

        return new GameResource($game);
    }

    /**
     * Get current game
     */
    public function show()
    {
        $game = $this->getCurrentGameOrFail();

        return new GameResource($game);
    }

    /**
     * Guess letter
     */
    public function update(Request $request, Guess $guessAction)
    {
        $validated = $request->validate([
            'letter' => ['required', 'string', 'size:1'],
        ]);

        $letter = Str::lower($validated['letter']);

        $game = $this->getCurrentGameOrFail();

        abort_if(strpos($game->guessed_letters, $letter), 400, 'This letter has already been guessed');

        $game = $guessAction->handle($game, $letter);

        return new GameResource($game);
    }

    /**
     * End game in progress if exists
     */
    public function destroy(Request $request, EndGameIfExists $endGameIfExistsAction)
    {
        $endGameIfExistsAction->handle($request->user()->gameInProgress);

        return response()->noContent();
    }

    private function getCurrentGameOrFail(): Game
    {
        $game = request()->user()->gameInProgress;

        abort_if(is_null($game), 400, 'There is no game in progress');

        return $game;
    }
}
