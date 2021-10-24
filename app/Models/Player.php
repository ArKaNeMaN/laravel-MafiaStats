<?php

namespace App\Models;

use Database\Factories\PlayerFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Orchid\Filters\Filterable;
use Orchid\Filters\HttpFilter;
use Orchid\Screen\AsSource;


/**
 * App\Models\Player
 *
 * @property int $id
 * @property string $nickname
 * @property string $name
 * @property Carbon|null $birthday
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|GamePlayer[] $gamesPlayers
 * @property-read int|null $games_players_count
 * @property-read array $games
 * @method static Builder|Player defaultSort(string $column, string $direction = 'asc')
 * @method static PlayerFactory factory(...$parameters)
 * @method static Builder|Player filters(?HttpFilter $httpFilter = null)
 * @method static Builder|Player filtersApply(array $filters = [])
 * @method static Builder|Player filtersApplySelection($selection)
 * @method static Builder|Player newModelQuery()
 * @method static Builder|Player newQuery()
 * @method static Builder|Player query()
 * @method static Builder|Player whereBirthday($value)
 * @method static Builder|Player whereCreatedAt($value)
 * @method static Builder|Player whereId($value)
 * @method static Builder|Player whereName($value)
 * @method static Builder|Player whereNickname($value)
 * @method static Builder|Player whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Player extends Model
{
    use HasFactory;

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
