<?php

declare(strict_types=1);

namespace App\Orchid\Screens\User;

use App\Orchid\Layouts\User\ProfilePasswordLayout;
use App\Orchid\Layouts\User\UserEditLayout;
use App\Orchid\Layouts\User\UserTokenLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Orchid\Platform\Models\User;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class UserProfileScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Аккаунт';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Изменение данных аккаунта';


    protected User|\App\Models\User|null $user = null;
    /**
     * Query data.
     *
     * @param Request $request
     *
     * @return array
     */
    public function query(Request $request): array
    {
        $this->user = $request->user();

        return [
            'user' => $this->user,
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::block(UserEditLayout::class)
                ->title('Информация профиля')
                ->description('Изменение ифномрации об аккаунте.')
                ->commands(
                    Button::make('Сохранить')
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->method('save')
                ),

            Layout::block(UserTokenLayout::class)
                ->title('API Токен')
                ->description('Токен для авторизации в сторонних приложениях')
                ->commands(
                    Button::make('(Пере)создать')
                        ->type(Color::DEFAULT())
                        ->icon('reload')
                        ->confirm($this->user->has_token ? 'ВНИМАНИЕ!<br>Авторизация во всех сторонних приложениях будет сброшена.' : false)
                        ->method('genToken')
                ),

            Layout::block(ProfilePasswordLayout::class)
                ->title('Изменить пароль')
                ->commands(
                    Button::make('Изменить пароль')
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->method('changePassword')
                ),
        ];
    }

    /**
     * @param Request $request
     */
    public function save(Request $request): void
    {
        $request->validate([
            'user.name'  => 'required|string',
            'user.email' => [
                'required',
                Rule::unique(User::class, 'email')->ignore($request->user()),
            ],
        ]);

        $request->user()
            ->fill($request->get('user'))
            ->save();

        Toast::info('Профиль изменён');
    }

    /**
     * @param Request $request
     */
    public function changePassword(Request $request): void
    {
        $request->validate([
            'old_password' => 'required|password:web',
            'password'     => 'required|confirmed',
        ]);

        tap($request->user(), function ($user) use ($request) {
            $user->password = Hash::make($request->get('password'));
        })->save();

        Toast::info('Пароль изменён');
    }

    public function genToken(Request $req){
        $req->user()->genToken(true);
    }
}
