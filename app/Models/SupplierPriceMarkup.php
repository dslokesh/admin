<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierPriceMarkup extends Model
{
    protected $table = "supplier_price_markup";

	public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}