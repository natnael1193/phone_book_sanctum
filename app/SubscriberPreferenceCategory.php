<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriberPreferenceCategory extends Model
{
    //
    protected $fillable = ['category', 'subscriber_id'];

    protected $columns = ['id', 'subscriber_id', 'category','created_at', 'updated_at']; // add all columns from you table

public function scopeExclude($query, $value = []) 
{
    return $query->select(array_diff($this->columns, (array) $value));
}
}
