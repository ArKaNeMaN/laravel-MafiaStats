<?php

namespace App\Orchid\Players\Layouts;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class PlayerEditLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        return [
            Input::make('player.name')
                ->title('Имя игрока')
                ->required(),

            Input::make('player.nickname')
                ->title('Псевдоним игрока')
                ->required(),

            Input::make('player.birthday')
                ->type('date')
                ->title('День рождения игрока')
                ->required(),
        ];
    }
}
