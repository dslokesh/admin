@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Voucher Details</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('vouchers.index') }}">Vouchers</a></li>
              <li class="breadcrumb-item active">Voucher Details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    
        <div class="col-md-12">
		<div class="card card-primary card-outline card-tabs">
		<div class="card card-primary card-outline card-tabs">
			<div class="card-header p-0 pt-1 border-bottom-0">
			<ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
			<li class="nav-item">
			<a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Voucher Details</a>
			</li>
			@if($voucher->is_hotel == 1)
			<li class="nav-item">
			<a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Hotel Details</a>
			</li>
			@endif
			@if($voucher->is_activity == 1)
			<li class="nav-item">
			<a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill" href="#custom-tabs-three-messages" role="tab" aria-controls="custom-tabs-three-messages" aria-selected="false">Activity Details</a>
			</li>
		@endif
			</ul>
			</div>
		 </div>
       
	   
	   <div class="card-body">
		<div class="tab-content" id="custom-tabs-three-tabContent">
			<div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
			<header class="profile-header">
				
				<div class="profile-content">
					<div class="row">
					<div class="col-lg-12">
				<h5>Voucher Details</h5>
				</div>
				
               <div class="col-lg-6 mb-3">
                <label for="inputName">Agency Name:</label>
				@if(isset($voucher->agent))
               {{ $voucher->agent->full_name }} </br>
			   <b>Code:</b>{{$voucher->agent->code}} <b> Email:</b>{{$voucher->agent->email}} <b>Mobile No:</b>{{$voucher->agent->mobile}} <b>Address:</b>{{$voucher->agent->address. " ".$voucher->agent->postcode;}}
			   
			   @endif
              </div>
			 
			      <div class="col-lg-6 mb-3">
                <label for="inputName">Customer Name:</label>
				@if(isset($voucher->customer))
                {{ $voucher->customer->name }} </br>
				<b>Email:</b>{{$voucher->customer->email}} <b>Mobile No:</b>{{$voucher->customer->mobile}} <b>Address:</b>{{$voucher->customer->address. " ".$voucher->customer->zip_code;}}
				@endif
              </div>
			   <div class="form-group col-lg-6 mb-3">
                <label for="inputName">Voucher Code:</label>
                {{ $voucher->code }}
              </div>
			  <div class="form-group col-lg-6 mb-3">
                <label for="inputName">Country:</label>
                {{($voucher->country)?$voucher->country->name:''}}
              </div>
              <div class="form-group col-lg-6 mb-3">
			        <label for="inputName">Status:</label>
					{!! SiteHelpers::statusColor($voucher->status) !!}
              </div>
              <div class="col-lg-2 mb-3">
                <label for="inputName">Travel Date From:</label>
				{{ $voucher->travel_from_date ? date(config('app.date_format'),strtotime($voucher->travel_from_date)) : null }}
              </div>
			  <div class="col-lg-2 mb-3">
                <label for="inputName">Number Of Night:</label>
				{{ $voucher->nof_night  }}
              </div>
			   <div class="col-lg-2 mb-3">
                <label for="inputName">Travel Date To:</label>
				{{ $voucher->travel_to_date ? date(config('app.date_format'),strtotime($voucher->travel_to_date)) : null }}
              </div>
            
			  @if($voucher->is_flight == 1)
			  <div class="col-lg-3 mb-3">
                <label for="inputName">Arrival Airline:</label>
                {{ ($voucher->arrivalairline)?$voucher->arrivalairline->name:'' }}
              </div>
			  <div class="col-lg-3 mb-3">
                <label for="inputName">Arrival Date:</label>
				{{ $voucher->arrival_date ? date(config('app.date_format'),strtotime($voucher->arrival_date)) : null }}
              </div>
			 
			  <div class="col-lg-3 mb-3">
                <label for="inputName">Arrival Airport:</label>
                {{ $voucher->arrival_airport }}
              </div>
			   <div class="col-lg-3 mb-3">
                <label for="inputName">Arrival Terminal:</label>
                {{ $voucher->arrival_terminal }}
              </div>
			 
			 
			  <div class="col-lg-3 mb-3">
                <label for="inputName">Depature Airline:</label>
				 {{ ($voucher->depatureairline)?$voucher->depatureairline->name:'' }}
              </div>
			  <div class="col-lg-3 mb-3">
                <label for="inputName">Depature Date:</label>
				{{ $voucher->depature_date ? date(config('app.date_format'),strtotime($voucher->depature_date)) : null }}
              </div>
			 
			  <div class="col-lg-3 mb-3">
                <label for="inputName">Depature Airport:</label>
                {{ $voucher->depature_airport }}
              </div>
			   <div class="col-lg-3 mb-3">
                <label for="inputName">Depature Terminal:</label>
                {{ $voucher->depature_terminal }}
              </div>
			  @endif
              
            
          </div>
		  
				
				</div>
         
				</header>
			
			</div>
			
			<div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
			<div class="row p-2">
			<div class="col-lg-12">
				<h5>Hotel Details</h5>
				
				</div>
				</div>
			@if(!empty($voucherHotel) && $voucher->is_hotel == 1)
				@foreach($voucherHotel as $vh)
			 <div id="hDetailsDiv" class="bg-row ">
			 
				 <div class="row p-2">
				
				<div class="form-group col-md-12 mt-3">
				<form id="delete-form-{{$vh->id}}" method="post" action="{{route('voucher.hotel.delete',$vh->id)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <a class="btn btn-danger btn-sm float-right" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this hotel and details?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$vh->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            ">Remove <i class="fas fa-trash"></i></a>
							
			
			</div>
				<div class="col-md-12">
                <table class="table table-bordered">
                  <thead>
				   <tr>
				   <th>Image</th>
				   <th>Hotel Name</th>
				   <th>Check In Date</th>
				   <th>Check Out Date</th>
				   </tr>
				   </thead>
				   <tbody>
				   <tr>
				   <td width="10%"> @if(!empty($vh->hotel->image))<img src="{{asset('uploads/hotels/'.$vh->hotel->image)}}" width="100px" />@endif </td>
				   <td>{{$vh->hotel->name}}</td>
				   <td>{{$vh->check_in_date}}</td>
				   <td>{{$vh->check_out_date}}</td>
				   </tr>
				   </tbody>
				  </table>
				</div>
				 @php
				 $hotelData = json_decode($vh->hotel_other_details);
				
				 @endphp
				  </div>
				  @foreach($hotelData as $k => $hd)
				<div class="row p-2">
			 <div class="col-lg-12">
				<h5><b>Room Details : {{$k+1}}</b></h5>
				</div>
			  <div class="col-md-12">
                <table class="table table-bordered">
                  <thead>
				   <tr>
                    <th>Room Type</th>
					<th>
					{{$hd->room_type}}</th>
					<th colspan="4"></th>
                  </tr>
				   <tr>
                    <th>Number of Rooms</th>
					<th >{{$hd->nom_of_room}}</th>
					<th colspan="4"></th>
                  </tr>
                  <tr>
					<th></th>
                    <th>Single</th>
					<th>Double</th>
					<th>Extra Bed</th>
                    <th>CWB</th>
                    <th>CNB</th>
                  </tr>
				   <tr>
                    <th>Number of Pax</th>
					<td>{{$hd->nop_s}}</td>
					<td>{{$hd->nop_d}}</td>
					<td>{{$hd->nop_eb}}</td>
					<td>{{$hd->nop_cwb}}</td>
					<td>{{$hd->nop_cnb}}</td>
                  </tr>
				   <tr>
                    <th>Net Rate</th>
					<td>{{$hd->nr_s}}</td>
					<td>{{$hd->nr_d}}</td>
					<td>{{$hd->nr_eb}}</td>
					<td>{{$hd->nr_cwb}}</td>
					<td>{{$hd->nr_cnb}}</td>
                  </tr>
					<tr>
                    <th>Per Pax to be autocalculated</th>
					<td>{{$hd->ppa_s}}</td>
					<td>{{$hd->ppa_d}}</td>
					<td>{{$hd->ppa_eb}}</td>
					<td>{{$hd->ppa_cwb}}</td>
					<td>{{$hd->ppa_cnb}}</td>
                  </tr>
				  <tr>
                    <th>Mark Up in </th>
					<td>{{$hd->markup_p_s}}%</td>
					<td>{{$hd->markup_p_d}}%</td>
					<td>{{$hd->markup_p_eb}}%</td>
					<td>{{$hd->markup_p_cwb}}%</td>
					<td>{{$hd->markup_p_cnb}}%</td>
                  </tr>
				  <tr>
                    <th>Mark up Value</th>
					<td>{{$hd->markup_v_s}}</td>
					<td>{{$hd->markup_v_d}}</td>
					<td>{{$hd->markup_v_eb}}</td>
					<td>{{$hd->markup_v_cwb}}</td>
					<td>{{$hd->markup_v_cnb}}</td>
                  </tr>
				 
				  </table>
              </div>
			 </div>	
			 @endforeach
			 </div>	
			  @endforeach
			  @endif
			
			</div>
			<div class="tab-pane fade" id="custom-tabs-three-messages" role="tabpanel" aria-labelledby="custom-tabs-three-messages-tab">
			@if(!empty($voucherActivity) && $voucher->is_activity == 1)
				<div class="row p-2">
			 
			  <div class="col-md-12">
                <table class="table table-bordered">
                  <thead>
				   @if(!empty($voucherActivity))
					  @foreach($voucherActivity as $ap)
                  <tr>
					<th>Tour Option</th>
                    <th>Transfer Option</th>
					<th>Tour Date</th>
					<th>Adult</th>
                    <th>Child</th>
                    <th>Infant</th>
					<th>Net Discount</th>
					<th>Total Amount</th>
					<th></th>
                  </tr>
				 
					@php
					$activity = SiteHelpers::getActivity($ap->activity_id);
					@endphp
				   <tr>
                    <td>{{$activity->title}} - {{$ap->variant_name}} - {{$ap->variant_code}}</td>
					<td>{{$ap->transfer_option}}
					@if($ap->transfer_option == 'Shared Transfer')
						@php
					$zone = SiteHelpers::getZoneName($ap->transfer_zone);
					@endphp
						- <b>Zone :</b> {{$zone->name}}
					@endif
					</td>
					<td>{{$ap->tour_date}}</td>
					<td>{{$ap->adult}}</td>
                    <td>{{$ap->child}}</td>
                    <td>{{$ap->infant}}</td>
					<td>{{$ap->discountPrice}}</td>
					<td>{{$ap->totalprice}}</td>
					<td>
					
						   <form id="delete-form-{{$ap->id}}" method="post" action="{{route('voucher.activity.delete',$ap->id)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$ap->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            "><i class="fas fa-trash"></i></a>
                         </td>
                  </tr>
				  @endforeach
				 @endif
				  </table>
              </div>
			 </div>	
		@endif
			</div>

		</div>
</div>

      </div>
  
    </section>
    <!-- /.content -->
@endsection



@section('scripts')


@endsection