<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Persona;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class UserListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'users';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('name', 'Имя')
                ->sort()
                ->cantHide()
                ->filter(TD::FILTER_TEXT)
                ->render(function (User $user) {
                    return new Persona($user->presenter());
                }),

            TD::make('email', 'E-Mail')
                ->sort()
                ->cantHide()
                ->filter(TD::FILTER_TEXT)
                ->render(function (User $user) {
                    return ModalToggle::make($user->email)
                        ->modal('oneAsyncModal')
                        ->modalTitle($user->presenter()->title())
                        ->method('saveUser')
                        ->asyncParameters([
                            'user' => $user->id,
                        ]);
                }),

            TD::make('updated_at', 'Изменён')
                ->sort()
                ->render(function (User $user) {
                    return $user->updated_at->toDateTimeString();
                }),

            TD::make('Действия')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (User $user) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make('Изменить')
                                ->route('platform.systems.users.edit', $user->id)
                                ->icon('pencil'),

                            Button::make('Удалить')
                                ->icon('trash')
                                ->confirm('При удалении аккаунта, также удаляется вся информация о нём. При необходимости, предварительно сохраните всю нужную информацию')
                                ->method('remove', [
                                    'id' => $user->id,
                                ]),
                        ]);
                }),
        ];
    }
}
