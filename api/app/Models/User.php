<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($password) {
        $this->attributes['password'] = app('hash')->make($password);
    }

    public function role() {
        return $this->belongsTo('App\Models\Role', 'role_id', 'id');
    }

    public function tokens() {
        return $this->hasMany('App\Models\ApiToken','user_id','id');
    }

    public function books() {
        return $this->hasMany('App\Models\Book','user_id','id');
    }

    public function orders() {
        return $this->hasMany('App\Models\Order','user_id','id');
    }

    public function comments() {
        return $this->hasMany('App\Models\Comment','user_id','id');
    }
}
