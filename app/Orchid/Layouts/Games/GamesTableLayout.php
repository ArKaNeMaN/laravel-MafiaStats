<?php

namespace App\Orchid\Layouts\Games;

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
            TD::make('id', '№'),

            TD::make('date', 'Дата')
                ->sort()
                ->filter(TD::FILTER_DATE)
                ->render(function(Game $game) {
                    return $game->date->toFormattedDateString();
                }),

            TD::make('leader', 'Ведущий')
                ->render(function(Game $game) {
                    return $game->leader->nickname;
                }),

            TD::make('tournament', 'Турнир')
                ->render(function(Game $game) {
                    return $game->tournament?->title ?? '-';
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
