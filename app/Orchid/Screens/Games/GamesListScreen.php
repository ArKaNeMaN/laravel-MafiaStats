<?php

namespace App\Orchid\Screens\Games;

use App\Models\Game;
use App\Orchid\Layouts\Games\GamesTableLayout;
use Orchid\Screen\Screen;

class GamesListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Список игр';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'games' => Game::all(),
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            GamesTableLayout::class,
        ];
    }
}
