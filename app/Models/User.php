<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Orchid\Filters\HttpFilter;
use Orchid\Platform\Models\Role;
use Orchid\Platform\Models\User as Authenticatable;
use Orchid\Support\Facades\Dashboard;
use Throwable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property array|null $permissions
 * @property string|null $api_token
 * @property-read mixed $has_token
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|Role[] $roles
 * @property-read int|null $roles_count
 * @method static Builder|User countByDays($startDate = null, $stopDate = null, string $dateColumn = 'created_at')
 * @method static Builder|User countForGroup(string $groupColumn)
 * @method static Builder|User defaultSort(string $column, string $direction = 'asc')
 * @method static Builder|User filters(?HttpFilter $httpFilter = null)
 * @method static Builder|User filtersApply(array $filters = [])
 * @method static Builder|User filtersApplySelection($selection)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User sumByDays(string $value, $startDate = null, $stopDate = null, string $dateColumn = 'created_at')
 * @method static Builder|User valuesByDays(string $value, $startDate = null, $stopDate = null, string $dateColumn = 'created_at')
 * @method static Builder|User whereApiToken($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePermissions($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 */
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'permissions',
        'api_token',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'permissions',
        'api_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions'          => 'array',
        'email_verified_at'    => 'datetime',
    ];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'name',
        'email',
        'permissions',
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'name',
        'email',
        'updated_at',
        'created_at',
    ];

    public static function makeToken(){
        return Str::random(80);
    }

    public function genToken($save = false){
        $this->api_token = static::makeToken();
        if($save)
            $this->save();
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     *
     * @throws Throwable
     */
    public static function createAdmin(string $name, string $email, string $password)
    {
        throw_if(static::where('email', $email)->exists(), 'User exist');

        static::create([
            'name'          => $name,
            'email'         => $email,
            'password'      => Hash::make($password),
            'permissions'   => Dashboard::getAllowAllPermission(),
            'api_token'     => static::makeToken(),
        ]);
    }

    public function getHasTokenAttribute(){
        return !empty($this->api_token);
    }

}
