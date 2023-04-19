<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'guessedLetters' => $this->guessed_letters,
            'remainingIncorrectGuesses' => $this->remaining_incorrect_guesses,
            'currentWord' => $this->current_word,
            'status' => $this->status,
        ];
    }
}
