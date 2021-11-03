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

            $table->foreignId('tournament_id')->nullable()
                ->constrained('tournaments')->onDelete('SET NULL');

            $table->foreignId('leader_id')->nullable()
                ->constrained('players')->onDelete('SET NULL');

            $table->foreignId('best_red_id')->nullable()
                ->constrained('players')->onDelete('SET NULL');

            $table->foreignId('best_black_id')->nullable()
                ->constrained('players')->onDelete('SET NULL');

            $table->string('result')
                ->nullable();

            $table->timestamp('date');
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
