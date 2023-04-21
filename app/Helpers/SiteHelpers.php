<?php

namespace App\Helpers;

use Ramsey\Uuid\Uuid;
use DB;
use Carbon\Carbon;
use Auth;
use App\Models\User;
use App\Models\UserProjectRelation;
use App\Models\UserProductRelation;
use App\Models\Certificate;
use App\Models\Gallery;
use App\Models\TeamId;

class SiteHelpers
{
    
    
   
	
	public function statusColor($val)
    {
		if($val ==1)
		{
			$color = '<span class="badge bg-success">Active</span>';
		}
		else
		{
			$color = '<span class="badge bg-danger">Inactive</span>';
		}
		
	   
        return $color;
    }
	
	public function statusColorYesNo($val)
    {
		if($val ==1)
		{
			$color = '<span class="badge bg-success">Yes</span>';
		}
		else
		{
			$color = '<span class="badge bg-danger">No</span>';
		}
		
	   
        return $color;
    }
	
	
}
