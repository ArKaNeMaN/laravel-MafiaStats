<?php

namespace App\Models;

use Database\Factories\GameNightFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\GameNight
 *
 * @property int $id
 * @property int $game_id
 * @property int $ingame_id
 * @property int|null $killed_id
 * @property int|null $checked_don_id
 * @property int|null $checked_sheriff_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read GamePlayer|null $checkedDon
 * @property-read GamePlayer|null $checkedSheriff
 * @property-read Game $game
 * @property-read GamePlayer|null $killed
 * @method static GameNightFactory factory(...$parameters)
 * @method static Builder|GameNight newModelQuery()
 * @method static Builder|GameNight newQuery()
 * @method static Builder|GameNight query()
 * @method static Builder|GameNight whereCheckedDonId($value)
 * @method static Builder|GameNight whereCheckedSheriffId($value)
 * @method static Builder|GameNight whereCreatedAt($value)
 * @method static Builder|GameNight whereGameId($value)
 * @method static Builder|GameNight whereId($value)
 * @method static Builder|GameNight whereIngameId($value)
 * @method static Builder|GameNight whereKilledId($value)
 * @method static Builder|GameNight whereUpdatedAt($value)
 * @mixin Eloquent
 */
class GameNight extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'games__nights';

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

    public function killed()
    {
        return $this->belongsTo('App\Models\GamePlayer', 'killed_id');
    }

    public function checkedDon()
    {
        return $this->belongsTo('App\Models\GamePlayer', 'checked_don_id');
    }

    public function checkedSheriff()
    {
        return $this->belongsTo('App\Models\GamePlayer', 'checked_sheriff_id');
    }
}
