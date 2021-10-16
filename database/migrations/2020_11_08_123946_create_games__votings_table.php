<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesVotingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games__votings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('game_id');
            $table->foreign('game_id')->references('id')->on('games');

            $table->integer('ingame_id');
            $table->integer('votes_for_both')->default(0);

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
        Schema::dropIfExists('games__votings');
    }
}
