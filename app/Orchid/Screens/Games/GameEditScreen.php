<?php

namespace App\Orchid\Screens\Games;

use App\Models\Game;
use App\Orchid\Layouts\Games\GameEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;

class GameEditScreen extends Screen
{
    public $permission = 'app.mafia.players';

    protected Game $game;

    public function query(Game $g, Request $req)
    {
        $this->game = $g;
        $this->name = $this->game->exists
            ? 'Создание игры'
            : 'Редактирование игры ';

        return ['game' => $this->game];
    }

    public function commandBar(): array
    {
        return $this->game->exists ? [
            Button::make('Сохранить')
                ->icon('check')
                ->method('save'),
            Button::make('Удалить')
                ->icon('trash')
                ->method('delete'),
        ] : [
            Button::make('Создать')
                ->icon('plus')
                ->method('create'),
        ];
    }

    public function layout(): array
    {
        return [
            GameEditLayout::class,
        ];
    }
}
