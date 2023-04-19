<?php

namespace App\Enums;

enum GameDifficulty: string
{
    case EASY = 'EASY';
    case MEDIUM = 'MEDIUM';
    case HARD = 'HARD';

    public function bounds(): array
    {
        return match ($this) {
            GameDifficulty::EASY => [6, 8],
            GameDifficulty::MEDIUM => [9, 11],
            GameDifficulty::HARD => [12, 14],
        };
    }
}
