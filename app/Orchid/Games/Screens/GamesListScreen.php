<?php

namespace App\Orchid\Games\Screens;

use App\Models\Game;
use App\Orchid\Games\Layouts\GamesTableLayout;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
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
            'games' => Game::query()
                ->forList()
                ->defaultSort('id', 'desc')
                ->filters()
                ->paginate(),
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Создать')
                ->action(route('app.mafia.games.create'))
                ->icon('plus'),
        ];
    }

    /**
     * Views.
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            GamesTableLayout::class,
        ];
    }
}
