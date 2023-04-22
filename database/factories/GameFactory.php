<?php

namespace Database\Factories;

use App\Enums\GameDifficulty;
use App\Enums\GameStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'word_id' => 1,
            'difficulty' => GameDifficulty::EASY,
            'correct_letters' => '',
            'incorrect_letters' => '',
            'current_word' => '',
            'remaining_letters' => '',
            'status' => fake()->randomElement([GameStatus::LOST, GameStatus::WON]),
        ];
    }
}
