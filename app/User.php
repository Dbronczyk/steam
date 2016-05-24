<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public function sale()
    {
        return $this->hasMany('App\Sale'); //jeden użytkownik ma wiele ofert sprzedaży
    }

    public function order()
    {
        return $this->hasMany('App\Order'); //jeden użytkownik ma wiele zamówień
    }

    public function score()
    {
        return $this->belongsTo('App\Score', 'id', 'userID'); //jeden użytkownik ma wiele zamówień
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'avatar', 'steamid', 'countryCode', 'profileURL', 'countryCode', 'role'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
