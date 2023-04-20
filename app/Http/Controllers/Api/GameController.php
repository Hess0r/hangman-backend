<?php

namespace App\Http\Controllers\Api;

use App\Actions\CreateGame;
use App\Actions\Guess;
use App\Enums\GameDifficulty;
use App\Enums\GameStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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

    /**
     * Guess letter
     *
     * @return void
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'letter' => ['required', 'string', 'size:1'],
        ]);

        $letter = Str::lower($validated['letter']);

        $game = $request->user()->gameInProgress;

        abort_if(is_null($game), 400, 'There is no game in progress');

        abort_if(strpos($game->guessed_letters, $letter), 400, 'This letter has already been guessed');

        $correct = strpos($game->remaining_letters, $letter) !== false;

        if ($correct) {
            $game->remaining_letters = Str::replace($letter, '_', $game->remaining_letters);

            foreach (str_split($game->word->word) as $index => $l) {
                if ($l === $letter) {
                    $game->current_word = substr_replace($game->current_word, $letter, $index, 1);
                }
            }

            $game->correct_letters = $game->correct_letters.$letter;

            if ($game->current_word === $game->word->word) {
                $game->status = GameStatus::WON;
            }
        } else {
            $game->incorrect_letters = $game->incorrect_letters.$letter;

            if ($game->remaining_incorrect_guesses === 0) {
                $game->status = GameStatus::LOST;
            }
        }

        $game->save();

        return new GameResource($game);

        // correct or incorrect guess
        //
        // correct:
        //  replace in remaining_letters
        //  replace in current_word
        //  add to correct_letters
        //
        // incorrect:
        //  add to incorrect_words
        //
        // check if game finished:
        //  this was the last error -> LOST
        //  current_word equals $word->word / remaining letters is all '_' -> WON
    }
}
