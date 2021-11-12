<?php

namespace App\Orchid\Tournaments\Layouts;

use App\Models\Tournament;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class TournamentsTableLayout extends Table
{

    protected $target = 'tournaments';

    /**
     * @inheritDoc
     */
    protected function columns(): array
    {
        return [
            TD::make('id', '№')
                ->sort()
                ->filter(TD::FILTER_NUMERIC)
                ->cantHide(),

            TD::make('name', 'Название')
                ->filter(TD::FILTER_TEXT)
                ->cantHide(),

            TD::make('games_count', 'Кол-во игр')
                ->render(fn(Tournament $tour) => $tour->games->count()),
        ];
    }
}
