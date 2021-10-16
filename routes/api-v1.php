<?php

use App\Http\Controllers\GamesController;
use App\Http\Controllers\PlayersController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $req) {
    return [
        'app_name' => config('app.name'),
        'api_version' => 1,
    ];
});

// ТОЛЬКО ДЛЯ ТЕСТОВ.
// НАДО БУДЕТ УДАЛИТЬ ПОТОМ)))
Route::get('/test', function (Request $req) {
    return response()->json(
        User::query()
        ->where('role', 'admin')
        ->first()
        ->api_token
    );
});

Route::any('/players/search', [PlayersController::class, 'search']);
Route::get('/players', [PlayersController::class, 'list']);
Route::get('/player/{player}', [PlayersController::class, 'get']);
Route::get('/player/{player}/games', [PlayersController::class, 'getGames']);
Route::get('/player/{player}/gPlayers', [PlayersController::class, 'getGPlayers']);

Route::get('/games', [GamesController::class, 'list']);
Route::get('/game/{game}', [GamesController::class, 'get']);
Route::get('/game/{game}/players', [GamesController::class, 'getGPlayers']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/player', [PlayersController::class, 'create']);
    Route::put('/player/{player}', [PlayersController::class, 'update']);
    Route::delete('/player/{player}', [PlayersController::class, 'delete']);
});
