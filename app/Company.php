<?php

namespace App;

use App\User;
use App\Subscriber;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
    protected $fillable = ['company_category','company_name', 'phone_number', 'email', 'phone_number_2', 'description', 'fax', 'website', 'company_logo_path', 'location_image_id','lang', 'link_id', 'encoder', 'category_id', 'user_id', 'verification','service', 'image'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function subscriber(){
        return $this->belongsTo(Subscriber::class);
    }
}