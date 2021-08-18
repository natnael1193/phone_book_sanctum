<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Premium extends Model
{
    use LogsActivity;
    protected $fillable = ['company_id', 'email', 'bank', 'deposited_by', 'txn_no', 'date', 'status'];
    
    public function Company(){
        return $this->belongsTo(Company::class);
    }
}
