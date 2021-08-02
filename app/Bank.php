<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Bank extends Model
{
    use LogsActivity;
    protected $fillable = ['name', 'name_am', 'account_no'];
}
