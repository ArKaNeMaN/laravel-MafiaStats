<?php

namespace Database\Factories;

use App\Models\GameVoting;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameVotingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GameVoting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

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
        });
    }
}
