<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavedVacancy extends Model
{
    //
    protected $fillable = ['subscriber_id', 'vacancy_id'];
}
