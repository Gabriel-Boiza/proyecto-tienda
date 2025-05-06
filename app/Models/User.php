<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    protected $table = 'users';

    protected $fillable = [
        'id',
        'nick',
        'pass'
    ];

    protected $hidden = [
        'pass',
        'remember_token',
    ];

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->pass;
    }

    /**
     * Set the user's password.
     *
     * @param  string  $value
     * @return void
     */
    public function setPassAttribute($value)
    {
        $this->attributes['pass'] = Hash::make($value);
    }
}
