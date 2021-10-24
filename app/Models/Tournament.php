<?php

namespace App\Models;

use Database\Factories\TournamentFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Tournament
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Game[] $games
 * @property-read int|null $games_count
 * @method static TournamentFactory factory(...$parameters)
 * @method static Builder|Tournament newModelQuery()
 * @method static Builder|Tournament newQuery()
 * @method static Builder|Tournament query()
 * @method static Builder|Tournament whereCreatedAt($value)
 * @method static Builder|Tournament whereDescription($value)
 * @method static Builder|Tournament whereId($value)
 * @method static Builder|Tournament whereName($value)
 * @method static Builder|Tournament whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Tournament extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tournaments';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function games()
    {
        return $this->hasMany(Game::class, 'tournament_id');
    }
}
