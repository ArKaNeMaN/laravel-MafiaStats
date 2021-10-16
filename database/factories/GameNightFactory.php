<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\GameNight;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameNightFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GameNight::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $game = Game::inRandomOrder()->first();
        $players = GamePlayer::where('game_id', $game->id)->inRandomOrder()->get();
        return [
            'game_id' => $game->id,
            'ingame_id' => $game->nights->count()+1,
            'killed_id' => count($players) ? $players[random_int(0, count($players)-1)]->id : null,
            'checked_don_id' => count($players) ? $players[random_int(0, count($players)-1)]->id : null,
            'checked_sheriff_id' => count($players) ? $players[random_int(0, count($players)-1)]->id : null,
        ];
    }
}
