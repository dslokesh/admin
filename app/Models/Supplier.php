<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = "suppliers";

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
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
   
}