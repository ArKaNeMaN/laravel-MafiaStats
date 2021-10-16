<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesNightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games__nights', function (Blueprint $table) {
            $table->id();

            $table->foreignId('game_id');
            $table->foreign('game_id')->references('id')->on('games');

            $table->integer('ingame_id');

            $table->foreignId('killed_id')->nullable();
            $table->foreign('killed_id')->references('id')->on('games__players');

            $table->foreignId('checked_don_id')->nullable();
            $table->foreign('checked_don_id')->references('id')->on('games__players');

            $table->foreignId('checked_sheriff_id')->nullable();
            $table->foreign('checked_sheriff_id')->references('id')->on('games__players');

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
        Schema::dropIfExists('games__nights');
    }
}
