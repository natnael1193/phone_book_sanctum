<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Blog extends Model
{
    //
    use LogsActivity;
    protected $fillable = ['image', 'title', 'description', 'user_id', 'category_id'];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
