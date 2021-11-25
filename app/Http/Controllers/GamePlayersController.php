<?php

namespace App\Http\Controllers;

use App\Http\Requests\GamePlayerRequest;
use App\Http\Requests\PlayerRequest;
use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\Player;

class GamePlayersController extends Controller
{
    public function list(Game $game){
        return $game->gamePlayers()
            ->latest();
    }

    public function get(GamePlayer $pl){
        return $pl;
    }

    public function create(GamePlayerRequest $req, Game $game){
        return $game
            ->gamePlayers()
            ->create($req->getData());
    }

    public function update(GamePlayerRequest $req, GamePlayer $pl){
        $pl->updateOrFail($req->getData());
        return $pl;
    }

    public function delete(GamePlayer $pl){
        $pl->deleteOrFail();
        return null;
    }
}
