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

            $table->foreignId('game_id')
                ->constrained('games')->cascadeOnDelete();

            $table->foreignId('player_id')->nullable()
                ->constrained('players')->onDelete('SET NULL');

            $table->foreignId('helper_id')->nullable()
                ->constrained('players')->onDelete('SET NULL');

            $table->integer('ingame_player_id')
                ->default(0);

            $table->string('role')
                ->default('red');

            $table->tinyInteger('fouls')
                ->default(0);

            $table->boolean('is_removed')
                ->default(false);

            $table->double('score')
                ->default(0.0);

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
