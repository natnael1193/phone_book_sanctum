<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    //
    protected $fillable = ['subscriber_id', 'language_name', 'level'];
}
