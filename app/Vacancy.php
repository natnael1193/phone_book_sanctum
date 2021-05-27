<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    //
    protected $fillable = ['user_id', 'category_id', 'company', 'image', 'company', 'title', 'description'];
}