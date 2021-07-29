<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    //
    protected $fillable = ['subscriber_id', 'experience_start_date', 'experience_end_date', 'experience_title', 'experience_description', 'company'];
}
