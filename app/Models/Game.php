<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $hidden = [
        'remaining_letters',
    ];

    protected $guarded = ['id'];

    protected function guessedLetters(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['incorrect_letters'] . $attributes['correct_letters']
        );
    }

    protected function remainingIncorrectGuesses(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => 6 - strlen($attributes['incorrect_letters'])
        );
    }
}
