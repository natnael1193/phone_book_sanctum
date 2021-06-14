<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    //
    protected $fillable = ['user_id', 'category_id', 'company', 'image', 'company_id', 'title', 'description', 'subscriber_id', 'due_date', 'location', 'job_type'];
}