<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WordSeeder extends Seeder
{
    private $initialWords = [
        'reward',
        'shiver',
        'regret',
        'carbon',
        'island',
        'impound',
        'extreme',
        'inspire',
        'finance',
        'control',
        'collapse',
        'medicine',
        'frighten',
        'observer',
        'classify',
        'monstrous',
        'orchestra',
        'executive',
        'fireplace',
        'essential',
        'prevalence',
        'background',
        'particular',
        'attraction',
        'pedestrian',
        'unfortunate',
        'charismatic',
        'institution',
        'destruction',
        'presentation',
        'manufacturer',
        'interference',
        'announcement',
        'presidential',
        'inappropriate',
        'embarrassment',
        'consideration',
        'comprehensive',
        'communication',
        'representative',
        'responsibility',
        'constitutional',
        'discrimination',
        'recommendation',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->initialWords as $word) {
            \App\Models\Word::create(['word' => $word]);
        }
    }
}
