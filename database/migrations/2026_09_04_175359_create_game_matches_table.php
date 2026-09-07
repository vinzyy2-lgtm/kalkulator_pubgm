<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_matches', function (Blueprint $table) {
            $table->id();
            $table->integer('match_number');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_matches');
    }
};
