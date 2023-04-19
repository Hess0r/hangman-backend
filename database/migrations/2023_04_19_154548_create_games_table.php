<?php

use App\Enums\GameStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id');
            $table->foreignId('word_id');

            $table->string('correct_letters');
            $table->string('incorrect_letters');
            $table->string('current_word');
            $table->string('remaining_letters');
            $table->string('status')->default(GameStatus::IN_PROGRESS->value);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('word_id')->references('id')->on('words');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
