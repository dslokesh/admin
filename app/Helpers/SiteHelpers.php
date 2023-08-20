<?php

namespace App\Helpers;

use Ramsey\Uuid\Uuid;
use DB;
use Carbon\Carbon;
use Auth;
use App\Models\User;
use App\Models\VoucherActivity;
use App\Models\VoucherHotel;
use App\Models\ActivityPrices;
use App\Models\AgentPriceMarkup;
use App\Models\Zone;
use App\Models\TransferData;
use App\Models\Activity;
use App\Models\Ticket;

class SiteHelpers
{
    
	public function statusColor($val)
    {
		$color ='';
		if($val ==1) {
			$color = '<span class="badge bg-success">Active</span>';
		} else {
			$color = '<span class="badge bg-danger">Inactive</span>';
		}
		
	   
        return $color;
    }
	
	public function statusColorYesNo($val)
    {
		$color = '';
		if($val ==1) {
			$color = '<span class="badge bg-success">Yes</span>';
		} else {
			$color = '<span class="badge bg-danger">No</span>';
		}
		
	   
        return $color;
    }
	
	public function getAgentMarkup($agent_id,$activity_id,$variant_code)
    {
		$markup = [];
		$markup['ticket_only'] = 0;
		$markup['sic_transfer'] = 0;
		$markup['pvt_transfer'] = 0;
		$user = User::where('id',  $agent_id)->first();
		$m = AgentPriceMarkup::where('agent_id',  $agent_id)->where('activity_id',  $activity_id)->where('variant_code',  $variant_code)->first();
		
			if(!empty($m->ticket_only)){
			$markup['ticket_only'] = $m->ticket_only;
			}elseif(!empty($user->ticket_only)){
			$markup['ticket_only'] = $user->ticket_only;	
			}
			if(!empty($m->sic_transfer)){
			$markup['sic_transfer'] = $m->sic_transfer;
			}elseif(!empty($user->ticket_only)){
			$markup['sic_transfer'] = $user->sic_transfer;	
			}
			if(!empty($m->pvt_transfer)){
			$markup['pvt_transfer'] = $m->pvt_transfer;
			}elseif(!empty($user->pvt_transfer)){
			$markup['pvt_transfer'] = $user->pvt_transfer;	
			}
		
		
        return $markup;
    }
	
	public function getZone($activity_zones,$sic_TFRS)
    {
		$zoneArray = [];
		
		if($sic_TFRS == 1) {
			$zoneArrayJson = json_decode($activity_zones);
			
			if(count($zoneArrayJson) > 0 or !empty($zoneArrayJson)) {
				foreach($zoneArrayJson as $k => $z) {
					$zone = Zone::where('status', 1)->where('id', $z->zone)->orderBy('name', 'ASC')->first();
					if(!empty($zone))
					{
					$zoneArray[] = [
					'zone_id' => $zone->id,
					'zone' => $zone->name,
					'zoneValue' => $z->zoneValue,
					'pickup_time' => (!empty($z->pickup_time))?$z->pickup_time:'',
					'dropup_time' => (!empty($z->dropup_time))?$z->dropup_time:'',
					];
					}
				}
			}
			
		}
		
		return $zoneArray;
    }
	
	public function getPickupTimeByZone($activity_zones,$zoneId)
    {
		$pickup_time = '';
		
		if($zoneId > 0){
			$zoneArrayJson = json_decode($activity_zones);
			if(count($zoneArrayJson) > 0 or !empty($zoneArrayJson)){
				foreach($zoneArrayJson as $k => $z){
					if($zoneId == $z->zone){
					$pickup_time =   (!empty($z->pickup_time))?$z->pickup_time:'';
					}
				}
			}
			
		}
		
		return $pickup_time;
    }
	
	public function getActivity($activity_id)
    {
		
		$activity = Activity::where('status', 1)->where('id', $activity_id)->first();
		return $activity;
    }
	
	public function getZoneName($zoneId)
    {
				$zone = Zone::where('status', 1)->where('id', $zoneId)->first();
				
		return $zone;
    }
	
	public function getDateList($startDate,$endDate,$blackoutDates='')
    {
			$blackDate = [];
			if(!empty($blackoutDates)){
				$blackDate = explode(",",$blackoutDates);
			}
			// Create DateTime objects from the start and end dates
			$start = new \DateTime($startDate);
			$end = new \DateTime($endDate);

			// Add one day to the end date to include it in the range
			$end->modify('+1 day');

			// Initialize an empty array to store the dates
			$dates = [];

			// Iterate over each day and add it to the array
			$interval = new \DateInterval('P1D'); // 1 day interval
			$period = new \DatePeriod($start, $interval, $end);
			foreach ($period as $date) {
				$dt = $date->format('Y-m-d');
				if(!in_array($dt,$blackDate)){
				$dates[] = $dt;
				}
			}

		return $dates;
    }
	
	public function voucherStatus($val)
    {
		$color = '';
		$voucherStatus = config("constants.voucherStatus");
		if($val ==1){
			$color = '<span class="badge bg-primary">Draft</span>';
		} else if($val == 2) {
			$color = '<span class="badge bg-secondary">Create Quotation</span>';
		} else if($val == 3) {
			$color = '<span class="badge bg-info">In Process</span>';
		} else if($val == 4) {
			$color = '<span class="badge bg-warning">Confirmed</span>';
		} else if($val == 5) {
			$color = '<span class="badge bg-success">Vouchered</span>';
		} else if($val == 6) {
			$color = '<span class="badge bg-danger">Canceled</span>';
		}
		 
		 return $color;
	}
	
