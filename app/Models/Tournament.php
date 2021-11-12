<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Tournament extends Model
{
    use HasFactory, Filterable, AsSource;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tournaments';

    /**
     * @var array
     */
    protected array $allowedFilters = [
        'id',
        'name',
        'created_at',
    ];

    /**
     * @var array
     */
    protected array $allowedSorts = [
        'id',
        'created_at',
    ];

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
