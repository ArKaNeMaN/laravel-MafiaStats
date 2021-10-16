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
                ->addPermission('app.mafia.games.create', 'Создание игр')
                ->addPermission('app.mafia.games.master', 'Ведение игр'),
        ];
    }
}