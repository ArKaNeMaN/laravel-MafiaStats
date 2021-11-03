<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Game extends Model
{
    use HasFactory, Filterable, AsSource;

    const RESULTS = ['black_win', 'red_win'];
    const RESULT_TITLES = [
        null => '-',
        'black_win' => 'Победа мафии',
        'red_win' => 'Победа мирных',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'games';

    /**
     * @var array
     */
    protected $fillable = [
        'date',
        'nickname',
        'birthday',
    ];

    protected $casts = [
        'date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * @var array
     */
    protected array $allowedFilters = [
        'id',
        'date',
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
        'tournament',
        'birthday',
        'created_at',
    ];

    // Scopes

    public function scopeFinished($query, bool $finished = true, string $boolean = 'and'){
        return $query->whereNull('result', $finished, $boolean);
    }

    public function scopeResult(Builder $query, string $result, string $boolean = 'and'){
        return $query->where('result', 'like', $result, $boolean);
    }

    // Relations

    public function tournament()
    {
        return $this->belongsTo(Tournament::class, 'tournament_id');
    }

    public function leader()
    {
        return $this->belongsTo(Player::class, 'leader_id');
    }

    public function players()
    {
        return $this->belongsToMany(
            Player::class, GamePlayer::class,
            'game_id', 'player_id'
        );
    }

    public function gamePlayers()
    {
        return $this->hasMany(GamePlayer::class, 'game_id');
    }

    public function nights()
    {
        return $this->hasMany(GameNight::class, 'game_id');
    }

    public function votings()
    {
        return $this->hasMany(GameVoting::class, 'game_id');
    }

    public function bestRed()
    {
        return $this->belongsTo(Player::class, 'best_red_id');
    }

    public function bestBlack()
    {
        return $this->belongsTo(Player::class, 'best_black_id');
    }
}
