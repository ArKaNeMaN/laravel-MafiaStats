<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use App\Http\Requests\PaginationRequest;
use App\Models\Game;

class GamesController extends Controller
{
    public function list(PaginationRequest $req){
        return $req->doPaginate(
            Game::query()
                ->forList()
                ->latest()
        );
    }

    public function get(Game $g){
        return $g;
    }

    public function getGPlayers(PaginationRequest $req, Game $g){
        $q = $g->players();

        if($req->has('withPlayers'))
            $q->with('player');

        return $req->doPaginate($q);
    }

    public function create(GameRequest $req){
        return Game::create($req->getData());
    }

    public function update(GameRequest $req, Game $g){
        $g->updateOrFail($req->getData());
        return $g;
    }

    public function delete(Game $g){
        $g->deleteOrFail();
        return null;
    }
}
