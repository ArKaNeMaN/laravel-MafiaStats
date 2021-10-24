<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Password;
use Orchid\Screen\Layouts\Rows;

class ProfilePasswordLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Password::make('old_password')
                ->placeholder('Введите текущий пароль')
                ->title('Текущий пароль'),

            Password::make('password')
                ->placeholder('Введите новый пароль')
                ->title('Новый пароль'),

            Password::make('password_confirmation')
                ->placeholder('Введите новый пароль')
                ->title('Подтверждение нового пароля')
                ->help('A good password is at least 15 characters or at least 8 characters long, including a number and a lowercase letter.'),
        ];
    }
}
