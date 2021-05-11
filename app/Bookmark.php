<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    //
    protected $fillable = ['company_id', 'subscriber_id'];

    public function company(){
        return $this->belongsTo(Company::class);
    }
}