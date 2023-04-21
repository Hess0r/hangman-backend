<?php

namespace App\Actions;

use App\Enums\GameDifficulty;
use App\Enums\GameStatus;
use App\Models\Game;
use App\Models\User;
use App\Models\Word;

class CreateGame
{
    public function handle(User $user, Word $word, GameDifficulty $difficulty): Game
    {
        $currentWord = implode('', collect(range(0, strlen($word->word) - 1))->map(fn () => '_')->toArray());

        $game = $user->games()->create([
            'word_id' => $word->id,
            'correct_letters' => '',
            'incorrect_letters' => '',
            'current_word' => $currentWord,
            'remaining_letters' => $word->word,
            'difficulty' => $difficulty,
            'status' => GameStatus::IN_PROGRESS,
        ]);

        return $game;
    }
}
