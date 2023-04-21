<?php

namespace App\Actions;

use App\Enums\GameStatus;
use App\Models\Game;
use Illuminate\Support\Str;

class Guess
{
    public function handle(Game $game, string $letter): Game
    {
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

                $game->current_word = $game->word->word;
            }

        }

        $game->save();

        return $game;
    }
}
