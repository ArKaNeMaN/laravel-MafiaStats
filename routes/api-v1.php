<?php

use App\Http\Controllers\GamesController;
use App\Http\Controllers\PlayersController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $req) {
    return [
        'app_name' => config('app.name'),
        'debug' => config('app.debug'),
        'api_version' => 1,
    ];
});

// ТОЛЬКО ДЛЯ ТЕСТОВ.
// НАДО БУДЕТ УДАЛИТЬ ПОТОМ)))
Route::get('/test', function (Request $req) {
    return response()->json(
        User::query()
        ->where('id', '=', 1)
        ->first('api_token')
        ->api_token
    );
});

Route::group(['as' => 'players.', 'prefix' => 'players'], function() {
    Route::get('/', [PlayersController::class, 'list']);
    Route::any('search', [PlayersController::class, 'search']);
    Route::get('{player}', [PlayersController::class, 'get']);
    Route::get('{player}/games', [PlayersController::class, 'getGames']);
    Route::get('{player}/gPlayers', [PlayersController::class, 'getGPlayers']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/', [PlayersController::class, 'create']);
        Route::put('/{player}', [PlayersController::class, 'update']);
        Route::delete('/{player}', [PlayersController::class, 'delete']);
    });
});

Route::group(['as' => 'games.', 'prefix' => 'games'], function() {
    Route::get('/', [GamesController::class, 'list']);
    Route::get('/{game}', [GamesController::class, 'get']);
    Route::get('/{game}/players', [GamesController::class, 'getGPlayers']);
});

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
