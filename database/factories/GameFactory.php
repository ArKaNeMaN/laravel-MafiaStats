<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\Tournament;
use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\GameNight;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Game::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tournament_id' => random_int(0, 1) ? Tournament::inRandomOrder()->first()->id : null,
            'leader_id' => Player::inRandomOrder()->first()->id,
            'result' => $this->faker->randomElement(Game::RESULTS),
            'date_time' => $this->faker->dateTime(),
            'played' => (bool) random_int(0, 1),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Game $game) {
            // Create players
            $players = Player::where('id', '!=', $game->leader_id)->inRandomOrder()->limit(10)->get();
            $roles = $this->faker->shuffle(['black', 'black', 'don', 'sheriff', 'red', 'red', 'red', 'red', 'red', 'red']);
            for($i = 1; $i <= 10; $i++)
                GamePlayer::factory()->state([
                    'game_id' => $game->id,
                    'player_id' => $players[$i-1]->id,
                    'role' => $roles[$i-1],
                    'ingame_player_id' => $i,
                ])->create();

            // Create nights
            $players = GamePlayer::where('game_id', $game->id)->inRandomOrder()->get();
            for($i = 1; $i <= 5; $i++)
                GameNight::factory()->state([
                    'game_id' => $game->id,
                    'ingame_id' => $i,
                    'killed_id' => $players[random_int(0, count($players)-1)]->id,
                    'checked_don_id' => $players[random_int(0, count($players)-1)]->id,
                    'checked_sheriff_id' => $players[random_int(0, count($players)-1)]->id,
                ])->create();
        });
    }
}
