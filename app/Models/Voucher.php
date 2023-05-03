<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = "vouchers";

    
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class,'agent_id','id');
    }
	
	public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
   
}