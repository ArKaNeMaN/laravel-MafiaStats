<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class PlatformScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Панель управления системой учёта для спортивной мафии';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Добро пожаловать в панель управления Mafia Stats.';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('GitHub')
                ->href('https://github.com/ArKaNeMaN/laravel-MafiaStats')
                ->icon('social-github')
                ->target('_BLANK'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::view('admin.welcome'),
        ];
    }
}
