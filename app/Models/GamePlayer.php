<?php

namespace App\Models;

use Database\Factories\GamePlayerFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\GamePlayer
 *
 * @property int $id
 * @property int $game_id
 * @property int $player_id
 * @property int|null $helper_id
 * @property int $ingame_player_id
 * @property string $role
 * @property int $fouls
 * @property int $is_removed
 * @property float $score
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|GameNight[] $checked_don
 * @property-read int|null $checked_don_count
 * @property-read Collection|GameNight[] $checked_seriff
 * @property-read int|null $checked_seriff_count
 * @property-read Game $game
 * @property-read Collection|GameNight[] $killed
 * @property-read int|null $killed_count
 * @property-read Player $player
 * @property-read Collection|GameVoting[] $nominated
 * @property-read int|null $nominated_count
 * @property-read Collection|GameVoting[] $nominates
 * @property-read int|null $nominates_count
 * @method static GamePlayerFactory factory(...$parameters)
 * @method static Builder|GamePlayer newModelQuery()
 * @method static Builder|GamePlayer newQuery()
 * @method static Builder|GamePlayer query()
 * @method static Builder|GamePlayer whereCreatedAt($value)
 * @method static Builder|GamePlayer whereFouls($value)
 * @method static Builder|GamePlayer whereGameId($value)
 * @method static Builder|GamePlayer whereHelperId($value)
 * @method static Builder|GamePlayer whereId($value)
 * @method static Builder|GamePlayer whereIngamePlayerId($value)
 * @method static Builder|GamePlayer whereIsRemoved($value)
 * @method static Builder|GamePlayer wherePlayerId($value)
 * @method static Builder|GamePlayer whereRole($value)
 * @method static Builder|GamePlayer whereScore($value)
 * @method static Builder|GamePlayer whereUpdatedAt($value)
 * @mixin Eloquent
 */
class GamePlayer extends Model
{
    use HasFactory;

    const ROLES_TEAMS = [
        'red' => 'red_win',
        'sheriff' => 'red_win',
        'black' => 'black_win',
        'don' => 'black_win',
    ];

    const ROLES = ['red', 'black', 'sheriff', 'don'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'games__players';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }

    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id');
    }


    public function nominates()
    {
        return $this->hasMany('\App\Models\GameVoting', 'nominator_id');
    }

    public function nominated()
    {
        return $this->hasMany('\App\Models\GameVoting', 'game_player_id');
    }

    public function killed()
    {
        return $this->hasMany('\App\Models\GameNight', 'killed_id');
    }

    public function checked_don()
    {
        return $this->hasMany('\App\Models\GameNight', 'checked_don_id');
    }

    public function checked_seriff()
    {
        return $this->hasMany('\App\Models\GameNight', 'checked_sheriff_id');
    }

    public function isWinner()
    {
        return $this->game->result == self::ROLES_TEAMS[$this->role];
    }
}
