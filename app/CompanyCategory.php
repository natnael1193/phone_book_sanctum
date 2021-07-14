<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class CompanyCategory extends Model
{
    //
    // use HasFactory, Notifiable;
    use  LogsActivity;

    protected $table = "company_categories";

    protected $fillable = [
        'name'
    ];


}
