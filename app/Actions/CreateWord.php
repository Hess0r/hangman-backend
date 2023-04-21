<?php

namespace App\Actions;

use App\Models\Word;

class CreateWord
{
    public function handle(string $word): Word
    {
        return Word::create(['word' => $word]);
    }
}
