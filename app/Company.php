<?php

namespace App;

use App\User;
use App\Service;
use Carbon\Carbon;
use App\Subscriber;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

// use Spatie\Backup\Notifications\Notifiable;

class Company extends Model
{

    use  LogsActivity;


    protected $appends = ['dates'];
    //
    protected static $logAttributes = [
        'company_category', 'company_name', 'company_name_am', 'phone_number', 'location_id','count',
        'company_email', 'phone_number_2', 'description', 'description_am', 'fax', 'website', 'company_logo_path',
        'location_image_id',  'tin_number', 'category_id', 'user_id', 'subscriber_id', 'verification', 'called','opening_hour', 'closing_hour', 'facebook', 'telegram', 'twitter','address', 'specific_address'
    ];

    protected $fillable = [
        'company_category', 'company_name', 'company_name_am', 'phone_number','location_id','count',
        'company_email', 'phone_number_2', 'description', 'description_am', 'fax', 'website', 'company_logo_path',
        'location_image_id',  'tin_number', 'category_id', 'user_id', 'subscriber_id', 'verification', 'called','opening_hour', 'closing_hour', 'facebook', 'telegram', 'twitter','address', 'specific_address'
    ];

    // public static function boot()
    // {
    //     parent::boot();

    //     self::updating(function ($model) {
    //         return $model->created_at !== null &&
    //             $model->created_at >= Carbon::now()->subHours(24);
    //     });
    // }



    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }
    public function rating()
    {
        return $this->belongsTo(Rating::class);
    }
    public function company_rating()
    {
        return $this->belongsTo(CompanyRating::class);
    }
    public function services()
    {
        return $this->hasMany(Service::class);
    }
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function company_category() {
        return $this->hasOne('App\CompanyRating','id','company_id');
    }

    public function getDatesAttribute()
    {
        $date = Carbon::parse($this->created_at); //You can use any date field you want

    $year  = $date->year;
    $month = $date->format('F');
    $day   = $date->day;
    $timeS = $date->format('A');
    $time  = $date->format('H:i');

//    return array (
//        'year'  => $year,
//        'month' => $month,
//        'day'   => $day,
//        'timeS' => $timeS,
//        'time'  => $time
//    );

}

}
