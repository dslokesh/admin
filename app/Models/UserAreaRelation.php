<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class UserAreaRelation extends Model
{
    use HasFactory;
    use Uuids;
    public $incrementing = false;

    public function area()
    {
    	return $this->belongsTo(Area::class, 'area_id');
    }
    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }
}
