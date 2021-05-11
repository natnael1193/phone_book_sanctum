<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    //
    protected $fillable = ['user_id', 'company_id', 'rating'];

    public function company(){
        return $this->hasMany(Company::class);
    }
}