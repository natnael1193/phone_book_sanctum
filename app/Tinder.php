<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tinder extends Model
{
    //
    protected $fillable = ['image', 'title', 'description', 'user_id', 'opening_date', 'closing_date', 'price', 'bond', 'company_id', 'category_id'];
}
