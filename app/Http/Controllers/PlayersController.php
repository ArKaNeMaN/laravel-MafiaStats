<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginationRequest;
use App\Http\Requests\PlayerRequest;
use App\Http\Requests\SearchRequest;
use App\Models\Player;

class PlayersController extends Controller
{
    public function list(PaginationRequest $req){
        return $req->doPaginate(
            Player::query()->latest()
        );
    }

    public function search(SearchRequest $req){
        return $req->doPaginatedSearch(
            Player::query()->latest(),
            [
                'name' => [
                    'oper' => 'LIKE',
                    'attrs' => ['name'],
                ],
                'nickname' => [
                    'oper' => 'LIKE',
                    'attrs' => ['nickname'],
                ],
                's' => [
                    'oper' => 'LIKE',
                    'attrs' => ['name', 'nickname'],
                ],
            ]
        );
    }

    public function get(Player $pl){
        return $pl;
    }

    public function getGames(Player $pl){
        return $pl->games;
    }

    public function getGPlayers(PaginationRequest $req, Player $pl){
        $q = $pl->gamesPlayers();

        if($req->has('withGames'))
            $q->with('game');

        return $req->doPaginate($q);
    }

    public function create(PlayerRequest $req){
        $this->middleware('auth:api');
        $this->middleware('role:admin');

        $pl = new Player($req->getData());
        $pl->save();

        return $pl;
    }

    public function update(PlayerRequest $req, Player $pl){
        $this->middleware('auth:api');
        $this->middleware('role:admin');

        $pl->fill($req->getData())->save();

        return $pl;
    }

    public function delete(Player $pl){
        $this->middleware('auth:api');
        $this->middleware('role:admin');

        $pl->deleteOrFail();

        return null;
    }
}
