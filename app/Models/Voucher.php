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
	
	public function arrivalairline()
    {
        return $this->belongsTo(Airline::class,'arrival_airlines_id','id');
    }
	
	public function depatureairline()
    {
        return $this->belongsTo(Airline::class,'depature_airlines_id','id');
    }
   
}