<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = "activities";

   
	public function images()
    {
        return $this->hasMany('App\Models\Files', 'model_id', 'id')->where("model", "Activity");
    }
   
	public function prices()
    {
        return $this->hasMany('App\Models\ActivityPrices', 'activity_id', 'id');
    }
	
	
	public function transfer()
    {
        return $this->belongsTo('App\Models\Transfer', 'transfer_plan', 'id');
    }
	
	
}