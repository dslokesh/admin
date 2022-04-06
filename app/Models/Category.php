<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Kyslik\ColumnSortable\Sortable;

class Category extends Model
{
    use HasFactory;
    use Uuids;
    use Sortable;

    public $incrementing = false;

    public $sortable = ['id', 'name', 'parent_id', 'status', 'created_at', 'updated_at'];


    public function childs()
    {
    	return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
    	return $this->belongsTo(Category::class, 'parent_id');
    }


}
