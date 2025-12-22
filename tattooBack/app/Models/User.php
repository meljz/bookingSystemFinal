<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, JWTSubject
{
    use Authenticatable;

    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = ['password'];

    /**
     * Required by JWTSubject
     */
    public function getJWTIdentifier()
    {
        return $this->getKey(); // usually the "id"
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
