<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    //
    protected $fillable = ['subscriber_id', 'certification_title', 'file'];
}
