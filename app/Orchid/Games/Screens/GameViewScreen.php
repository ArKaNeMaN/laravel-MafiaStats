<?php

namespace App\Orchid\Games\Screens;

use App\Models\Game;
use App\Orchid\Games\Layouts\GamePlayersLayout;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;

class GameViewScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Игра ***';

    protected Game|null $game = null;

    /**
     * Query data.
     *
     * @param Game $game
     * @return array
     */
    public function query(Game $game): array
    {
        $this->game = $game;
        $this->name = "#{$this->game->id}";

        return [
            'game' => $this->game,
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
            Link::make('Редактировать')
                ->href(route('app.mafia.games.edit', $this->game))
                ->icon('pencil'),
        ];
    }

    /**
     * Views.
     *
     * @return array
     */
    public function layout(): array
    {
        /** @noinspection PhpParamsInspection */
        return [
            Layout::legend('game', [
                Sight::make('date', 'Дата проведения')
                    ->render(function(Game $game) { return $game->date->toFormattedDateString(); }),

                Sight::make('tour_nickname', 'Турнир')
                    ->render(function(Game $game) {
                        return is_null($game->tournament)
                            ? '-'
                            : Link::make($game->tournament->name)
                                ->icon('link')
                                ->href(route('app.mafia.tournaments.view', $game->tournament))
                                ->render()->render();
                    }),

                Sight::make('description', 'Описание'),

                Sight::make('leader_nickname', 'Ведущий')
                    ->render(function(Game $game) {
                        return is_null($game->leader)
                            ? '???'
                            : Link::make($game->leader->nickname)
                                ->icon('link')
                                ->href(route('app.mafia.players.view', $game->leader))
                                ->render()->render();
                    }),

                Sight::make('best_red_nickname', 'Лучший мирный игрок')
                    ->render(function(Game $game) {
                        return is_null($game->bestRed)
                            ? '-'
                            : Link::make($game->bestRed->nickname)
                                ->icon('link')
                                ->href(route('app.mafia.players.view', $game->bestRed))
                                ->render()->render();
                    }),

                Sight::make('best_black_nickname', 'Лучший игрок мафии')
                    ->render(function(Game $game) {
                        return is_null($game->bestBlack)
                            ? '-'
                            : Link::make($game->bestBlack->nickname)
                                ->icon('link')
                                ->href(route('app.mafia.players.view', $game->bestBlack))
                                ->render()->render();
                    }),

                Sight::make('players_count', 'Кол-во участников')
                    ->render(function(Game $game) { return (string) $game->players()->count(); }),
            ]),

            Layout::accordion([
                'Участники' => GamePlayersLayout::class,
            ]),
        ];
    }
}
