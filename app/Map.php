<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    //
    protected $fillable = ['user_id', 'subscriber_id', 'lng', 'lat', 'company_id', 'city'];
}
