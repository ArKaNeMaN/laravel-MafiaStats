<?php

namespace App\Orchid\Tournaments\Screens;

use App\Models\Tournament;
use App\Orchid\Tournaments\Layouts\TournamentsTableLayout;
use Orchid\Screen\Screen;

class TournamentsListScreen extends Screen
{

    public function query(){
        return [
            'tournaments' => Tournament::query()
                ->defaultSort('id', 'desc')
                ->filters()
                ->with('games')
                ->paginate(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function layout(): array
    {
        return [
            TournamentsTableLayout::class,
        ];
    }
}
