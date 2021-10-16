<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games__players', function (Blueprint $table) {
            $table->id();

            $table->foreignId('game_id');
            $table->foreign('game_id')->references('id')->on('games');

            $table->foreignId('player_id');
            $table->foreign('player_id')->references('id')->on('players');

            $table->foreignId('helper_id')->nullable();
            $table->foreign('helper_id')->references('id')->on('players');

            $table->integer('ingame_player_id')->default(0);
            $table->enum('role', App\Models\GamePlayer::ROLES)->default('red');
            $table->tinyInteger('fouls')->default(0);
            $table->boolean('is_removed')->default(false);
            $table->double('score')->default(0.0);

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
        Schema::dropIfExists('games__players');
    }
}
