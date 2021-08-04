<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyRating extends Model
{
    //
    protected $fillable = ['company_id', 'rating', 'subscriber_id', 'review'];
    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

}


