<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
