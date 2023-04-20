<?php

namespace App\Models;

use App\Enums\GameStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $hidden = [
        'remaining_letters',
    ];

    protected $casts = [
        'status' => GameStatus::class,
    ];

    protected function guessedLetters(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['incorrect_letters'].$attributes['correct_letters']
        );
    }

    protected function remainingIncorrectGuesses(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => 6 - strlen($attributes['incorrect_letters'])
        );
    }

    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class);
    }
}
