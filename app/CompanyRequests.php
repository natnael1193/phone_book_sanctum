<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Http\Request;

class CompanyRequests extends Model
{
    //
    use  LogsActivity;
}