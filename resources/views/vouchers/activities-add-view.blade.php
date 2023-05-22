@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Voucher Code :{{$voucher->code}} , Activity : {{ $activity->title }} </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
			 <li class="breadcrumb-item"><a href="{{ route('vouchers.index') }}">Vouchers</a></li>
              <li class="breadcrumb-item"><a href="{{ route('voucher.add.activity',[$voucher->id]) }}">Activities</a></li>
              <li class="breadcrumb-item active">Activity Details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-md-12">
		
          <div class="card">
           
			
			<div class="card-body">
			
			
			<header class="profile-header">
          <div class="profile-image" style="border-radius:0px;height:auto;"> @if(!empty($activity->image))<img src="{{asset('uploads/activities/'.$activity->image)}}"  />@endif </div>
				<div class="profile-content">
				
					<div class="row">
              
			      <div class="col-lg-4 mb-3">
                <label for="inputName">Name:</label>
                {{$activity->title}}
              </div>
			  <div class="col-lg-4 mb-3">
                <label for="inputName">Code:</label>
                {{$activity->code}}
              </div>
			   <div class="col-lg-4 mb-3">
                <label for="inputName">Type of Activity:</label>
                {{ $typeActivities[$activity->type_activity]}}
              </div>
			  <div class="col-lg-4 mb-3">
                <label for="inputName">Entry Type:</label>
               {{ $activity->entry_type }}
              </div>
			  
			  <div class="col-lg-4 mb-3">
                <label for="inputName">Priror Booking Time:</label>
               {{ $activity->priror_booking_time }}
              </div>
              
			  @if($activity->is_opendated)
			  <div class="col-lg-4 mb-3">
                <label for="inputName">Valid Till (in Days from Date of Booking):</label>
               {{ $activity->valid_till }}
              </div>
			  @endif
			<div class="col-lg-12 mb-3">
                <label for="inputName">Availability:</label>
               @if($activity->availability=='All')
				   All Days
			   @else
			   {{$activity->availability}}
			   @endif
              </div>
			
          </div>	
		  
				</div>
          
			
				</header>
				@if(auth()->user()->role_id != 3)
				<div class="form-group col-lg-12 mb-3">
				
					 <table id="example1" class="table table-bordered ">
                  <thead>
				  <tr>
                    <th colspan="2" ><h3>Agent Markup</h3></th>
                  </tr>
                  <tr>
					<th>Price</th>
                  </tr>
                  </thead>
                  <tbody>
				   
                  @foreach ($markups as $activityName => $record)
                  <tr>
					
                   
					<td>
						<table class="table table-bordered table-striped">
						<tr>
							<th>Variant Code</th>
							<th>Ticket Only</th>
							<th>SIC Transfer</th>
							<th>PVT Transfer</th>
						</tr>
						@foreach($record as $variant_code => $variant)
						@php
						$ticket_only = (isset($variant['ticket_only']))?$variant['ticket_only']:'';
						$sic_transfer = (isset($variant['sic_transfer']))?$variant['sic_transfer']:'';
						$pvt_transfer = (isset($variant['pvt_transfer']))?$variant['pvt_transfer']:'';
						
						@endphp
						<tr>
						<td>{{ $variant_code }}</td>
						<td>
						{{$ticket_only}}%
						</td>
						<td>
						{{$sic_transfer}}%
						</td>
						<td>
						{{$pvt_transfer}}%
						</td>
						</tr>
						@endforeach
						</table>
					</td>
                  </tr>
				 
                  @endforeach

                  </tbody>
                 
                </table>
				</div>
				@endif
				<form action="{{route('voucher.hotel.save')}}" method="post" class="form" enctype="multipart/form-data">
				{{ csrf_field() }}
				 <input type="hidden" id="activity_id" name="activity_id" value="{{ $aid }}"  />
				 <input type="hidden" id="v_id" name="v_id" value="{{ $vid }}"  />
				<div class="row p-2">
				<div class="col-lg-12">
				<h3>Activity Details</h3>
				</div>
				
				  </div>
				<div id="hDetailsDiv">
				<div class="row p-2">
			 
			  <div class="col-md-12">
                <table class="table table-bordered">
                  <thead>
				  
                  <tr>
					<th>Tour Option</th>
                    <th>Transfer Option</th>
					<th>Tour Date</th>
					<th>Adult</th>
                    <th>Child(3-10Yrs)</th>
                    <th>Infant</th>
					<th>Total Amount</th>
                  </tr>
				  @if(!empty($activityPrices))
					  @foreach($activityPrices as $kk => $ap)
				   <tr>
                    <th><input type="checkbox"  name="activity_select[]" id="activity_select{{$kk}}" /> {{$ap->variant_name}} - {{$ap->variant_code}}</th>
					<td> <select name="transfer_option[]" id="transfer_option{{$kk}}" class="form-control">
						<option value="">--select--</option>
						@if($activity->entry_type=='Activity')
						<option value="">Without Transfer</option>
						@endif
						@if($activity->sic_TFRS==1)
						<option value="">Shared Transfer</option>
						@endif
						@if($activity->pvt_TFRS==1)
						<option value="">Pvt Transfer</option>
						@endif
						</select>
					</td>
					<td><input type="text" id="tour_date{{$kk}}"  name="tour_date[]"  class="form-control datepicker"   /></td>
					<td><select name="adult[]" id="adult{{$kk}}" class="form-control priceChange" data-inputnumber="{{$kk}}">
						
						@for($a=$ap->adult_min_no_allowed; $a<=$ap->adult_max_no_allowed; $a++)
						<option value="{{$a}}">{{$a}}</option>
						@endfor
						</select></td>
                    <td><select name="child[]" id="child{{$kk}}" class="form-control priceChange" data-inputnumber="{{$kk}}">
						@for($child=$ap->chield_min_no_allowed; $child<=$ap->chield_max_no_allowed; $child++)
						<option value="{{$child}}">{{$child}}</option>
						@endfor
						</select></td>
                    <td><select name="infant[]" id="infant{{$kk}}" class="form-control priceChange" data-inputnumber="{{$kk}}">
						@for($inf=$ap->infant_min_no_allowed; $inf<=$ap->infant_max_no_allowed; $inf++)
						<option value="{{$inf}}">{{$inf}}</option>
						@endfor
						</select></td>
						<td>
						@php
						$price = (($ap->adult_rate_with_vat*$ap->adult_min_no_allowed) + ($ap->chield_rate_with_vat*$ap->chield_min_no_allowed) + ($ap->infant_rate_with_vat*$ap->infant_min_no_allowed));
						@endphp
						<input type="hidden" value="{{$ap->adult_rate_with_vat}}" id="adultPrice{{$kk}}"  name="adultPrice[]"    />
						
						<input type="hidden" value="{{$ap->chield_rate_with_vat}}" id="childPrice{{$kk}}"  name="childPrice[]"    />
						<input type="hidden" value="{{$ap->infant_rate_with_vat}}" id="infPrice{{$kk}}"  name="infPrice[]"    />
						<span id="price{{$kk}}">{{$price}}</span>
						<input type="hidden" id="totalprice{{$kk}}" value="{{$price}}"  name="totalPrice[]"    />
						</td>
                  </tr>
				  @endforeach
				 @endif
				  </table>
              </div>
			 </div>	
			 </div>	
			  <div class="row">

        <div class="col-12 mt-3">
          <a href="{{ route('vouchers.index') }}" class="btn btn-secondary">Back To Vouchers</a>
		  
		   <a href="{{route('vouchers.show',$vid)}}" class="btn btn-secondary mr-2">View Vouchers</a>
          <button type="submit" class="btn btn-primary float-right" name="save">Save</button>
			<button type="submit" class="btn btn-success float-right mr-2" name="save_and_continue">Save & Add More Activity</button>
        </div>
      </div>
			 </form>
          <!-- /.card-body --> 
        </div>
		
          
			
          </div>
		 
          <!-- /.card -->
        </div>
      </div>
  
    </section>
    <!-- /.content -->
@endsection



@section('scripts')
 <script type="text/javascript">
 $(document).ready(function() {
	

$(document).on('change', '.priceChange', function(evt) {
	let inputnumber = $(this).data('inputnumber');
	let adult = $("body #adult"+inputnumber).val();
	let child = $("body #child"+inputnumber).val();
	let infant = $("body #infant"+inputnumber).val();
	
	let adultPrice = $("body #adultPrice"+inputnumber).val();
	let childPrice = $("body #childPrice"+inputnumber).val();
	let infPrice = $("body #infPrice"+inputnumber).val();
	var totalPrice = parseFloat((adult * adultPrice) + (child * childPrice) + (infant * infPrice));
	
	$("body #totalprice"+inputnumber).val(totalPrice.toFixed(2));
	$("body #price"+inputnumber).text(totalPrice.toFixed(2));
	
});

});



  </script>   
@endsection