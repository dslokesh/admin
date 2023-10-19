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
use App\Models\Voucher;
use App\Models\Ticket;
use App\Models\VoucherActivityLog;

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
	
	public function getDateListBoth($startDate,$endDate,$blackoutDates='')
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
			$dateData = [];
			$availableDates = [];
			$disabledDates = [];
			// Iterate over each day and add it to the array
			$interval = new \DateInterval('P1D'); // 1 day interval
			$period = new \DatePeriod($start, $interval, $end);
			foreach ($period as $date) {
				$dt = $date->format('Y-m-d');
				if(!in_array($dt,$blackDate)){
				$availableDates[] = $dt;
				} else {
					$disabledDates[] = $dt;
				}
			}
		
		$dateData['availableDates'] = json_encode($availableDates);
		$dateData['disabledDates'] = json_encode($disabledDates);
		return $dateData;
    }
	
	public function getNovableActivityDays($availability)
    {
		$days = [];
			$notAvDay = [];
		if(($availability != 'All') and !empty(($availability))){
		
		$daysName = [
		'Sunday' => 0,
		'Monday' => 1,
		'Tuesday' => 2,
		'Wednesday' => 3,
		'Thursday' => 4,
		'Friday' => 5,
		'Saturday' => 6,
		];
			
			if(!empty($availability)){
				$days = explode(",",$availability);
				
			foreach ($daysName as $k => $day) {
				if(in_array($k,$days)){
				//$notAvDay[] = $k;
				}
				else{
					$notAvDay[] = $day;
				}
			}
			}
			
			//print_r($notAvDay);
	
		}
		
		return json_encode($notAvDay);
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
		} else if($val == 7) {
			$color = '<span class="badge bg-danger">Invoice Edit Requested</span>';
		}
		 return $color;
	}
	
	public function getActivityLowPrice($activity_id,$agent_id,$voucher)
    {
		$minPrice = 0;
		$zonePrice = 0;
		$transferPrice = 0;
		$vatPrice = 0;
		$adult_rate = 0;
		$vat_invoice = $voucher->vat_invoice;
		$startDate = $voucher->travel_from_date;
		$endDate = $voucher->travel_to_date;
		$user = auth()->user();
		
		$activity = Activity::where('id', $activity_id)->select('entry_type','sic_TFRS','pvt_TFRS','zones','transfer_plan','vat')->first();
		$avat = 0;
		if($activity->vat > 0){
		$avat = $activity->vat;	
		}
		
		$query = ActivityPrices::where('activity_id', $activity_id)->where('rate_valid_from', '<=', $startDate)->where('rate_valid_to', '>=', $endDate);
		if($user->role_id == '3'){
			$query->where('for_backend_only', '0');
		}
		if($vat_invoice == 1){
			$ap = $query->orderByRaw('CAST(adult_rate_without_vat AS DECIMAL(10, 2))')
    ->select('adult_rate_without_vat', 'variant_code')
    ->first();
	if(isset($ap->variant_code)){
	$adult_rate = $ap->adult_rate_without_vat;
	}
	
	
	} else {
	$ap = $query->orderByRaw('CAST(adult_rate_with_vat AS DECIMAL(10, 2))')
    ->select('adult_rate_with_vat', 'variant_code')
    ->first();
	
	if(isset($ap->adult_rate_with_vat)){
	$adult_rate = $ap->adult_rate_with_vat;
	}
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
			
		if($adult_rate > 0){
			$markupPriceT  = ($adult_rate * $markup['ticket_only'])/100;
			
			if($activity->entry_type=='Ticket Only'){
				$minPrice = $adult_rate + $markupPriceT;
			} else {
			if($activity->sic_TFRS==1){
				$markupPriceS  = ($zonePrice * $markup['sic_transfer'])/100;
				$minPrice =  $adult_rate + $markupPriceS + $markupPriceT + $zonePrice;
			}elseif($activity->pvt_TFRS==1){
				$markupPriceP  = ($transferPrice * $markup['pvt_transfer'])/100;
				  $minPrice = $adult_rate + $markupPriceP + $markupPriceT + $transferPrice;
			}
			}
			
		} else {
			
			if($activity->sic_TFRS==1){
				
				$markupPriceS  = ($zonePrice * $markup['sic_transfer'])/100;
				$minPrice =  $markupPriceS +  $zonePrice;
				
			}elseif($activity->pvt_TFRS==1){
				$markupPriceP  = ($transferPrice * $markup['pvt_transfer'])/100;
				$minPrice =   $markupPriceP + $transferPrice;
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
		$child = 0;
		if(count($rooms) > 0) {
			
			foreach($rooms as $room) {
				$room_type.=$room->room_type.',';
				$number_of_rooms += $room->nom_of_room ;
				$occupancy +=$room->nop_s + $room->nop_d+ $room->nop_eb;
				$child +=$room->nop_cwb + $room->nop_cnb;
				$mealplan =(!empty($room->mealplan))?$room->mealplan:'';
				$price +=$room->nr_s + $room->nr_d + $room->nr_eb + $room->nr_cwb + $room->nr_cnb;
			}
		}
		
		$dataArray = [
		'room_type' => rtrim($room_type, ','),
		'number_of_rooms' => $number_of_rooms,
		'occupancy' => $occupancy,
		'mealplan' => $mealplan,
		'childs' => $child,
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
	
	
	public function checkAvailableBookingTimeSlot($u_code,$activity_id,$tourDt,$transfer_option,$is_opendated)
    {
		
		$activityPrice = ActivityPrices::where(['u_code'=>$u_code,'activity_id'=>$activity_id])->select('start_time','end_time','booking_window_valueto','booking_window_valueSIC','booking_window_valuePVT')->first();
			$startTime = $activityPrice->start_time;
			$combinedDatetime = $tourDt . ' ' . $startTime;
			$validuptoTime = strtotime($combinedDatetime);
			$booking_window_valueto = 0;
			$currentTimestamp = strtotime("now");
			if(($transfer_option == 'Ticket Only') && ($is_opendated == '1')){
				return 0;
			}
			
			if($transfer_option == 'Shared Transfer'){
				$cancelHours = ($activityPrice->cancellation_valueSIC>0)?$activityPrice->cancellation_valueSIC:0;
			}
			elseif($transfer_option == 'Pvt Transfer'){
				$cancelHours = ($activityPrice->cancellation_valuePVT>0)?$activityPrice->cancellation_valuePVT:0;
			}else{
				$cancelHours = ($activityPrice->cancellation_value_to>0)?$activityPrice->cancellation_value_to:0;
			}
			
			if($cancelHours > 0){
			$booking_window_valueto  = $cancelHours * 60*60;
			}
			
			
			$bookingTime = $currentTimestamp + $booking_window_valueto;
			
			if($validuptoTime >= $bookingTime){
				return 0;
			} else {
				return 1;
			}
		
    }
	
	public function getAgentlastVoucher()
    {
		$user = auth()->user();
		$startDate = date("Y-m-d");
		$voucher = Voucher::where('status_main','1')->where('agent_id',$user->id)->whereDate('travel_from_date','>=', $startDate)->first();
		if(!empty($voucher)){
			return $voucher;
		}
		else{
		return 0;	
		}
		
    }
	
	public function checkCancelBookingTime($u_code,$activity_id,$tourDt,$transfer_option)
    {
		
		$activityPrice = ActivityPrices::where(['u_code'=>$u_code,'activity_id'=>$activity_id])->select('start_time','end_time','cancellation_value_to','cancellation_valueSIC','cancellation_valuePVT')->first();
			$startTime = $activityPrice->start_time;
			$combinedDatetime = $tourDt . ' ' . $startTime;
			$validuptoTime = strtotime($combinedDatetime);
			$booking_window_valueto = 0;
			$cancelHours = 0;
			$currentTimestamp = strtotime("now");
			
			if($transfer_option == 'Shared Transfer'){
				$cancelHours = ($activityPrice->cancellation_valueSIC>0)?$activityPrice->cancellation_valueSIC:0;
			}
			elseif($transfer_option == 'Pvt Transfer'){
				$cancelHours = ($activityPrice->cancellation_valuePVT>0)?$activityPrice->cancellation_valuePVT:0;
			}else{
				$cancelHours = ($activityPrice->cancellation_value_to>0)?$activityPrice->cancellation_value_to:0;
			}
			
			if($cancelHours > 0){
			$booking_window_valueto  = $cancelHours * 60*60;
			}
			
			$vlt= $validuptoTime - $booking_window_valueto;
			$bookingTime = $currentTimestamp;
			$data['validuptoTime'] = date("d-m-Y h:i a",$vlt);
			$data['cancelhwr'] = $cancelHours;
			if($cancelHours == 0){
				$data['btm'] = 0;
			} else {
			if($vlt >= $bookingTime){
				$data['btm'] = 1;
			} else {
				$data['btm'] = 0;
			}
			}
			
			return $data;
		
    }
	
	public function getActivityVarByCutoffCancellation($activity_id)
    {
		
		$activityPrice = ActivityPrices::where(['activity_id'=>$activity_id])->where(function ($query) {
        $query->where('cancellation_value_to', '0');
			 $query->orWhere('cancellation_valueSIC', '0');
			   $query->orWhere('cancellation_valuePVT', '0');
    })->count();
			
			
			if($activityPrice == 0){
				$booking_window_text  = 'Free Cancellation';
			} else{
				$booking_window_text  = 'Non - Refundable';
				
			}
		return $booking_window_text;
    }
	
	public function getActivityPriceSaveInVoucherActivity($transfer_option,$activity_id,$agent_id,$voucher,$u_code,$adult,$child,$infent,$discount)
    {
		$totalPrice = 0;
		$zonePrice = 0;
		$transferPrice = 0;
		$vatPrice = 0;
		$adult_total_rate = 0;
		$adultPrice = 0;
		$childPrice = 0;
		$infPrice = 0;
		$pvtTrafValWithMarkup = 0;
		$totalmember = $adult + $child;
		$vat_invoice = $voucher->vat_invoice;
		$startDate = $voucher->travel_from_date;
		$endDate = $voucher->travel_to_date;
		$user = auth()->user();
		
		$activity = Activity::where('id', $activity_id)->select('entry_type','sic_TFRS','pvt_TFRS','zones','transfer_plan','vat')->first();
		$avat = 0;
		if($activity->vat > 0){
		$avat = $activity->vat;	
		}
		
		$query = ActivityPrices::where('activity_id', $activity_id)->where('rate_valid_from', '<=', $startDate)->where('rate_valid_to', '>=', $endDate)->where('u_code', $u_code);
		if($user->role_id == '3'){
			$query->where('for_backend_only', '0');
		}
		if($vat_invoice == 1){
			$ap = $query->select('adult_rate_without_vat', 'variant_code','chield_rate_without_vat','infant_rate_without_vat')
    ->first();
	if(isset($ap->variant_code)){
	$adultPrice = $ap->adult_rate_without_vat;
	$childPrice = $ap->chield_rate_without_vat;
	$infPrice = $ap->infant_rate_without_vat;
	}
	
	
	} else {
	$ap = $query->select('adult_rate_with_vat', 'variant_code','chield_rate_with_vat','infant_rate_with_vat')
    ->first();
	
	if(isset($ap->adult_rate_with_vat)){
	$adultPrice = $ap->adult_rate_with_vat ;
	$childPrice = $ap->chield_rate_with_vat;
	$infPrice = $ap->infant_rate_with_vat;
	}
	}
	
	$adultPriceTotal  = $adultPrice * $adult;
	$childPriceTotal  = $childPrice * $child;
	$infentPriceTotal  = $infPrice * $infent;
	$adult_total_rate = $adultPriceTotal + $childPriceTotal;
	$adult_total_rate = ($adult_total_rate > 0)?$adult_total_rate:0;
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
					  $zonePrice = $actZone[0]['zoneValue'] * $totalmember;
				 }
			}
			if($activity->pvt_TFRS==1){
					$td = TransferData::where('transfer_id', $activity->transfer_plan)->where('qty', $totalmember)->first();
					if(!empty($td))
					{
					 $transferPrice = $td->price * $totalmember ;
					}
			}
			
			
			$markupPriceT  = ($adult_total_rate * $markup['ticket_only'])/100;
			$ticketPrice = $adult_total_rate + $markupPriceT + $infentPriceTotal;
			if($transfer_option == 'Ticket Only'){
				$totalPrice = $ticketPrice;
			} else {
			if($transfer_option == 'Shared Transfer'){
				$markupPriceS  = ($zonePrice * $markup['sic_transfer'])/100;
				$totalPrice =  $ticketPrice + $markupPriceS + $zonePrice;
			}elseif($transfer_option == 'Pvt Transfer'){
				$markupPriceP  = ($transferPrice * $markup['pvt_transfer'])/100;
				$pvtTrafValWithMarkup = $markupPriceP + $transferPrice;
				  $totalPrice = $ticketPrice + $markupPriceP +  $transferPrice;
			}
			}
			
		
		$grandTotal = $totalPrice;
		if($vat_invoice == 1){
		$vatPrice = (($avat/100) * $grandTotal);
		}
		
		$total = round(($grandTotal+$vatPrice - $discount),2);
		$data = [
		'adultPrice' =>$adultPrice,
		'childPrice' =>$childPrice,
		'infPrice' =>$infPrice,
		'totalprice' =>$total,
		'activity_vat' =>$avat,
		'pvt_traf_val_with_markup' =>$pvtTrafValWithMarkup,
		'zonevalprice_without_markup' =>$zonePrice,
		'markup_p_ticket_only' =>$markup['ticket_only'],
		'markup_p_sic_transfer' =>$markup['sic_transfer'],
		'markup_p_pvt_transfer' =>$markup['pvt_transfer'],
		];
		
		return $data;
		
    }
	
	public function dateDiffInDays($date1, $date2) 
	{
		$diff = strtotime($date2) - strtotime($date1);
		$days =  (abs(round($diff / 86400)))+1;
		return $days;
	}
	
	
	public function voucherActivityLog($vid,$vaid,$discount,$priceTotal,$voucherstatus)
    {
		$data = [
			'voucher_id'=>$vid,
			'voucher_activity_id'=>$vaid,
			'discount'=>$discount,
			'priceTotal'=>$priceTotal,
			'voucher_status'=>$voucherstatus,
			'created_by'=> auth()->user()->id,
		];
		
		$voucherActivity = VoucherActivityLog::create($data);
		
		return $voucherActivity;
    }
	
}
