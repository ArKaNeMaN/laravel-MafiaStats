<?php

declare(strict_types=1);

namespace App\Orchid\Screens\User;

use App\Orchid\Layouts\Role\RolePermissionLayout;
use App\Orchid\Layouts\User\UserEditLayout;
use App\Orchid\Layouts\User\UserPasswordLayout;
use App\Orchid\Layouts\User\UserRoleLayout;
use App\Orchid\Layouts\User\UserTokenLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Orchid\Access\UserSwitch;
use Orchid\Platform\Models\User;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class UserEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Редактирование пользователя';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Информация о пользователе, в т.ч. E-Mail, логин и пароль.';

    /**
     * @var string
     */
    public $permission = 'platform.systems.users';

    /**
     * @var User
     */
    private $user;

    /**
     * Query data.
     *
     * @param User $user
     *
     * @return array
     */
    public function query(User $user): array
    {
        $this->user = $user;

        if(! $user->exists)
            $this->name = 'Create User';

        $user->load(['roles']);

        return [
            'user'       => $user,
            'permission' => $user->getStatusPermission(),
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Авторизоваться как...')
                ->icon('login')
                ->confirm('Для возвращения в нормальный режим выйдите из аккаунта.')
                ->method('loginAs')
                ->canSee($this->user->exists && \request()->user()->id !== $this->user->id),

            Button::make('Удалить')
                ->icon('trash')
                ->confirm('При удалении аккаунта, также удаляется вся информация о нём. При необходимости, предварительно сохраните всю нужную информацию.')
                ->method('remove')
                ->canSee($this->user->exists),

            Button::make('Сохранить')
                ->icon('check')
                ->method('save'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [

            Layout::block(UserEditLayout::class)
                ->title('Информация профиля')
                ->commands(
                    Button::make('Сохранить')
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->user->exists)
                        ->method('save')
                ),

            Layout::block(UserPasswordLayout::class)
                ->title('Пароль')
                ->commands(
                    Button::make('Сохранить')
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->user->exists)
                        ->method('save')
                ),

            Layout::block(UserTokenLayout::class)
                ->canSee($this->user->exists)
                ->title('API Токен')
                ->description('Токен для авторизации в сторонних приложениях')
                ->commands(
                    Button::make('(Пере)создать')
                        ->type(Color::DEFAULT())
                        ->icon('reload')
                        ->confirm('ВНИМАНИЕ! Авторизация во всех сторонних приложениях будет сброшена.')
                        ->method('genToken')
                ),

            Layout::block(UserRoleLayout::class)
                ->title('Роли')
                ->description('Роли пользователя, определяющие его права')
                ->commands(
                    Button::make('Сохранить')
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->user->exists)
                        ->method('save')
                ),

            Layout::block(RolePermissionLayout::class)
                ->title('Права')
                ->description('Персональные права пользователя, позволяющие выполнять действия, не подразвумеваемые ролями')
                ->commands(
                    Button::make('Сохранить')
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->user->exists)
                        ->method('save')
                ),

        ];
    }

    /**
     * @param User    $user
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(User $user, Request $request)
    {
        $request->validate([
            'user.email' => [
                'required',
                Rule::unique(User::class, 'email')->ignore($user),
            ],
        ]);

        $permissions = collect($request->get('permissions'))
            ->map(function ($value, $key) {
                return [base64_decode($key) => $value];
            })
            ->collapse()
            ->toArray();

        $userData = $request->get('user');
        if ($user->exists && (string)$userData['password'] === '') {
            // When updating existing user null password means "do not change current password"
            unset($userData['password']);
        } else {
            $userData['password'] = Hash::make($userData['password']);
        }

        $user
            ->fill($userData)
            ->fill([
                'permissions' => $permissions,
            ])
            ->save();

        $user->replaceRoles($request->input('user.roles'));

        Toast::info('Пользователь сохранён');

        return redirect()->route('platform.systems.users');
    }

    public function genToken(User $user){
        $user->genToken(true);
    }

    /**
     * @param User $user
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(User $user)
    {
        $user->delete();

        Toast::info('Пользователь удалён');

        return redirect()->route('platform.systems.users');
    }

    /**
     * @param User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginAs(User $user)
    {
        UserSwitch::loginAs($user);

        Toast::info('Теперь Вы авторизованы как этот пользователь');

        return redirect()->route(config('platform.index'));
    }
}
