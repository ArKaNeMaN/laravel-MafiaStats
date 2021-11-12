<?php

namespace App\Orchid\Games\Layouts;

use App\Models\Game;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class GamesTableLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'games';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', '№')
                ->sort()
                ->filter(TD::FILTER_NUMERIC)
                ->cantHide(),

            TD::make('date', 'Дата')
                ->sort()
                ->filter(TD::FILTER_DATE)
                ->cantHide()
                ->render(function(Game $game) {
                    return $game->date->toFormattedDateString();
                }),

            TD::make('leader', 'Ведущий')
                ->render(function(Game $game) {
                    return is_null($game->leader)
                        ? '-'
                        : Link::make($game->leader->nickname)
                            ->icon('link')
                            ->href(route('app.mafia.players.view', $game->leader));
                }),

            TD::make('tournament', 'Турнир')
                ->render(function(Game $game) {
                    return $game->tournament?->name ?? '-';

//                    return is_null($game->tournament)
//                        ? '-'
//                        : Link::make($game->tournament->name)
//                            ->icon('link')
//                            ->href(route('app.mafia.tournaments.view', $game->tournament));
                }),

            TD::make('result', 'Результат')
                ->render(function(Game $game) {
                    return Game::RESULT_TITLES[$game->result];
                }),

            TD::make('_actions', 'Действия')
                ->cantHide()
                ->render(function(Game $game) {
                    return Group::make([
                        Link::make('Редактирование')
                            ->icon('pencil')
                            ->href(route('app.mafia.games.edit', $game)),

                        Link::make('Просмотр')
                            ->icon('eye')
                            ->href(route('app.mafia.games.view', $game)),
                    ]);
                }),
        ];
    }
}
