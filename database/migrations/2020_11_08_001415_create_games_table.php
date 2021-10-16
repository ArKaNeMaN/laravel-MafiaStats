<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tournament_id')->nullable();
            $table->foreign('tournament_id')->references('id')->on('tournaments');

            $table->foreignId('leader_id');
            $table->foreign('leader_id')->references('id')->on('players');

            $table->foreignId('best_red_id')->nullable();
            $table->foreign('best_red_id')->references('id')->on('players');

            $table->foreignId('best_black_id')->nullable();
            $table->foreign('best_black_id')->references('id')->on('players');

            $table->enum('result', [App\Models\Game::RESULTS]);
            $table->timestamp('date_time');
            $table->boolean('played')->default(false);
            $table->string('description', 256)->nullable();

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
        Schema::dropIfExists('games');
    }
}
