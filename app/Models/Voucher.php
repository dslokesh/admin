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
	
	 public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    /**
     * Summary of updatedBy
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
	
	function voucheractivity() {

    return $this->hasMany(VoucherActivity::class);
	}

	public function voucheredBy()
    {
        return $this->belongsTo(User::class, 'vouchered_by', 'id');
    }
   
}