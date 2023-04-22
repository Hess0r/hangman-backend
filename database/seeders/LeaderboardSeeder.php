<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;

class LeaderboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory(20)
            ->has(Game::factory()->count(fake()->randomNumber(2)))
            ->create();
    }
}
