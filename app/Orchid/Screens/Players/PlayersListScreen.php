<?php

namespace App\Orchid\Screens\Players;

use App\Models\Player;
use App\Orchid\Layouts\Players\PlayersTableLayout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;

class PlayersListScreen extends Screen
{
    public $name = 'Список игроков';

    public function query(): array
    {
        return [
            'players' => Player::filters()
                ->defaultSort('id', 'desc')
                ->paginate(),
        ];
    }

    public function commandBar(): array
    {
        return [
            Button::make('Создать')
                ->action(route('app.mafia.players.create'))
                ->icon('plus'),
        ];
    }

    public function layout(): array
    {
        return [
            PlayersTableLayout::class,
        ];
    }
}
