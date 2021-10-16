<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo(\App\Models\Game::class, 'game_id');
    }

    public function player()
    {
        return $this->belongsTo(\App\Models\Player::class, 'player_id');
    }


    public function nominates()
    {
        return $this->hasMany('\App\Models\GameVote', 'nominator_id');
    }

    public function nominated()
    {
        return $this->hasMany('\App\Models\GameVote', 'game_player_id');
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
        return $this->game()->result == self::ROLES_TEAMS[$this->role];
    }
}