	public function getActivityLowPrice($activity_id,$agent_id,$vat_invoice)
    {
		$minPrice = 0;
		$zonePrice = 0;
		$transferPrice = 0;
		$vatPrice = 0;
		
		$activity = Activity::where('id', $activity_id)->select('entry_type','sic_TFRS','pvt_TFRS','zones','transfer_plan','vat')->first();
		$avat = 0;
		if($activity->vat > 0){
		$avat = $activity->vat;	
		}
		if($vat_invoice == 1){
	$ap = ActivityPrices::where('activity_id', $activity_id)
    ->orderByRaw('CAST(adult_rate_without_vat AS DECIMAL(10, 2))')
    ->select('adult_rate_without_vat', 'variant_code')
    ->first();
	$adult_rate = $ap->adult_rate_without_vat;
	
	
	} else {
		$ap = ActivityPrices::where('activity_id', $activity_id)
    ->orderByRaw('CAST(adult_rate_with_vat AS DECIMAL(10, 2))')
    ->select('adult_rate_with_vat', 'variant_code')
    ->first();
	$adult_rate = $ap->adult_rate_with_vat;
	}
		if(isset($ap->variant_code)){
		$markup = self::getAgentMarkup($agent_id,$activity_id, $ap->variant_code);
		}else{
			$markup['ticket_only'] = 0;
			$markup['sic_transfer'] = 0;
			$markup['pvt_transfer'] = 0;
		}
		
		
		 
			if($activity->sic_TFRS==1){
				
				 $actZone = self::getZone($activity->zones,$activity->sic_TFRS);
				 if(!empty($actZone))
				 {
					  $zonePrice = $actZone[0]['zoneValue'];
				 }
			}
			if($activity->pvt_TFRS==1){
					$td = TransferData::where('transfer_id', $activity->transfer_plan)->where('qty', 1)->first();
					if(!empty($td))
					{
					 $transferPrice = $td->price;
					}
			}
			
		if($adult_rate > '0'){
			if($activity->entry_type=='Ticket Only'){
				$minPrice = $adult_rate + $markup['ticket_only'];
			} else {
			if($activity->sic_TFRS==1){
				$minPrice =  $adult_rate + $markup['sic_transfer'] + $markup['ticket_only'] + $zonePrice;
			}elseif($activity->pvt_TFRS==1){
				  $minPrice = $adult_rate + $markup['ticket_only'] + $markup['pvt_transfer'] + $transferPrice;
			}
			}
			
		} else {
			if($activity->sic_TFRS==1){
				 $minPrice =  $adult_rate + $markup['sic_transfer'] + $markup['ticket_only'] + $zonePrice;
				
			}elseif($activity->pvt_TFRS==1){
				  $minPrice = $adult_rate + $markup['ticket_only'] + $markup['pvt_transfer'] + $transferPrice;
			}
			

		}
		if($vat_invoice == 1){
		$vatPrice = (($avat/100) * $minPrice);
		}
		
		$total = $minPrice+$vatPrice;
		return number_format($total, 2, '.', "");
    }
	
	public function hotelRoomsDetails($data)
    {
		$rooms = json_decode($data);
		$room_type = '';
		$number_of_rooms = 0;
		$occupancy = 0;
		$price = 0;
		if(count($rooms) > 0) {
			
			foreach($rooms as $room) {
				$room_type.=$room->room_type.',';
				$number_of_rooms+=1;
				$occupancy +=$room->nop_s + $room->nop_d;
				$mealplan =(!empty($room->mealplan))?$room->mealplan:'';
				$price +=$room->nr_s + $room->nr_d + $room->nr_eb + $room->nr_cwb + $room->nr_cnb;
			}
		}
		
		$dataArray = [
		'room_type' => rtrim($room_type, ','),
		'number_of_rooms' => $number_of_rooms,
		'occupancy' => $occupancy,
		'mealplan' => $mealplan,
		'price' => $price,
		];
		
		return $dataArray;
    }
	
	function format_minutes_to_hours($totalMinutes)
    {
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;
        
        return sprintf("%02d:%02d", $hours, $minutes). ' Hour(s)';
    }
	
	
	public function getTicketCountByCode($code)
    {
		
		$ticketCount = Ticket::where('activity_variant', $code)->count();
		return $ticketCount;
    }

	public function voucherActivityCount($vid)
    {
		
		$voucherActivity = VoucherActivity::where('voucher_id',$vid)->count();
		
		return $voucherActivity;
    }

	public function voucherHotelCount($vid)
    {
		
		$voucherHotel = VoucherHotel::where('voucher_id',$vid)->count();
		
		return $voucherHotel;
    }
	
	public function checkPermissionMethod($p)
    {
		$user = auth()->user();
		$role = $user->role;
		$permission = $user->hasPermission($p, $role);
		if(!empty($permission)){
			return 1;
		} else {
			return abort(403, 'Unauthorized');;
		}
		
    }
	
}
