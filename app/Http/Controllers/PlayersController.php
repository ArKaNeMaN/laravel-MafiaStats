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
        return $pl->games()
            ->forList()
            ->get();
    }

    public function getGPlayers(PaginationRequest $req, Player $pl){
        $q = $pl->gamesPlayers();

        if($req->has('withGames'))
            $q->with('game');

        return $req->doPaginate($q);
    }

    public function create(PlayerRequest $req){
        return Player::create($req->getData());
    }

    public function update(PlayerRequest $req, Player $pl){
        $pl->updateOrFail($req->getData());
        return $pl;
    }

    public function delete(Player $pl){
        $pl->deleteOrFail();
        return null;
    }
}
