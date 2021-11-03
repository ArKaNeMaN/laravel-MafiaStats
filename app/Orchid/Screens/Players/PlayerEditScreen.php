<?php

namespace App\Orchid\Screens\Players;

use App\Http\Requests\PlayerRequest;
use App\Models\Player;
use App\Orchid\Layouts\Players\PlayerEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class PlayerEditScreen extends Screen
{
    public $permission = 'app.mafia.players';

    protected Player $player;

    public function query(Player $player, Request $req)
    {
        $this->player = $player;
        $this->name = $this->player->exists
            ? 'Создание игрока'
            : 'Редактирование игрока ' . $this->player->name;

        return ['player' => $player];
    }

    public function commandBar(): array
    {
        return $this->player->exists ? [
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
            PlayerEditLayout::class,
        ];
    }

    public function create(PlayerRequest $req){
        $player = Player::create($req->getData());

        Toast::success("Игрок '{$player->nickname}' создан.");

        return redirect()->route('app.mafia.players.edit', $player);
    }

    public function save(Player $player, PlayerRequest $req){
        $player
            ->fill($req->getData())
            ->save();

        Toast::info("Игрок '{$player->nickname}' изменён.");

        return back();
    }

    public function delete(Player $player){
        $name = $player->nickname;
        $player->delete();

        Toast::info("Игрок '{$name}' удалён.");

        return redirect()->route('app.mafia.players');
    }
}
