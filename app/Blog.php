<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    //
    protected $fillable = ['image', 'title', 'description', 'user_id'];
    public function user(){
        return $this->belongsTo(User::class);
    }
}