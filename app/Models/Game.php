<?php

namespace App\Models;

use Database\Factories\GameFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Game
 *
 * @property int $id
 * @property int|null $tournament_id
 * @property int $leader_id
 * @property int|null $best_red_id
 * @property int|null $best_black_id
 * @property string $result
 * @property string $date_time
 * @property int $played
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Player|null $bestBlack
 * @property-read Player|null $bestRed
 * @property-read mixed $f_date
 * @property-read mixed $f_date_time
 * @property-read mixed $f_time
 * @property-read Player $leader
 * @property-read Collection|GameNight[] $nights
 * @property-read int|null $nights_count
 * @property-read Collection|GamePlayer[] $players
 * @property-read int|null $players_count
 * @property-read Tournament|null $tournament
 * @property-read Collection|GameVoting[] $votings
 * @property-read int|null $votings_count
 * @method static GameFactory factory(...$parameters)
 * @method static Builder|Game newModelQuery()
 * @method static Builder|Game newQuery()
 * @method static Builder|Game query()
 * @method static Builder|Game whereBestBlackId($value)
 * @method static Builder|Game whereBestRedId($value)
 * @method static Builder|Game whereCreatedAt($value)
 * @method static Builder|Game whereDateTime($value)
 * @method static Builder|Game whereDescription($value)
 * @method static Builder|Game whereId($value)
 * @method static Builder|Game whereLeaderId($value)
 * @method static Builder|Game wherePlayed($value)
 * @method static Builder|Game whereResult($value)
 * @method static Builder|Game whereTournamentId($value)
 * @method static Builder|Game whereUpdatedAt($value)
 * @mixin Eloquent
 */
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
        return $this->belongsTo(Tournament::class, 'tournament_id');
    }

    public function leader()
    {
        return $this->belongsTo(Player::class, 'leader_id');
    }

    public function players()
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
