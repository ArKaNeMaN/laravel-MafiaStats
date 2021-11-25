<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginationRequest;
use App\Http\Requests\TourRequest;
use App\Models\Tournament;

class ToursController extends Controller
{
    public function list(PaginationRequest $req){
        return $req->doPaginate(
            Tournament::query()
                ->latest()
        );
    }

    public function get(Tournament $tour){
        return $tour;
    }

    public function getGames(PaginationRequest $req, Tournament $tour){
        $q = $tour->games();

        if($req->has('withPlayers'))
            $q->with('players');

        return $req->doPaginate($q);
    }

    public function create(TourRequest $req){
        return Tournament::create($req->getData());
    }

    public function update(TourRequest $req, Tournament $tour){
        $tour->updateOrFail($req->getData());
        return $tour;
    }

    public function delete(Tournament $tour){
        $tour->deleteOrFail();
        return null;
    }
}
