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
    
    
    public function assetsOnSiteByProjectCount($project_id)
    {
        $users = UserProjectRelation::where("project_id",$project_id)->pluck("user_id"); 
		
		$ppe = UserProductRelation::whereIn("user_id",$users)->count();
	   
        return $ppe;
    }
	
	public function assetsOnSiteByProjectCountByComapny($company_id)
    {
		$teamIds = TeamId::where("company_id",$company_id)->pluck("id");
		
        $users = UserProjectRelation::whereIn("project_id",$teamIds)->pluck("user_id"); 
		
		$ppe = UserProductRelation::whereIn("user_id",$users)->count();
	   
        return $ppe;
    }
	
	public function ProjectLiveBtn($project_id)
    {
		$users = UserProjectRelation::where("project_live",'=',0)->where("project_id",'=',$project_id)->count();
	   
        return $users;
    }
	
	public function assetsOnSiteByUserCount($user_id)
    {
		$ppe = UserProductRelation::where("user_id",$user_id)->count();
	   
        return $ppe;
    }
	
	public function getProjectDetailsByProduct($product_id)
    {
		$product = UserProductRelation::where("product_id",$product_id)->first();
		
		$array['address'] = '';
		$array['location'] = '';
		$array['project'] = '';
		if(isset($product))
		{
			$project = UserProjectRelation::where("user_id",$product->user_id)->first();
			
			if(isset($project))
			{
				$teamIds = TeamId::with('area')->where("id",$project->project_id)->first();	
				
				$array['address'] = $teamIds->address;
				$array['location'] = ($teamIds->area)?$teamIds->area->title:'';
				$array['project'] = ($teamIds->name)?$teamIds->name:'';
				return $array;
			}
		}
			
		
        return $array;
    }
	
	public function returnGraphColor($val)
    {
		if($val < 31)
		{
			$color = "red";
		}
		if($val > 30 && $val < 70)
		{
			$color = "#FFA701";
		}
		if($val > 69)
		{
			$color = "green";
		}
		
	   
        return $color;
    }
	
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
	
	public function assignedColor($val)
    {
		
		if($val  > 0)
		{
			$color = '<span class="badge bg-success">Assigned</span>';
		}
		else
		{
			$color = '<span class="badge bg-danger">Unassigned</span>';
		}
		
	   
        return $color;
    }
	
	public function warrantyColor($expirydate)
    {
		
		
		$currentDate = Carbon::now()->format('Y-m-d');
		$expiringDate = Carbon::now()->addMonths(1)->format('Y-m-d');
		
		
		
		if((strtotime($expirydate) >= strtotime($currentDate)) && (strtotime($expirydate) <= strtotime($expiringDate)))
           {
			   $status = '<span class="badge bg-warning">Expiring</span>';
           }
           elseif(strtotime($expirydate) < strtotime($currentDate))
           {
			   $status = '<span class="badge bg-danger">Expired</span>';
           }
           else{
			   $status = '<span class="badge bg-success">Valid</span>';
           }
		
	   
        return $status;
    }
	
	public function certificatStatus($val)
    {
		$currentDate = Carbon::now()->format('Y-m-d');
		$expiringDate = Carbon::now()->addMonths(1)->format('Y-m-d');
		if((strtotime($val) >= strtotime($currentDate)) && (strtotime($val) <= strtotime($expiringDate)))
           {
			   $status = '<span class="badge bg-warning">Expiring</span>';
           }
           elseif(strtotime($val) < strtotime($currentDate))
           {
			   $status = '<span class="badge bg-danger">Expired</span>';
           }
           else{
			   $status = '<span class="badge bg-success">Valid</span>';
           }
		
	   
        return $status;
    }
	
	
	public function productExp($val)
    {
		$currentDate = Carbon::now()->format('Y-m-d');
		$expiringDate = Carbon::now()->addMonths(1)->format('Y-m-d');
		if((strtotime($val) >= strtotime($currentDate)) && (strtotime($val) <= strtotime($expiringDate)))
           {
			   $status = '<span class="badge bg-warning">'.$val.'</span>';
           }
           elseif(strtotime($val) < strtotime($currentDate))
           {
			   $status = '<span class="badge bg-danger">'.$val.'</span>';
           }
           
		
	   
        return $status;
    }
	
	public function getFirstcertificatStatusByUser($user_id)
    {
		$currentDate = Carbon::now()->format('Y-m-d');
		$expiringDate = Carbon::now()->addMonths(1)->format('Y-m-d');
		$certificates = Certificate::where("associate_id",$user_id)->where("certificate_type","User")->orderBy('created_at',"DESC")->get();
		$valid = 0;
		$expiring = 0;
		$expired = 0;
		foreach($certificates as $certificate)
       {
           if((strtotime($certificate->expiry_date) >= strtotime($currentDate)) && (strtotime($certificate->expiry_date) <= strtotime($expiringDate)))
           {
			   $expiring++;
           }
           elseif(strtotime($certificate->expiry_date) < strtotime($currentDate))
           {
			   $expired++;
           }
           else{
			   $valid++;
           }
       }
	   
	   if($expired>0)
           {
			   $status = '<span class="badge bg-danger">Expired</span>';
			 return $status;
			   $expiring++;
            
           }
           elseif($expiring>0)
           {
			    $status = '<span class="badge bg-warning">Expiring</span>';
			 return $status;
           }
          elseif($valid>0)
		  {
            $status = '<span class="badge bg-success">Valid</span>';
			return $status;
           }
		   else
		   {
			    $status = '<span class="badge bg-info">N/A</span>';
				return $status;
		   }
		
	   
        
    }
	
	public function productImage($product_id)
    {
		$proImage = Gallery::where("upload_file_type","Image")->where('product_id',$product_id)->first();
		if(isset($proImage->image))
		{
			$pimage = $proImage->image;
		}
		else
		{
			$pimage = '';
		}
        return $pimage;
    }
	
	public function assignedProductExpStatusByUser($user_id)
    {
		
		$currentDate = Carbon::now()->format('Y-m-d');
		$expiringDate = Carbon::now()->addMonths(1)->format('Y-m-d');
		$ppe = UserProductRelation::with()->where("user_id",$user_id)->count();
		if((strtotime($val) >= strtotime($currentDate)) && (strtotime($val) <= strtotime($expiringDate)))
           {
			   $status = '<span class="badge bg-warning">'.$val.'</span>';
           }
           elseif(strtotime($val) < strtotime($currentDate))
           {
			   $status = '<span class="badge bg-danger">'.$val.'</span>';
           }
           
		
	   
        return $status;
    }
	
	public function assignedProductExpStatusByUserOne($user_id)
    {
		$currentDate = Carbon::now()->format('Y-m-d');
		$expiringDate = Carbon::now()->addMonths(1)->format('Y-m-d');
		$products = UserProductRelation::with("product")->where("user_id",$user_id)->orderBy('created_at',"DESC")->get();
		$valid = 0;
		$expiring = 0;
		$expired = 0;
		foreach($products as $product)
       {
		   if(isset($product->product))
		   {
			   
           if((strtotime($product->product->expiry_date) >= strtotime($currentDate)) && (strtotime($product->product->expiry_date) <= strtotime($expiringDate)))
           {
			   $expiring++;
           }
           elseif(strtotime($product->product->expiry_date) < strtotime($currentDate))
           {
			   $expired++;
           }
           else{
			   $valid++;
           }
		  }
       }
	   
	   if($expired>0)
           {
			   $status = '<span class="badge bg-danger">Expired</span>';
			 return $status;
			   $expiring++;
            
           }
           elseif($expiring>0)
           {
			    $status = '<span class="badge bg-warning">Expiring</span>';
			 return $status;
           }
          elseif($valid>0)
		  {
            $status = '<span class="badge bg-success">Valid</span>';
			return $status;
           }
		   else
		   {
			    $status = '<span class="badge bg-info">N/A</span>';
				return $status;
		   }
		
	   
        
    }
	
	public function sendNotification($user_ids,$title,$body,$type='')
    {
        $firebaseToken = User::whereNotNull('device_token')->whereIn("id",$user_ids)->pluck('device_token')->all();
          
		 
        $SERVER_API_KEY = env('FCM_KEY');;
  
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $title,
                "body" => $body,
            ],
			"data" => [
                "type" => $type
            ]
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);
  
        //dd($response);
		return $response;
    }
}
