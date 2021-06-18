<?php

namespace App;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Subscriber extends Authenticatable
{
    //
    use HasApiTokens, Notifiable;
// The authentication guard for admin
    protected $guard = 'subscriber';
     /**
      * The attributes that are mass assignable.
      *
      * @var array
      */
      protected $fillable = ['name', 'password', 'email', 'company_email'];
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
    public function reviews(){
        return $this->hasMany(Review::class);
    }
    public function company_reviews(){
        return $this->hasMany(Review::class);
    }
    public function company_ratings(){
        return $this->hasMany(Rating::class);
    }
}
