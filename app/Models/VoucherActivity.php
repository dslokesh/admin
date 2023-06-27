<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherActivity extends Model
{
	protected $table ="voucher_activity";
	
	public function voucher()
    {
        return $this->belongsTo(Voucher::class,'voucher_id','id');
    }
	
	public function activity()
    {
        return $this->belongsTo(Activity::class,'activity_id','id');
    }
	
	public function supplierticket()
    {
        return $this->belongsTo(Supplier::class,'supplier_ticket','id');
    }
	
	public function suppliertransfer()
    {
        return $this->belongsTo(Supplier::class,'supplier_transfer','id');
    }
	
	
}
