<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Vacancy extends Model
{
    protected $appends = ['dates'];
    //
    protected $fillable = ['user_id', 'category_id', 'company', 'image', 'company_id', 'title', 'description', 'subscriber_id', 'due_date', 'location', 'job_type'];

    public function getDatesAttribute()
    {
        $date = Carbon::parse($this->due_date); //You can use any date field you want

    $year  = $date->year;
    $month = $date->format('F');
    $day   = $date->day;
    $timeS = $date->format('A');
    $time  = $date->format('H:i');

    return array (
        'year'  => $year,
        'month' => $month,
        'day'   => $day,
//        'timeS' => $timeS,
//        'time'  => $time
    );

}



    public function location(){
        return $this->belongsTo(Location::class);
    }

}
