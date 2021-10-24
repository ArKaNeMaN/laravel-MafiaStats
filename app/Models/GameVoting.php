<?php

namespace App\Models;

use Database\Factories\GameVotingFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\GameVoting
 *
 * @property int $id
 * @property int $game_id
 * @property int $ingame_id
 * @property int $votes_for_both
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Game $game
 * @property-read Collection|GameVotingPlayer[] $nominated
 * @property-read int|null $nominated_count
 * @property-read Collection|GameVotingVote[] $voters
 * @property-read int|null $voters_count
 * @method static GameVotingFactory factory(...$parameters)
 * @method static Builder|GameVoting newModelQuery()
 * @method static Builder|GameVoting newQuery()
 * @method static Builder|GameVoting query()
 * @method static Builder|GameVoting whereCreatedAt($value)
 * @method static Builder|GameVoting whereGameId($value)
 * @method static Builder|GameVoting whereId($value)
 * @method static Builder|GameVoting whereIngameId($value)
 * @method static Builder|GameVoting whereUpdatedAt($value)
 * @method static Builder|GameVoting whereVotesForBoth($value)
 * @mixin Eloquent
 */
class GameVoting extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'games__votings';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function game()
    {
        return $this->belongsTo('App\Models\Game', 'game_id');
    }

    public function nominated()
    {
        return $this->hasMany('App\Models\GameVotingPlayer', 'vote_id');
    }

    public function voters()
    {
        return $this->hasMany('App\Models\GameVotingVote', 'vote_id');
    }

    public function getKicked()
    {
        return $this->nominated()
            ->where('is_kicked', true)
            ->get();
    }
}
