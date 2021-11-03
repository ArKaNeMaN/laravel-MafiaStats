<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Player extends Model
{
    use HasFactory, Filterable, AsSource;

    /**
     * @var string
     */
    protected $table = 'players';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'nickname',
        'birthday',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * @var array
     */
    protected array $allowedFilters = [
        'id',
        'name',
        'nickname',
        'birthday',
        'created_at',
    ];

    /**
     * @var array
     */
    protected array $allowedSorts = [
        'id',
        'name',
        'nickname',
        'birthday',
        'created_at',
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
        return $this->belongsToMany(
            Game::class, GamePlayer::class,
            'player_id', 'game_id'
        );
    }

    public function leadingGames(){
        return $this->hasMany(Game::class, 'leader_id');
    }
}
