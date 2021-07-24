<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = ['image', 'name', 'category_id', 'name_am'];
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function childrenCategories()
{
    return $this->hasMany(Category::class)->with('categories');
}
}
