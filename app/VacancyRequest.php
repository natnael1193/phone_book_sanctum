<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VacancyRequest extends Model
{
    //
    protected $fillable = ['subscriber_id', 'vacancy_id'];
}
