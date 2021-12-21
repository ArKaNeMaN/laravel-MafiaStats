<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        return [

            // Мафия

            Menu::make('Игроки')
                ->icon('user')
                ->route('app.mafia.players.list')
                ->permission('app.mafia.players')
                ->title('Мафия'),

            Menu::make('Игры')
                ->icon('game-controller')
                ->route('app.mafia.games.list')
                ->permission('app.mafia.games'),

            Menu::make('Турниры')
                ->icon('game-controller')
                ->route('app.mafia.tournaments.list')
                ->permission('app.mafia.tournaments'),

            // Системные

            Menu::make('Пользователи')
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title('Распределение доступа'),

            Menu::make('Роли')
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),
        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make('Профиль')
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group('Система')
                ->addPermission('platform.systems.roles', 'Роли')
                ->addPermission('platform.systems.users', 'Пользователи'),

            ItemPermission::group('Мафия')
                ->addPermission('app.mafia.players', 'Управление игроками')
                ->addPermission('app.mafia.games', 'Управление играми')
                ->addPermission('app.mafia.games.delete', 'Удаление игр')
                ->addPermission('app.mafia.tournaments', 'Управление турнирами'),
        ];
    }
}
