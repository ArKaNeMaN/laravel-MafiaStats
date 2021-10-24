<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class UserEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('user.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Имя пользователя')
                ->placeholder('Имя пользователя'),

            Input::make('user.email')
                ->type('email')
                ->required()
                ->title('E-Mail')
                ->placeholder('E-Mail'),
        ];
    }
}
