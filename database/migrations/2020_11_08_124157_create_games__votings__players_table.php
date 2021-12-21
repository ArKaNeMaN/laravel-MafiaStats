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
//                ->constrained('games__votings')->cascadeOnDelete();

            $table->foreignId('game_player_id');
//                ->constrained('games__players')->onDelete('SET NULL');

            $table->foreignId('nominator_id');
//                ->constrained('games__players')->onDelete('SET NULL');

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
