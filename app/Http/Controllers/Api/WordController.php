<?php

namespace App\Http\Controllers\Api;

use App\Actions\CreateWord;
use App\Http\Controllers\Controller;
use App\Http\Resources\WordResource;
use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
    public function index()
    {
        $words = Word::all();

        return WordResource::collection($words);
    }

    public function store(Request $request, CreateWord $createWordAction)
    {
        $validated = $request->validate([
            'word' => ['required', 'alpha:ascii', 'min:6', 'max:14', 'unique:words,word'],
        ]);

        $word = $createWordAction->handle($validated['word']);

        return new WordResource($word);
    }
}
