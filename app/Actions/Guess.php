<?php

namespace App\Actions;

use App\Models\Game;

class Guess
{
    public function handle(Game $game, string $letter): Game
    {
        $correct = strpos($game->remaining_letters, $letter) !== false;

        return $game;
    }
}
