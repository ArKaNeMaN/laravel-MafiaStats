<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Player;
use App\Models\GamePlayer;
use Illuminate\Database\Eloquent\Factories\Factory;

class GamePlayerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GamePlayer::class;

    protected static $gamesPlayersCounter = [];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $game = Game::inRandomOrder()->first();
        $player = Player::inRandomOrder()->first();

        if(!isset(self::$gamesPlayersCounter[$game->id]))
            self::$gamesPlayersCounter[$game->id] = 1;
        else self::$gamesPlayersCounter[$game->id]++;

        return [
            'game_id' => $game->id,
            'player_id' => $player->id,
            'helper_id' => random_int(1, 25) == 1 ? Player::where('id', '!=', $player->id)->inRandomOrder()->first()->id : null,
            'ingame_player_id' => self::$gamesPlayersCounter[$game->id],
            'role' => $this->faker->randomElement(['black', 'black', 'don', 'sheriff', 'red', 'red', 'red', 'red', 'red', 'red']),
        ];
    }
}
