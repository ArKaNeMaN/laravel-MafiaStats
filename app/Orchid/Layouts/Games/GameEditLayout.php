<?php

namespace App\Orchid\Layouts\Games;

use App\Http\Requests\GameRequest;
use App\Models\Game;
use App\Models\Player;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Facades\Toast;

class GameEditLayout extends Rows
{
    protected function fields(): array
    {
        return [
            DateTimer::make('game.date')
                ->required(),

            Relation::make('game.leader_id')
                ->fromModel(Player::class, 'nickname')
                ->required(),

            Relation::make('game.best_red_id')
                ->fromModel(Player::class, 'nickname'),

            Relation::make('game.best_red_id')
                ->fromModel(Player::class, 'nickname'),

            Select::make('game.result')
                ->options(Game::RESULT_TITLES),
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
