<?php

namespace App\Orchid\Games\Screens;

use App\Http\Requests\GameRequest;
use App\Models\Game;
use App\Orchid\Games\Layouts\GameEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class GameEditScreen extends Screen
{
    public $permission = 'app.mafia.games';

    protected Game $game;

    public function query(Game $g, Request $req)
    {
        $this->game = $g;
        $this->name = $this->game->exists
            ? "Редактирование игры #{$this->game->id}"
            : 'Создание игры';

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

    public function create(GameRequest $req){
        $g = Game::create($req->getData());

        Toast::success("Игра создана.");

        return redirect()->route('app.mafia.games.edit', $g);
    }

    public function save(Game $g, GameRequest $req){
        $g->updateOrFail($req->getData());

        Toast::info("Игра изменена.");

        return back();
    }

    public function delete(Game $g){
        $g->deleteOrFail();

        Toast::info("Игра удалена.");

        return redirect()->route('app.mafia.games.list');
    }
}
