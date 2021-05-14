<?php

namespace App;

use App\Company;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //
    use HasApiTokens;
    protected $table = "services";
    protected $fillable = ['name', 'subscriber_id', 'company_id'];
    
    public function company(){
        return $this->belongsTo(Company::class);
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}