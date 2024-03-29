<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyReview extends Model
{
    //
    protected $fillable = ['company_id', 'review', 'subscriber_id'];

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }
}
