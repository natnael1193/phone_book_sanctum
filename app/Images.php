<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    //
    protected $fillable = ['user_id', 'company_id', 'image', 'subscriber_id'];
}