<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkingTime extends Model
{
    //
    protected $fillable = ['subscriber_id', 'day',  'company_id', 'monday_open','tuesday_open',
     'wednesday_open', 'saturday_open', 'thursday_open', 'sunday_open',  'friday_open', 
      'monday_closed','thursday_closed', 'tuesday_closed','wednesday_closed', 'friday_closed', 
      'sunday_closed', 'saturday_closed',];
}