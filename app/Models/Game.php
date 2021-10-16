<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    const RESULTS = ['black_win', 'red_win'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'games';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function tournament()
    {
        return $this->belongsTo(\App\Models\Tournament::class, 'tournament_id');
    }

    public function leader()
    {
        return $this->belongsTo(\App\Models\Player::class, 'leader_id');
    }

    public function players()
    {
        return $this->hasMany(\App\Models\GamePlayer::class, 'game_id');
    }

    public function nights()
    {
        return $this->hasMany(\App\Models\GameNight::class, 'game_id');
    }

    public function votings()
    {
        return $this->hasMany(\App\Models\GameVoting::class, 'game_id');
    }

    public function bestRed()
    {
        return $this->belongsTo(\App\Models\Player::class, 'best_red_id');
    }

    public function bestBlack()
    {
        return $this->belongsTo(\App\Models\Player::class, 'best_black_id');
    }

    public function getFDateAttribute(){
        return date('d.m.Y', strtotime($this->date_time));
    }

    public function getFTimeAttribute(){
        return date('H:i', strtotime($this->date_time));
    }

    public function getFDateTimeAttribute(){
        return date('d.m.Y - H:i', strtotime($this->date_time));
    }
}
