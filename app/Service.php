<?php

namespace App;

use App\Company;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //
    protected $table = "services";
    protected $fillable = ['name', 'user_id', 'company_id'];
    
    public function company(){
        return $this->belongsTo(Company::class);
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}