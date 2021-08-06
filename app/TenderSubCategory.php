<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TenderSubCategory extends Model
{
    protected $fillable = ['tender_category_id', 'name', 'name_am'];

    public function Category () {
        return $this->belongsTo(TenderCategory::class);
    }

    public function tenders () {
        return $this->hasMany(Tinder::class);
    }
}
