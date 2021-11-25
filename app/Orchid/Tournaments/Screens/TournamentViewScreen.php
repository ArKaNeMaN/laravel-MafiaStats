<?php

namespace App\Orchid\Tournaments\Screens;

use App\Models\Tournament;
use App\Orchid\Tournaments\Layouts\TournamentGamesTable;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;

class TournamentViewScreen extends Screen
{
    protected Tournament $tour;

    public function query(Tournament $tour){
        $this->tour = $tour;

        return [
            'tournament' => $tour,
            'tournament.games' => $tour->games()
                ->forList()
                ->get(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function layout(): array
    {
        return [
            Layout::legend('tournament', [
                Sight::make('id', 'Уникальный индекс'),
                Sight::make('name', 'Название'),
                Sight::make('description', 'Описание'),
            ]),

            TournamentGamesTable::class,
        ];
    }

    public function commandBar(): array
    {
        return [
            Link::make('Редактировать')
                ->icon('pencil')
                ->href(route('app.mafia.tournaments.edit', $this->tour)),

            Button::make('Удалить')
                ->icon('trash')
                ->confirm('Вы действительно хотите удалить это турнир?')
                ->action(route('app.mafia.tournaments.edit', [$this->tour, 'delete'])),
        ];
    }
}
