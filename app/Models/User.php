<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Orchid\Platform\Models\User as Authenticatable;
use Orchid\Support\Facades\Dashboard;
use Throwable;

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
        'player_id',
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

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'player_id', 'id');
    }

    public static function makeToken(): string
    {
        return Str::random(80);
    }

    public function genToken($save = false): void
    {
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
    public static function createAdmin(string $name, string $email, string $password): void
    {
        throw_if(static::query()->where('email', $email)->exists(), 'User exist');

        static::create([
            'name'          => $name,
            'email'         => $email,
            'password'      => Hash::make($password),
            'permissions'   => Dashboard::getAllowAllPermission(),
            'api_token'     => static::makeToken(),
        ]);
    }

    public function getHasTokenAttribute(): bool
    {
        return !empty($this->api_token);
    }

}
