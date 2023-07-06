@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Activity : {{ $activity->title }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('activities.index') }}">Activities</a></li>
              <li class="breadcrumb-item active">Activity Details</li>
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
			<a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Activity</a>
			</li>
			@if($activity->sic_TFRS)
			<li class="nav-item">
			<a class="nav-link" id="custom-tabs-three-settings-tab" data-toggle="pill" href="#custom-tabs-three-settings" role="tab" aria-controls="custom-tabs-three-settings" aria-selected="false">Transfer Plan</a>
			</li>
			@endif
			<li class="nav-item">
			<a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Images</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill" href="#custom-tabs-three-messages" role="tab" aria-controls="custom-tabs-three-messages" aria-selected="false">Activity Prices</a>
			</li>
		
			</ul>
			</div>
		 </div>
       
	   
	   <div class="card-body">
		<div class="tab-content" id="custom-tabs-three-tabContent">
			<div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
				<header class="profile-header">
         
				<div class="profile-content">
				
					<div class="row">
              <div class="col-lg-12 mb-3">
				<h4>Activity Details</h4>
				 </div>
			     
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Code:</label>
                {{ $activity->code }}
              </div>
			
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Type of Activity:</label>
                {{ $typeActivities[$activity->type_activity]}}
              </div>
			 
			 <div class="col-lg-6 mb-3">
                <label for="inputName">Entry Type:</label>
               {{ $activity->entry_type }}
              </div>
			  
			  
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Vat:</label>
               {{ $activity->vat }}%
              </div>
			  
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Black Out/Sold Out Date:</label>
               {{ $activity->black_sold_out }}
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Is Open Dated:</label>
               {!! SiteHelpers::statusColorYesNo($activity->is_opendated) !!}
              </div>
			  @if($activity->is_opendated)
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Valid Till (in Days from Date of Booking):</label>
               {{ $activity->valid_till }}
              </div>
			  @endif
			  
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Pvt TFRS:</label>
               {!! SiteHelpers::statusColorYesNo($activity->pvt_TFRS) !!}
              </div>
			  @if($activity->pvt_TFRS)
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Transfer Plan:</label>
               {{ (!empty($activity->transfer))?$activity->transfer->name:'' }}
              </div>
			  @endif
			  
			   <div class="col-lg-6 mb-3">
                <label for="inputName">Availability:</label>
               @if($activity->availability=='All')
				   All Days
			   @else
			   {{$activity->availability}}
			   @endif
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">SIC TFRS:</label>
               {!! SiteHelpers::statusColorYesNo($activity->sic_TFRS) !!}
              </div>
			 
              <div class="form-group col-lg-12 mb-3">
                <label for="inputName">Description:</label>
                {!!$activity->description!!}
              </div>
             
			  <div class="form-group col-lg-12 mb-3">
                <label for="inputName">Inclusion:</label>
                {!!$activity->inclusion!!}
              </div>
			  
			   <div class="form-group col-lg-12 mb-3">
                <label for="inputName">Important Information:</label>
                {!!$activity->exclusion!!}
              </div>
			  
			   <div class="form-group col-lg-12 mb-3">
                <label for="inputName">Cancellation Policy:</label>
                {!!$activity->cancellation_policy!!}
              </div>
              <div class="form-group col-lg-6 mb-3">
			        <label for="inputName">Status:</label>
					{!! SiteHelpers::statusColor($activity->status) !!}
              </div>
			  
			 
            
          </div>	
				</div>
          
			
				</header>
			</div>
			@if($activity->sic_TFRS)
			<div class="tab-pane fade" id="custom-tabs-three-settings" role="tabpanel" aria-labelledby="custom-tabs-three-settings-tab">
			 <div class="col-lg-12 mb-3">
				<h4>Transfer Plan</h4>
				 </div>
			  <div class="col-lg-12 mb-3">
               <table id="myTable" class="table">
					  <tr>
						<th>Zone</th>
						<th>Value</th>
						<th>Pick Up Time</th>
						<th>Drop Up Time</th>
					  </tr>
					  @if(!empty($zoneArray))
						  @foreach($zoneArray as $k => $z)
					  <tr>
						<td>{{$z['zone']}} </td>
						<td>{{$z['zoneValue']}}</td>
						<td>{{$z['pickup_time']}} </td>
						<td>{{$z['dropup_time']}}</td>
					  </tr>
					  @endforeach
					@endif
					
					</table>
              </div>
			 
			</div>
			 @endif
			<div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
			 <div class="row">
			 <div class="col-md-6 mb-3">
				<h4>Featured Image</h4>
				 </div>
				 <div class="col-md-6 mb-3">
				<h4>Images</h4>
				 </div>
				  <div class="form-group col-md-6">
                 @if(!empty($activity->image))
               
                  <img src="{{asset('uploads/activities/thumb/'.$activity->image)}}"  class="cimage" />
                
				@endif
              </div>
			  
				 <div class="slider-outer col-md-6">
				 <div class="owl-theme owl-carousel">
                       @if($activity->images->count() > 0)
                           
                                
                                @foreach($activity->images as $image)
                                <div clss="item">
                              <img src="{{asset('uploads/activities/thumb/'.$image->filename)}}"  class="img-responsive">
                                </div>
                                @endforeach
                           
                            @endif 
                            </div>
				 </div>
			 </div>
			  
			
			</div>
			<div class="tab-pane fade" id="custom-tabs-three-messages" role="tabpanel" aria-labelledby="custom-tabs-three-messages-tab">
			 <div class="col-lg-12 mb-3">
				<h4>Activity Prices</h4>
				 </div>
				@php
			$rowCount = 1;
			@endphp
			
			@if(!empty($priceData))
			@foreach($priceData as $k => $pdata)
			
			<div class="bg-row row p-2">
			  <form id="delete-form-{{$pdata->u_code.$k}}" method="post" action="{{route('activity.activityPricesDelete',$pdata->u_code)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
			
			<div class="form-group col-md-12 mt-3">
			<a class="btn btn-danger btn-sm float-right remove-btn" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure Delete this price block?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$pdata->u_code.$k}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            "><i class="fas fa-trash"></i></a>
			
			</div>
			
			 <div class="col-lg-6 mb-3">
                <label for="inputName">Variant Name:</label>
               {{ $pdata->variant_name }}
              </div>
			  
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Variant Code:</label>
               {{ $pdata->variant_code }}
              </div>
			  
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Slot Duration:</label>
               {{ $pdata->slot_duration }}
              </div>
			  
			   <div class="col-lg-6 mb-3">
                <label for="inputName">Activity Duration:</label>
               {{ $pdata->activity_duration }}
              </div>
               
			    <div class="col-lg-6 mb-3">
                <label for="inputName">Start Time:</label>
               {{ $pdata->start_time }}
              </div>
			   <div class="col-lg-6 mb-3">
                <label for="inputName">End Time:</label>
               {{ $pdata->end_time }}
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Rate Valid From:</label>
				{{ $pdata->rate_valid_from ? date(config('app.date_format'),strtotime($pdata->rate_valid_from)) : null }}
              </div>
			  
			   <div class="col-lg-6 mb-3">
                <label for="inputName">Rate Valid To:</label>
				{{ $pdata->rate_valid_to ? date(config('app.date_format'),strtotime($pdata->rate_valid_to)) : null }}
              </div>
			 <div class="col-lg-6 mb-3">
                <label for="inputName">For Backend Only:</label>
              {!! SiteHelpers::statusColorYesNo($pdata->for_backend_only) !!}
              </div>
			 
			 
			  <div class="col-md-12">
                <table class="table table-bordered">
                  <thead>
                  <tr>
                    <th>Pax Type</th>
					<th>Rate Including VAT</th>
					<th>Rate (Without VAT)</th>
                    <th>Max No Allowed</th>
                    <th>Min No Allowed</th>
					<th>Start Age</th>
                    <th>End Age</th>
                  </tr>
				   <tr>
                    <td>Adult</td>
					<td>{{ $pdata->adult_rate_with_vat }}</td>
					<td>{{ $pdata->adult_rate_without_vat }}</td>
                    <td>{{ $pdata->adult_max_no_allowed }}</td>
                    <td>{{ $pdata->adult_min_no_allowed }}</td>
					<td>{{ $pdata->adult_start_age }}</td>
                    <td>{{ $pdata->adult_end_age }}</td>
                  </tr>
				  <tr>
                    <td>Child</td>
					<td>{{ $pdata->chield_rate_with_vat }}</td>
					<td>{{ $pdata->chield_rate_without_vat }}</td>
                    <td>{{ $pdata->chield_max_no_allowed }}</td>
                    <td>{{ $pdata->chield_min_no_allowed }}</td>
					<td>{{ $pdata->chield_start_age }}</td>
                    <td>{{ $pdata->chield_end_age }}</td>
                  </tr>
				   <tr>
                    <td>Infant</td>
					<td>{{ $pdata->infant_rate_with_vat }}</td>
					<td>{{ $pdata->infant_rate_without_vat }}</td>
                    <td>{{ $pdata->infant_max_no_allowed }}</td>
                    <td>{{ $pdata->infant_min_no_allowed }}</td>
					<td>{{ $pdata->infant_start_age }}</td>
                    <td>{{ $pdata->infant_end_age }}</td>
                  </tr>
				  </table>
              </div>
			   <div class="form-group col-md-12">
                <label for="inputName">Booking Cut off & Cancellation:</label>
               <table class="table table-bordered">
                  <thead>
                  <tr>
                    <th>Variant</th>
					<th>Booking Window Value</th>
					<th>Cancellation Value</th>
                   
                  </tr>
				   <tr>
                    <td>Ticket Only</td>
					<td>{{ $pdata->booking_window_valueto }}</td>
                    <td>{{ $pdata->cancellation_value_to }}</td>
                  </tr>
				  @if($activity->sic_TFRS==1)
				  <tr>
					@else
					<tr style="display:none">
					@endif
					
                    <td>Ticket with SIC TFR</td>
					<td>{{ $pdata->booking_window_valueSIC }}</td>
                    <td>{{ $pdata->cancellation_valueSIC }}</td>
                  </tr>
				   @if($activity->pvt_TFRS==1)
				  <tr>
					@else
					<tr style="display:none">
					@endif
                    <td>Ticket with PVT TFR</td>
					<td>{{ $pdata->booking_window_valuePVT }}</td>
                    <td>{{ $pdata->cancellation_valuePVT }}</td>
                  </tr>
				  </table>
              </div>
			  </div>
			  <hr/>
			  @php
			  $rowCount++;
			  @endphp
			  
			 @endforeach
			 @endif
			</div>

		</div>
</div>

      </div>
  
    </section>
    <!-- /.content -->
@endsection



@section('scripts')
<script type="text/javascript">
$(window).on('load', function(){
 var owl = $('.owl-carousel');
owl.owlCarousel({
    loop:true,
    nav:true,
	dots:false,
    margin:10,
	items:1
  
});

  
  
});


</script>
@endsection