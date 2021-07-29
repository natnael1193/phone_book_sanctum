<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    //
    protected $fillable = ['subscriber_id', 'education_start_date', 'education_end_date', 'education_title', 'education_description', 'institution'];
}
