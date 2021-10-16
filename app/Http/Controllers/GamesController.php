<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginationRequest;
use App\Models\Game;

class GamesController extends Controller
{
    public function list(PaginationRequest $req){
        return $req->doPaginate(
            Game::query()
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
}
