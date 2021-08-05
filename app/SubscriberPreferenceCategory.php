<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriberPreferenceCategory extends Model
{
    //
    protected $fillable = ['category', 'subscriber_id'];
}
