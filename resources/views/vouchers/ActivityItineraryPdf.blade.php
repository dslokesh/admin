<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Itinerary</title>
  <!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<!-- font-family: 'Poppins', sans-serif; -->
<body style="margin:0 auto; font-family: 'Inter', sans-serif; ">
	<div style="width: 780px; margin: 0 auto;  border: solid 1px #f1f1f1; padding: 40px; clear:both;">
		<div class="width:100%; padding: 10px 0px;margin-bottom:20px">
			<div style="width: 35%;float: left;">
				<span style="display: block;font-size: 28px;">
				<b>{{($voucher->guest_name)?$voucher->guest_name:''}}</b>Trip to
				<span style="display:block;font-size: 66px;font-weight: bold;color: #1732bb;font-family: initial;">Dubai</span>
			</div>
			<div style="width: 35%;float: right;text-align: right;">
				@if(file_exists(public_path('uploads/users/thumb/'.$voucher->agent->image)) && !empty($voucher->agent->image))
					<img src="{{asset('uploads/users/thumb/'.$voucher->agent->image)}}" style="max-width: 150px;width: 120px;height: 120px">
				@else
				{{-- Code to show a placeholder or alternate image --}}
					<img src="{{ asset('uploads/users/thumb/no-image.png') }}" style="max-width: 150px;width: 120px;height: 120px" alt="no-image">
				@endif
			</div>
		</div>
		<div style="width:90%;margin:20px auto;">
			<img src="{{asset('images/2.jpg')}}" style="width: 100%;border-radius: 30px">
		</div>
		<div class="width:100%; padding: 10px 0px;margin-bottom:20px;clear:both;">
			<div style="width: 60%;float: left;">
				<p style="margin-bottom: 0">Start Date:{{date("d-m-Y",strtotime($voucher->travel_from_date))}}</p>
				<p style="margin-top: 5px">End Date:{{date("d-m-Y",strtotime($voucher->travel_to_date))}}</p>
			</div>
			<div style="width: 40%;float: right;text-align: left;">
				<p style="margin-bottom: 0">Quote ID: {{$voucher->code}}</p>
				<p style="margin-top: 5px;font-weight: bold"></p>
			</div>
		</div>
		<div style="width:100%; padding: 10px 0px;margin-bottom:20px;clear:both;">
			
			<div>
				<img src="{{asset('images/2.jpg')}}" style="max-width: 40px" />
				<span style="font-size: 20px;font-weight: 600">Inclusions</span>
			</div>
				
			<ul style="padding-left: 20px; margin-bottom: 30px">
				@if(!empty($voucherActivity))
					@foreach($voucherActivity as $k => $ap1)
						<li style="">{{$ap1->variant_name}}</li>
					@endforeach
					@endif
				@if($voucher->is_flight =='1')
				<li style="">Meet & greet at arrival</li>
				@endif
			</ul>
		</div>
		<div class="width:95%; padding: 10px 0px;margin-bottom:20px;clear:both;">
			<div style="background: #2300c1; border-radius: 30px; border: dashed 3px #f1f1f1; display: block; align-items: center;clear:both;max-height:170px;height:auto;min-height: 130px;">
				<div style="width:60%;float:left;background: #CFC7F1;border-radius: 30px;border: dashed 3px #f1f1f1;padding:20px;margin-top:-3px; margin-bottom: -3px; margin-left: -3px;min-height: 130px;max-height:170px;height:auto;display: block;">
					<h6 style="margin:0  0 15px 0 !important; font-weight: 700;font-size: 18px">Adult : AED {{$dataArray['adultP']}} X {{$dataArray['adult']}}</h6>
					@if($dataArray['child'] > 0)
      				<h6 style="margin:0  0 15px 0 !important; font-weight: 700;font-size: 18px">Child : AED {{$dataArray['childP']}} X {{$dataArray['child']}} </h6>
					@endif
      				@if($dataArray['infant'] > 0)
      				<h6 style="margin:0  0 15px 0 !important; font-weight: 700;font-size: 18px">Infant : AED {{$dataArray['infantP']}}</h6>
					@endif
      				<p style="font-size: 13px;margin-bottom: 0">Note: All above prices are subject to change without prior notice as per availability, the final date of travel and any changes in taxes.</p>
				</div>
				<div style="width:30%;float:right;text-align: center;">
					<h4 style="color: #fff;font-size: 32px;font-weight: 600; margin-bottom: 5px">AED {{$dataArray['totalPrice']}}</h4>
      				<h6 style="font-size: 22px;color: #fff;margin-top: 0;">Total</h6>
				</div>
				<div style="width:100%;clear:both;"></div>
			</div>
		</div>
	</div>
	<div style = "display:block; clear:both; page-break-after:always;"></div>


	@if(!empty($voucherHotel))
	<!-- Hotel Block Start -->
	<div style="width: 780px; margin: 0 auto;  border: solid 1px #f1f1f1; padding: 40px; clear:both;">
		<div class="width:100%; padding: 10px 0px;margin-bottom:20px">
			<div style="width: 35%;float: left;">
				<span style="display: block;font-size: 28px;">
				<b>{{($voucher->guest_name)?$voucher->guest_name:''}}</b>Trip to
				<span style="display:block;font-size: 66px;font-weight: bold;color: #1732bb;font-family: initial;">Dubai</span>
			</div>
			<div style="width: 35%;float: right;text-align: right;">
				@if(file_exists(public_path('uploads/users/thumb/'.$voucher->agent->image)) && !empty($voucher->agent->image))
					<img src="{{asset('uploads/users/thumb/'.$voucher->agent->image)}}" style="max-width: 150px;width: 120px;height: 120px">
				@else
				{{-- Code to show a placeholder or alternate image --}}
					<img src="{{ asset('uploads/users/thumb/no-image.png') }}" style="max-width: 150px;width: 120px;height: 120px" alt="no-image">
				@endif
			</div>
		</div>
		<div class="width:100%; padding: 10px 0px;margin-bottom:20px;clear:both;">
			<div style="width: 60%;float: left;">
				<p style="margin-bottom: 0">Start Date:{{date("d-m-Y",strtotime($voucher->travel_from_date))}}</p>
				<p style="margin-top: 5px">End Date:{{date("d-m-Y",strtotime($voucher->travel_to_date))}}</p>
			</div>
			<div style="width: 40%;float: right;text-align: left;">
				<p style="margin-bottom: 0">Quote ID: {{$voucher->code}}</p>
				<p style="margin-top: 5px;font-weight: bold"></p>
			</div>
		</div>
		<div style="width:100%; padding: 10px 0px;margin-bottom:20px;clear:both;">
		
			@foreach($voucherHotel as $vh)
      		<div style="padding-top: 30px;display: block;">
      			<div style="min-width:220px;width: 220px; height: 220px; border-radius: 30px; border: solid 5px #0096e0; overflow: hidden;float:left;">
					@if(file_exists(public_path('uploads/hotels/'.$vh->hotel->image))  && !empty($vh->hotel->image))
					<img src="{{asset('uploads/hotels/'.$vh->hotel->image)}}" alt="" style="width:100%;max-width: 100%; height: 100%">
					@else
					{{-- Code to show a placeholder or alternate image --}}
					<img src="{{ asset('uploads/hotels/thumb/no-image.png') }}" style="max-width: 150px;width: 120px;height: 120px" alt="no-image">
					@endif
	
      				
      			</div>
      			<div style="padding-left: 15px;width: 500px; float:right;">
      				<span style="display: block; align-items: center;width:100%;">
      					<h5 style="margin: 0;font-size:16px;float:left;">{{$vh->hotel->name}}</h5> 
      					<span style="padding-left: 10px;"><!-- <img src="{{asset('images/6.png')}}"> -->{{$vh->hotel->hotelcategory->name}}</span>
      				</span>
      				<span style="display: block; align-items: center; gap: 10px; padding-top: 10px;width:100%;">
      					<img src="{{asset('images/7.png')}}" alt="" style="width: 18px;float:left;"> 
						{{$vh->hotel->address}},{{($vh->hotel->city)?$vh->hotel->city->name:''}},{{($vh->hotel->state)?$vh->hotel->state->name:''}},{{($vh->hotel->country)?$vh->hotel->country->name:''}}
      					
      				</span>
      				<div style="max-width: 350px; padding-top: 15px; display: flex;">
      					<span>
      						<span style="color: #ccc;">Check in :</span>
      						<p style="color: #121212; margin-top: 5px; margin-bottom: 0; font-weight: 500">{{date("d M- Y",strtotime($vh->check_in_date))}}</p>
      					</span>
      					<span style="margin-left: auto;">
      						<span style="color: #ccc;">Check out :</span>
      						<p style="color: #121212; margin-top: 5px; margin-bottom: 0; font-weight: 500">{{date("d M- Y",strtotime($vh->check_out_date))}}</p>
      					</span>
      				</div>
      				<div style="padding-top: 10px">
					@php
					$room = SiteHelpers::hotelRoomsDetails($vh->hotel_other_details)
					@endphp
      					<span style="font-size: 16px; display: block; margin-top: 5px">Room Type:{{$room['room_type']}}</span>
      					<span style="font-size: 16px; display: block; margin-top: 5px">Number of Rooms :{{$room['number_of_rooms']}}</span>
      					
      					<span style="font-size: 16px; display: block; margin-top: 5px">Occupancy :{{$room['occupancy']}}</span>
      				</div>
      			</div>
      		</div>
			@endforeach
			
			
		</div>
		
	</div>
	<div style = "display:block; clear:both; page-break-after:always;"></div>
	<!-- Hotel Block End -->
	@endif	



	
	@if(!empty($voucherActivity))
	<!-- Activity Block Start -->
	<div style="width: 780px; margin: 0 auto;  border: solid 1px #f1f1f1; padding: 40px; clear:both;">
		<div style="width:100%; padding: 10px 0px;margin-bottom:20px;clear:both;">
		
		@foreach($voucherActivity as $k => $ap)
		@php
					$activity = SiteHelpers::getActivity($ap->activity_id);
					$pickup_time = SiteHelpers::getPickupTimeByZone($activity->zones,$ap->transfer_zone);
					@endphp

      		<div style="background: #ddd; border-radius: 15px;margin-bottom: 30px;">
	      		<div style="background:#dcedf7; padding: 15px; border-radius: 15px;width:96.16%;">
	      			<div style="width: 170px; height: 150px; border-radius: 30px; border: solid 5px #0096e0; overflow: hidden;float:left;">
			@if(file_exists(public_path('uploads/activities/'.$activity->image)) && !empty($activity->image))
			<img src="{{asset('uploads/activities/'.$activity->image)}}" alt="" style="width:100%;max-width: 100%; height: 100%">
			@else
			{{-- Code to show a placeholder or alternate image --}}
			<img src="{{ asset('uploads/activities/thumb/no-image.png') }}" alt="" style="width:100%;max-width: 100%; height: 100%"  alt="no-image">
			@endif
	      			</div>
	      			<div style="width: 530px;float:right;padding-left: 15px">
	      				<div style="display: block;">
	      					<h5 style="margin:0 ">Day {{$k+1}} : {{$activity->title}} - {{$ap->variant_name}}</h5>
	      					<h5  style="margin-left: auto !important; margin:0">{{date("d M- Y",strtotime($ap->tour_date))}}</h5>
	      				</div>
	      				<div style="height: 155px;overflow:hidden;text-align:jutify;"> {!!$activity->description!!}</div>
	      			</div>
					<div style="width:100%;clear:both;"></div>
	      		</div>
	      		<div style="padding: 30px;display: block;width:100%;">
	      			<span style="width: 45%;float:left;">
			  			<span style="margin:0"><b>Transfer Type </b>: {{$ap->transfer_option}}</span>
			  			<span style="display: block;padding-top: 6px">Adult : {{$ap->adult}} @if($ap->child > 0) | Child : {{$ap->child}} @endif @if($ap->infant > 0) | Infant : {{$ap->infant}}@endif</span>
			  		</span>
					@if($ap->transfer_option == 'Shared Transfer')
						<span style="margin-left: auto;width: 45%;float:left;">
			  			<p style="margin: 0; font-weight: 600">Pick Up Timings : {{$pickup_time}}</p>
			  		</span>
					@endif
					<div style="clear:both;"></div>
			  		
	      		</div>
	      	</div>
			@endforeach
			
			
		</div>
		
	</div>
	<div style = "display:block; clear:both; page-break-after:always;"></div>
	<!-- Activity Block End -->
	@endif	
	<div style="width: 780px; margin: 0 auto;  border: solid 1px #f1f1f1; padding: 40px; clear:both;">
		<div class="width:100%; padding: 10px 0px;margin-bottom:20px">
			<div style="width: 35%;float: left;">
				<span style="display: block;font-size: 28px;">
				<b>{{($voucher->guest_name)?$voucher->guest_name:''}}</b>Trip to
				<span style="display:block;font-size: 66px;font-weight: bold;color: #1732bb;font-family: initial;">Dubai</span>
			</div>
			<div style="width: 35%;float: right;text-align: right;">
				@if(file_exists(public_path('uploads/users/thumb/'.$voucher->agent->image)) && !empty($voucher->agent->image))
					<img src="{{asset('uploads/users/thumb/'.$voucher->agent->image)}}" style="max-width: 150px;width: 120px;height: 120px">
				@else
				{{-- Code to show a placeholder or alternate image --}}
					<img src="{{ asset('uploads/users/thumb/no-image.png') }}" style="max-width: 150px;width: 120px;height: 120px" alt="no-image">
				@endif
			</div>
		</div>
		
		<div class="width:100%; padding: 10px 0px;margin-bottom:20px;clear:both;">
			<div style="width: 60%;float: left;">
				<p style="margin-bottom: 0">Start Date:{{date("d-m-Y",strtotime($voucher->travel_from_date))}}</p>
				<p style="margin-top: 5px">End Date:{{date("d-m-Y",strtotime($voucher->travel_to_date))}}</p>
			</div>
			<div style="width: 40%;float: right;text-align: left;">
				<p style="margin-bottom: 0">Quote ID: {{$voucher->code}}</p>
				<p style="margin-top: 5px;font-weight: bold"></p>
			</div>
		</div>
		<div style="width:100%; padding: 10px 0px;margin-bottom:20px;clear:both;">
			
			<div>
				<img src="{{asset('images/2.jpg')}}" style="max-width: 40px" />
				<span style="font-size: 20px;font-weight: 600">Inclusions</span>
			</div>
				
			<ul style="padding-left: 20px; margin-bottom: 30px">
					<li style="">After the confirmation of the booking below conditions are applicable</li>
		<li style="">Transfer options are made available for the Tour if the With Transfer option is been selected at the time of Booking.</li>
		<li style="">All entrance tickets are non - refundable.</li>
		<li style="">Any amendments to the tour date have to be informed to the agent via email.</li>
		<li style="">Amendment(s) are subject to the Cancellation policy.</li>
		<li style="">Agent reserves the right to reject/cancel the amendment request from you.</li>
		<li style="">Any entry tickets for any show/event/ museum/ amusement park or whatsoever are Non- Cancellable & cannot be refunded under any circumstances. There will be no refund for unused or partially used services.</li>
		<li style="">There is certain waiting time for the Guests to Pick up. If in case the Guests fail to turn on time it will be a No Show and there would be No Refund or Rescheduling. Refer to individual Tour Voucher for pickup time, Cancellation policy.</li>
		<li style="">Pick Up time advised are tentative and the exact timings will be notified a day prior.</li>
		<li style="">Shared Transfers waiting time is 5 minutes and Private transfers waiting time is 15 minutes</li>
			</ul>
		</div>
		
	</div>

</body>

</html>