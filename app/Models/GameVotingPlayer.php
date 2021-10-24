<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\GameVotingPlayer
 *
 * @property int $id
 * @property int $voting_id
 * @property int $game_player_id
 * @property int $nominator_id
 * @property int $is_accident
 * @property int $is_kicked
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read GamePlayer $nominator
 * @property-read GamePlayer $player
 * @property-read GameVoting $voting
 * @method static Builder|GameVotingPlayer newModelQuery()
 * @method static Builder|GameVotingPlayer newQuery()
 * @method static Builder|GameVotingPlayer query()
 * @method static Builder|GameVotingPlayer whereCreatedAt($value)
 * @method static Builder|GameVotingPlayer whereGamePlayerId($value)
 * @method static Builder|GameVotingPlayer whereId($value)
 * @method static Builder|GameVotingPlayer whereIsAccident($value)
 * @method static Builder|GameVotingPlayer whereIsKicked($value)
 * @method static Builder|GameVotingPlayer whereNominatorId($value)
 * @method static Builder|GameVotingPlayer whereUpdatedAt($value)
 * @method static Builder|GameVotingPlayer whereVotingId($value)
 * @mixin Eloquent
 */
class GameVotingPlayer extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'games__votings__players';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function voting()
    {
        return $this->belongsTo('App\Models\GameVoting', 'voting_id');
    }

    public function player()
    {
        return $this->belongsTo('App\Models\GamePlayer', 'game_player_id');
    }

    public function nominator()
    {
        return $this->belongsTo('App\Models\GamePlayer', 'nominator_id');
    }
}
