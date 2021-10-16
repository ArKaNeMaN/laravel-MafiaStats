<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Orchid\Platform\Models\User as Authenticatable;
use Orchid\Support\Facades\Dashboard;

/**
 * @property int id
 * @property string name
 * @property string email
 * @property string email_verified_at
 * @property string password
 * @property array permissions
 * @property string remember_token
 * @property string api_token
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

    public function genToken($save = false){
        $this->api_token = Str::random(80);
        if($save)
            $this->save();
    }

}
