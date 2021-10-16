<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesVotingsPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games__votings__players', function (Blueprint $table) {
            $table->id();

            $table->foreignId('voting_id');
            $table->foreign('voting_id')->references('id')->on('games__votings');

            $table->foreignId('game_player_id');
            $table->foreign('game_player_id')->references('id')->on('games__players');

            $table->foreignId('nominator_id');
            $table->foreign('nominator_id')->references('id')->on('games__players');

            $table->boolean('is_accident')->default(false);
            $table->boolean('is_kicked')->default(false);

            $table->unique(['voting_id', 'game_player_id']);

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
        Schema::dropIfExists('games__votings__players');
    }
}
