<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class AgentAmount extends Model
{
    protected $table = "agent_amounts";
	
	public function agent()
    {
        return $this->belongsTo(User::class,'agent_id','id');
    }
}
