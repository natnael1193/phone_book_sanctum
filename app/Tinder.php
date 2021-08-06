<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tinder extends Model
{
    //
    protected $appends = ['dates'];
//    protected $appends1 = ['closing_date'];
    protected $fillable = ['image', 'title', 'description', 'type', 'location', 'reference','reference_date','user_id', 'opening_date', 'closing_date', 'closing_time','price', 'bond', 'company_id', 'tender_sub_category_id', 'title_am', 'description_am'];

    public function getDatesAttribute()
    {$date = Carbon::parse($this->opening_date);
    $closing_date = Carbon::parse($this->closing_date); //You can use any date field you want

        $year = $date->year;
        $month = $date->format('F');
        $day = $date->day;
        $timeS = $date->format('A');
        $time = $date->format('H:i');

        $closing_year  = $closing_date->year;
        $closing_month = $closing_date->format('F');
        $closing_day   = $closing_date->day;


        return array(
            'opening_year' => $year,
            'opening_month' => $month,
            'opening_day' => $day,
            'closing_year'  => $closing_year,
            'closing_month' => $closing_month,
            'closing_day'   => $closing_day,
//        'timeS' => $timeS,
//        'time'  => $time
        );

        //You can use any date field you want

//        $closing_year  = $closing_date->year;
//        $month = $closing_date->format('F');
//        $day   = $closing_date->day;
//        $timeS = $closing_date->format('A');
//        $time  = $closing_date->format('H:i');
//
//        return array (
//            'year'  => $year,
//            'month' => $month,
//            'day'   => $day,
////        'timeS' => $timeS,
////        'time'  => $time
//        );

    }

    public function category () {
        return $this->belongsTo(TenderSubCategory::class);
    }

}
