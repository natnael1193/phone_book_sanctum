<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //
    public function vacancy(){
        return $this->hasOne(Vacancy::class);
    }
}
