<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo('App\Models\GameVote', 'voting_id');
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
