<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesVotingsVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games__votings__votes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('voting_id')
                ->constrained('games__votings')->cascadeOnDelete();

            $table->foreignId('game_player_id')
                ->constrained('games__players')->onDelete('SET NULL');

            $table->foreignId('voted_id')
                ->constrained('games__players')->onDelete('SET NULL');

            $table->boolean('for_accident')->default(false);

            $table->unique(['voting_id', 'game_player_id', 'for_accident'], 'unique_vote_for_player');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games__votings__votes');
    }
}
