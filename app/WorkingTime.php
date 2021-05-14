<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkingTime extends Model
{
    //
    protected $fillable = ['subscriber_id', 'name', 'opening_hour', 'closing_hour', 'company_id'];
}