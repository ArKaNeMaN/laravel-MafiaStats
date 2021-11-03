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

            $table->foreignId('game_id')
                ->constrained('games')->cascadeOnDelete();

            $table->integer('ingame_id');

            $table->foreignId('killed_id')->nullable()
                ->constrained('games__players')->onDelete('SET NULL');

            $table->foreignId('checked_don_id')->nullable()
                ->constrained('games__players')->onDelete('SET NULL');

            $table->foreignId('checked_sheriff_id')->nullable()
                ->constrained('games__players')->onDelete('SET NULL');

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
