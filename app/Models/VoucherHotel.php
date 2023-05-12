<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherHotel extends Model
{
    protected $table = "voucher_hotels";
	public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
   
}