<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\GameVotingVote
 *
 * @property int $id
 * @property int $voting_id
 * @property int $game_player_id
 * @property int $voted_id
 * @property int $for_accident
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read GamePlayer $player
 * @property-read GameVotingPlayer $voted
 * @property-read GameVoting $voting
 * @method static Builder|GameVotingVote newModelQuery()
 * @method static Builder|GameVotingVote newQuery()
 * @method static Builder|GameVotingVote query()
 * @method static Builder|GameVotingVote whereCreatedAt($value)
 * @method static Builder|GameVotingVote whereForAccident($value)
 * @method static Builder|GameVotingVote whereGamePlayerId($value)
 * @method static Builder|GameVotingVote whereId($value)
 * @method static Builder|GameVotingVote whereUpdatedAt($value)
 * @method static Builder|GameVotingVote whereVotedId($value)
 * @method static Builder|GameVotingVote whereVotingId($value)
 * @mixin Eloquent
 */
class GameVotingVote extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'games__votings__votes';

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

    public function voted()
    {
        return $this->belongsTo('App\Models\GameVotingPlayer', 'voted_id');
    }
}
