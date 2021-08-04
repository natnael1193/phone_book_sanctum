<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TenderCategory extends Model
{
    //
    protected $fillable = ['image', 'name', 'name_am'];

    public function Categories () {
        return $this->hasMany(TenderSubCategory::class);
    }
}
