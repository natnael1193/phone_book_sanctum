<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    //
    protected $fillable = ['subscriber_id', 'person_name', 'person_phone', 'person_email'];
}
