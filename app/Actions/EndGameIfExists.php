<?php

namespace App\Actions;

use App\Enums\GameStatus;
use App\Models\Game;

class EndGameIfExists
{
    public function handle(?Game $game): void
    {
        if (! is_null($game)) {
            $game->status = GameStatus::LOST;

            $game->save();
        }
    }
}
