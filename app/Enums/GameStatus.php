<?php

namespace App\Enums;

enum GameStatus: string
{
    case IN_PROGRESS = 'IN_PROGRESS';
    case WON = 'WON';
    case LOST = 'LOST';
}
