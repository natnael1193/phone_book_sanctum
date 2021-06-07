<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyRating extends Model
{
    //
    protected $fillable = ['company_id', 'rating', 'subscriber_id'];
}