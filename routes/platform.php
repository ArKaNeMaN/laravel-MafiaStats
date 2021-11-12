<?php

declare(strict_types=1);

use App\Models\Game;
use App\Models\Player;
use App\Models\Tournament;
use App\Orchid\Games\Screens\GameEditScreen;
use App\Orchid\Games\Screens\GamesListScreen;
use App\Orchid\Games\Screens\GameViewScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Players\Screens\PlayerEditScreen;
use App\Orchid\Players\Screens\PlayersListScreen;
use App\Orchid\Players\Screens\PlayerViewScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use App\Orchid\Tournaments\Screens\TournamentsListScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->push('Главная', route('platform.main'));
    });

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.main')
            ->push('Профиль', route('platform.profile'));
    });

// Platform > System > Users
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.systems.users')
            ->push('Пользователь', route('platform.systems.users.edit', $user));
    });

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.users')
            ->push('Создание', route('platform.systems.users.create'));
    });

// Platform > System > Users > User
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.main')
            ->push('Пользователи', route('platform.systems.users'));
    });

// Platform > System > Roles > Role
Route::screen('roles/{roles}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(function (Trail $trail, $role) {
        return $trail
            ->parent('platform.systems.roles')
            ->push('Роль', route('platform.systems.roles.edit', $role));
    });

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.roles')
            ->push('Создание', route('platform.systems.roles.create'));
    });

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.main')
            ->push('Роли', route('platform.systems.roles'));
    });

// Mafia

Route::group(['prefix' => 'mafia', 'as' => 'app.mafia.'], function () {

    // Players
    Route::group(['prefix' => 'players', 'as' => 'players.'], function () {
        Route::screen('{player}/edit', PlayerEditScreen::class)
            ->name('edit')
            ->breadcrumbs(function (Trail $trail, Player $player) {
                return $trail
                    ->parent('app.mafia.players.view', $player)
                    ->push('Редактирование', route('app.mafia.players.edit', $player));
            });

        Route::screen('{player}', PlayerViewScreen::class)
            ->name('view')
            ->breadcrumbs(function (Trail $trail, Player $player) {
                return $trail
                    ->parent('app.mafia.players.list')
                    ->push($player->nickname, route('app.mafia.players.view', $player));
            });

        Route::screen('create', PlayerEditScreen::class)
            ->name('create')
            ->breadcrumbs(function (Trail $trail) {
                return $trail
                    ->parent('app.mafia.players.list')
                    ->push('Создание', route('app.mafia.players.create'));
            });

        Route::screen('/', PlayersListScreen::class)
            ->name('list')
            ->breadcrumbs(function (Trail $trail) {
                return $trail
                    ->parent('platform.main')
                    ->push('Игроки', route('app.mafia.players.list'));
            });
    });

    // Games
    Route::group(['prefix' => 'games', 'as' => 'games.'], function () {
        Route::screen('{game}/edit', GameEditScreen::class)
            ->name('edit')
            ->breadcrumbs(function (Trail $trail, Game $game) {
                return $trail
                    ->parent('app.mafia.games.view', $game)
                    ->push("Редактирование", route('app.mafia.games.edit', $game));
            });

        Route::screen('{game}', GameViewScreen::class)
            ->name('view')
            ->breadcrumbs(function (Trail $trail, Game $game) {
                return $trail
                    ->parent('app.mafia.games.list')
                    ->push("#$game->id", route('app.mafia.games.view', $game));
            });

        Route::screen('create', GameEditScreen::class)
            ->name('create')
            ->breadcrumbs(function (Trail $trail) {
                return $trail
                    ->parent('app.mafia.games.list')
                    ->push("Создание", route('app.mafia.games.create'));
            });

        Route::screen('/', GamesListScreen::class)
            ->name('list')
            ->breadcrumbs(function (Trail $trail) {
                return $trail
                    ->parent('platform.main')
                    ->push('Игры', route('app.mafia.games.list'));
            });
    });

    // Tournaments
    Route::group(['prefix' => 'tournaments', 'as' => 'tournaments.'], function () {
//        Route::screen('{tournament}/edit', GameEditScreen::class)
//            ->name('edit')
//            ->breadcrumbs(function (Trail $trail, Tournament $tour) {
//                return $trail
//                    ->parent('app.mafia.tournaments.view', $tour)
//                    ->push("Редактирование", route('app.mafia.tournaments.edit', $tour));
//            });

//        Route::screen('{tournament}', GameViewScreen::class)
//            ->name('view')
//            ->breadcrumbs(function (Trail $trail, Tournament $tour) {
//                return $trail
//                    ->parent('app.mafia.tournaments.list')
//                    ->push("#$tour->id", route('app.mafia.tournaments.view', $tour));
//            });

//        Route::screen('create', GameEditScreen::class)
//            ->name('create')
//            ->breadcrumbs(function (Trail $trail) {
//                return $trail
//                    ->parent('app.mafia.tournaments.list')
//                    ->push("Создание", route('app.mafia.tournaments.create'));
//            });

        Route::screen('/', TournamentsListScreen::class)
            ->name('list')
            ->breadcrumbs(function (Trail $trail) {
                return $trail
                    ->parent('platform.main')
                    ->push('Турниры', route('app.mafia.tournaments.list'));
            });
    });
});
