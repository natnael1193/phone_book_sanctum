<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Subscriber extends Authenticatable
{
    //
    use Notifiable;
// The authentication guard for admin
    protected $guard = 'subscriber';
     /**
      * The attributes that are mass assignable.
      *
      * @var array
      */
      protected $fillable = ['name', 'password', 'email',];
      /**
       * The attributes that should be hidden for arrays.
       *
       * @var array
       */
      protected $hidden = [
        'password', 'remember_token',
    ];
    public function company(){
        return $this->hasOne(Company::class);
    }
}