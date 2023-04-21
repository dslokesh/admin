<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentPriceMarkup extends Model
{
    protected $table = "agent_price_markup";

	public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}