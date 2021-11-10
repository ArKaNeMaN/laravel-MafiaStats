<?php

namespace App\Orchid\Screens\Players;

use App\Models\Player;
use App\Orchid\Layouts\Players\PlayerGamesLayout;
use App\Orchid\Layouts\Players\PlayerLeadGamesLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;

class PlayerViewScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Игрок ***';

    protected Player|null $player = null;

    /**
     * Query data.
     *
     * @param Player $player
     * @return array
     */
    public function query(Player $player): array
    {
        $this->player = $player;
        $this->name = $this->player->nickname;

        return [
            'player' => $this->player,

            'player.games' => $this->player
                ->games()
                ->forList()
                ->get(),

            'player.leadingGames' => $this->player
                ->leadingGames()
                ->forList()
                ->get(),
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Редактировать')
                ->href(route('app.mafia.players.edit', $this->player))
                ->icon('pencil'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        /** @noinspection PhpParamsInspection */
        return [
            Layout::legend('player', [
                Sight::make('name', 'Имя'),
                Sight::make('nickname', 'Псевдоним'),
                Sight::make('birthday', 'День рождения'),
                Sight::make('games_players_count', 'Игр сыграно')
                    ->render(function(Player $player) { return (string) $player->gamesPlayers()->count(); }),
            ]),

            Layout::accordion([
                'Сыгранные игры' => PlayerGamesLayout::class,
                'Проведённые игры' => PlayerLeadGamesLayout::class,
            ]),
        ];
    }
}
