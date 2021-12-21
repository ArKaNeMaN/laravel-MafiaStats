<?php

use App\Actions\CalculatePlayerScoreForPeriodAction;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\PlayersController;
use App\Infrastructure\DateRange;
use App\Models\Player;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return [
        'app_name' => config('app.name'),
        'debug' => config('app.debug'),
        'env' => config('app.env'),
        'db_type' => env('DB_CONNECTION'),
        'api_version' => 1,
    ];
});

// ТОЛЬКО ДЛЯ ТЕСТОВ.
// НАДО БУДЕТ УДАЛИТЬ ПОТОМ)))
Route::get('/test', function () {
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

    Route::prefix('{player}')->group(function () {

        Route::get('/', [PlayersController::class, 'get']);
        Route::get('games', [PlayersController::class, 'getGames']);
        Route::get('gPlayers', [PlayersController::class, 'getGPlayers']);

        Route::get('score/{period}', function (Player $player, string $period) {
            return app(CalculatePlayerScoreForPeriodAction::class)->execute($player, DateRange::parse($period));
        });
    });

    Route::middleware(['auth:api', 'perm:app.mafia.players'])->group(function () {
        Route::post('/', [PlayersController::class, 'create']);
        Route::put('{player}', [PlayersController::class, 'update']);
        Route::delete('{player}', [PlayersController::class, 'delete']);
    });
});

Route::group(['as' => 'games.', 'prefix' => 'games'], function() {
    Route::get('/', [GamesController::class, 'list']);
    Route::get('{game}', [GamesController::class, 'get']);
    Route::get('{game}/players', [GamesController::class, 'getGPlayers']);

    Route::middleware(['auth:api', 'perm:app.mafia.games'])->group(function () {
        Route::post('/', [GamesController::class, 'create']);
        Route::put('{game}', [GamesController::class, 'update']);
    });

    Route::middleware(['auth:api', 'perm:app.mafia.games.delete'])->group(function () {
        Route::delete('{game}', [GamesController::class, 'delete']);
    });
});

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
