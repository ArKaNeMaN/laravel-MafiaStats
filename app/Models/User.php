<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int id
 * @property string login
 * @property string email
 * @property string password
 * @property string role
 * @property string api_token
 * @property Carbon updated_at
 * @property Carbon created_at
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    const ROLES = [
        'admin',    // Админ
        'master',   // Ведущий
        'user',     // Обычный пользователь
    ];

    protected const ROLES_VALUES = [
        'admin' => 0,       // Админ
        'master' => 100,    // Ведущий
        'user' => 1000,     // Обычный пользователь
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'api_token',
    ];

    /**
     * @param $role1
     * @param $role2
     * @return bool
     */
    public static function compareRoles($role1, $role2): bool
    {
        return (self::ROLES_VALUES[$role1] >= self::ROLES_VALUES[$role2]);
    }

    public function checkRole($role): bool
    {
        return self::compareRoles($this->role, $role);
    }

    public function regenerateApiToken(bool $save = true): string
    {
        $this->api_token = Str::random(60);
        if($save)
            $this->save();

        return $this->api_token;
    }
}
