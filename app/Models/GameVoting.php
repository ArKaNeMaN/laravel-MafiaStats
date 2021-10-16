<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->players()->where('is_kicked', true)->get();
    }
}
