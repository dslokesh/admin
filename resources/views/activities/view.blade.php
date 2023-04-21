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
    <div class="row">
        <div class="col-md-12">
		
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">{{ $activity->title }}</h3>
            </div>
			
			<div class="card-body">
			
			<header class="profile-header">
         
				<div class="profile-content">
					<div class="row">
              
			     
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
                <label for="inputName">Priror Booking Time:</label>
               {{ $activity->priror_booking_time }}
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
			  @if($activity->sic_TFRS)
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Transfer Plan:</label>
               <table id="myTable" class="table">
					  <tr>
						<th>Zone</th>
						<th>Value</th>
						
					  </tr>
					  @if(!empty($zoneArray))
						  @foreach($zoneArray as $k => $z)
					  <tr>
						<td>{{$z['zone']}} </td>
						<td>{{$z['zoneValue']}}</td>
					  </tr>
					  @endforeach
					@endif
					
					</table>
              </div>
			  @endif
              <div class="form-group col-lg-12 mb-3">
                <label for="inputName">Description:</label>
                {!!$activity->description!!}
              </div>
             
			  <div class="form-group col-lg-12 mb-3">
                <label for="inputName">Inclusion:</label>
                {!!$activity->inclusion!!}
              </div>
			  
			   <div class="form-group col-lg-12 mb-3">
                <label for="inputName">Exclusion:</label>
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
			  
			  <div class="form-group col-lg-12 mb-3">
                <label for="inputName">Featured Image:</label>
                 @if(!empty($activity->image))
               
                  <img src="{{asset('uploads/activities/thumb/'.$activity->image)}}" style="width:100px; height:100px;margin-top:-6px" class="cimage" />
                
				@endif
              </div>
			  
			@if($activity->images->count() > 0)
            <div class="form-group col-lg-12">
              <label for="featured_image" class="col-lg-2 control-label">Images</label>
              @foreach($activity->images as $image)
              
                <img src="{{asset('uploads/activities/thumb/'.$image->filename)}}" style="width:100px; height:100px;" class="img-responsive">
              
              @endforeach
            </div>
            @endif 
            
          </div>	
				</div>
          
			
				</header>
		 <div class="card-body">
		<div class="form-group col-md-12 mt-3">
			<h3>Activity Prices</h3>
			</div>
			@php
			$rowCount = 1;
			@endphp
			
			@if(!empty($priceData))
			@foreach($priceData as $k => $pdata)
			
			<div class="bg-row row p-2">
			
			
			
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
			 
			   
			  <div class="col-md-12">
                <table class="table table-bordered">
                  <thead>
                  <tr>
                    <th>Pax Type</th>
					<th>Rate Including VAT</th>
					<th>Rate (Without VAT)</th>
                    <th>Max No Allowed</th>
                    <th>Min No Allowed</th>
                  </tr>
				   <tr>
                    <td>Adult</td>
					<td>{{ $pdata->adult_rate_with_vat }}</td>
					<td>{{ $pdata->adult_rate_without_vat }}</td>
                    <td>{{ $pdata->adult_max_no_allowed }}</td>
                    <td>{{ $pdata->adult_min_no_allowed }}</td>
                  </tr>
				  <tr>
                    <td>Child</td>
					<td>{{ $pdata->chield_rate_with_vat }}</td>
					<td>{{ $pdata->chield_rate_without_vat }}</td>
                    <td>{{ $pdata->chield_max_no_allowed }}</td>
                    <td>{{ $pdata->chield_min_no_allowed }}</td>
                  </tr>
				   <tr>
                    <td>Infant</td>
					<td>{{ $pdata->infant_rate_with_vat }}</td>
					<td>{{ $pdata->infant_rate_without_vat }}</td>
                    <td>{{ $pdata->infant_max_no_allowed }}</td>
                    <td>{{ $pdata->infant_min_no_allowed }}</td>
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


@endsection