<?php

declare(strict_types=1);

use App\Models\Game;
use App\Models\Player;
use App\Orchid\Screens\Games\GamesListScreen;
use App\Orchid\Screens\Games\GameViewScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Players\PlayerEditScreen;
use App\Orchid\Screens\Players\PlayersListScreen;
use App\Orchid\Screens\Players\PlayerViewScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

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

Route::group(['prefix' => 'mafia'], function() {

    // Players
    Route::screen('players/{player}/edit', PlayerEditScreen::class)
        ->name('app.mafia.players.edit')
        ->breadcrumbs(function (Trail $trail, Player $player) {
            return $trail
                ->parent('app.mafia.players.view', $player)
                ->push('Редактирование', route('app.mafia.players.edit', $player));
        });

    Route::screen('players/{player}', PlayerViewScreen::class)
        ->name('app.mafia.players.view')
        ->breadcrumbs(function (Trail $trail, Player $player) {
            return $trail
                ->parent('app.mafia.players')
                ->push($player->nickname, route('app.mafia.players.view', $player));
        });

    Route::screen('players/create', PlayerEditScreen::class)
        ->name('app.mafia.players.create')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('app.mafia.players')
                ->push('Создание', route('app.mafia.players.create'));
        });

    Route::screen('players', PlayersListScreen::class)
        ->name('app.mafia.players')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.main')
                ->push('Игроки', route('app.mafia.players'));
        });

    // Games

    Route::screen('games/{game}/edit', GameViewScreen::class)
        ->name('app.mafia.games.edit')
        ->breadcrumbs(function (Trail $trail, Game $game) {
            return $trail
                ->parent('app.mafia.games.view', $game)
                ->push("Редактирование", route('app.mafia.games.edit', $game));
        });

    Route::screen('games/{game}', GameViewScreen::class)
        ->name('app.mafia.games.view')
        ->breadcrumbs(function (Trail $trail, Game $game) {
            return $trail
                ->parent('app.mafia.games')
                ->push("#{$game->id}", route('app.mafia.games.view', $game));
        });

    Route::screen('games', GamesListScreen::class)
        ->name('app.mafia.games')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.main')
                ->push('Игры', route('app.mafia.games'));
        });
});
