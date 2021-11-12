<?php

namespace App\Orchid\Players\Layouts;

use App\Models\Player;
use Illuminate\Support\Facades\Date;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PlayersTableLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'players';

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
                ->filter(TD::FILTER_NUMERIC),

            TD::make('nickname', 'Ник')
                ->sort()
                ->cantHide()
                ->filter(TD::FILTER_TEXT),

            TD::make('name', 'Имя')
                ->sort()
                ->cantHide()
                ->filter(TD::FILTER_TEXT),

            TD::make('birthday', 'День рождения')
                ->sort()
                ->filter(TD::FILTER_DATE)
                ->defaultHidden()
                ->render(function(Player $player) {
                    return Date::make($player->birthday)->toFormattedDateString();
                }),

            TD::make('_actions', 'Действия')
                ->cantHide()
                ->render(function(Player $player) {
                    return Group::make([
                        Link::make('Редактирование')
                            ->icon('pencil')
                            ->href(route('app.mafia.players.edit', $player)),

                        Link::make('Просмотр')
                            ->icon('eye')
                            ->href(route('app.mafia.players.view', $player)),
                    ]);
                }),
        ];
    }
}
