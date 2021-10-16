<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Role;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class RoleEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('role.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Название')
                ->placeholder('Название')
                ->help('Отображаемое название роли'),

            Input::make('role.slug')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Метка')
                ->placeholder('Метка')
                ->help('Системное название роли'),
        ];
    }
}
