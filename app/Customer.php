<?php

namespace App;


use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    //
    use HasApiTokens, Notifiable;
// The authentication guard for admin
    protected $guard = 'customer';
     /**
      * The attributes that are mass assignable.
      *
      * @var array
      */
      protected $fillable = ['name', 'password', 'email', 'phone'];
      /**
       * The attributes that should be hidden for arrays.
       *
       * @var array
       */
      protected $hidden = [
        'password', 'remember_token',
    ];

}