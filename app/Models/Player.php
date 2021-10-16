<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $table = 'players';

    protected $fillable = [
        'name',
        'nickname',
        'birthday',
    ];

    public function getLatestGame()
    {
        return $this->gamesPlayers()->latest()->first()->game()->first();
    }

    public function gamesPlayers()
    {
        return $this->hasMany(GamePlayer::class, 'player_id');
    }

    public function games()
    {
        $gamesPlayers = $this->gamesPlayers()->get();
        $games = [];
        foreach($gamesPlayers as $v)
            $games[] = $v->game()->first();
        return $games;
    }

    public function getGamesAttribute(): array
    {
        return $this->games();
    }
}
