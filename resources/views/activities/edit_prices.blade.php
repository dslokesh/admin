@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Activity Prices</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('activities.index') }}">Activities</a></li>
              <li class="breadcrumb-item active">Activity Prices</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('activity.prices.save') }}" method="post" class="form" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Activity Prices</h3>
			  <a href="#" class="btn btn-success float-right btn-sm" id="addMoreBtn"><i class="fas fa-plus"></i> Add More</a>
            </div>
			<input type="hidden" id="activity_id" name="activity_id" value="{{ $activity->id }}"  />
            <div class="card-body">
			@php
			$rowCount = 1;
			@endphp
			
			@if(!empty($priceData))
			@foreach($priceData as $k => $pdata)
			
			<div class="bg-row row p-2">
			@if($k > 0)
			<div class="form-group col-md-12 mt-3">
			<a class="btn btn-danger btn-sm float-right remove-btn" href="javascript:void(0)">Remove Block <i class="fas fa-trash"></i></a>
			</div>
			@endif
                <div class="form-group col-md-3">
                <label for="inputName">Variant Name: <span class="red">*</span></label>
                <input type="text" id="variant_name{{$k}}" name="variant_name[]" value="{{ old('variant_name')?:$pdata->variant_name }}" class="form-control"  placeholder="Variant Name" required />
                @if ($errors->has('variant_name'))
                    <span class="text-danger">{{ $errors->first('variant_name') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Variant Code: <span class="red">*</span></label>
                <input type="text" id="variant_code{{$k}}"  name="variant_code[]"  class="form-control onlynumbr_text"  placeholder="Variant Code" value="{{ old('variant_code')?:$pdata->variant_code }}" required />
                @if ($errors->has('variant_code'))
                    <span class="text-danger">{{ $errors->first('variant_code') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-3">
                <label for="inputName">Slot Duration: <span class="red">*</span></label>
                <input type="text" id="slot_duration{{$k}}" name="slot_duration[]" value="{{ old('slot_duration')?:$pdata->slot_duration }}" class="form-control"  placeholder="Slot Duration" required />
                @if ($errors->has('slot_duration'))
                    <span class="text-danger">{{ $errors->first('slot_duration') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Activity Duration: <span class="red">*</span></label>
                <input type="text" id="activity_duration{{$k}}" name="activity_duration[]" value="{{ old('activity_duration')?:$pdata->activity_duration }}" class="form-control"  placeholder="Activity Duration" required />
                @if ($errors->has('activity_duration'))
                    <span class="text-danger">{{ $errors->first('activity_duration') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-3">
			  
                <label for="inputName">Start Time: <span class="red">*</span></label>
                <input type="text" id="start_time{{$k}}" name="start_time[]" value="{{ old('start_time')?:$pdata->start_time }}" class="form-control timepicker"  placeholder="Start Time" required />
                @if ($errors->has('start_time'))
                    <span class="text-danger">{{ $errors->first('start_time') }}</span>
                @endif
              </div>
                
				 <div class="form-group col-md-3">

                <label for="inputName">End Time: <span class="red">*</span></label>
                <input type="text" id="end_time{{$k}}" name="end_time[]" value="{{ old('end_time')?:$pdata->end_time }}" class="form-control timepicker"  placeholder="End Time" required />
                @if ($errors->has('end_time'))
                    <span class="text-danger">{{ $errors->first('end_time') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-3">
                <label for="inputName">Rate Valid From: <span class="red">*</span></label>
                <input type="text" id="rate_valid_from{{$k}}" name="rate_valid_from[]" value="{{ date('Y-m-d',strtotime(old('rate_valid_from')?:$pdata->rate_valid_from)) }}" class="form-control datepicker"  placeholder="Rate Valid From"  />
                @if ($errors->has('rate_valid_from'))
                    <span class="text-danger">{{ $errors->first('rate_valid_from') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-3">
                <label for="inputName">Rate Valid To: <span class="red">*</span></label>
                <input type="text" id="rate_valid_to{{$k}}" name="rate_valid_to[]" value="{{ date('Y-m-d',strtotime(old('rate_valid_to')?:$pdata->rate_valid_to)) }}" class="form-control datepicker"  placeholder="Rate Valid To" />
                @if ($errors->has('rate_valid_to'))
                    <span class="text-danger">{{ $errors->first('rate_valid_to') }}</span>
                @endif
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
					<td><input type="text" id="adult_rate_with_vat{{$k}}"  name="adult_rate_with_vat[]"  class="form-control onlynumbrf vatCal" value="{{ $pdata->adult_rate_with_vat }}"  data-withvatinputid="adult_rate_without_vat{{$k}}" /></td>
					<td><input type="text" id="adult_rate_without_vat{{$k}}"  name="adult_rate_without_vat[]"  class="form-control onlynumbr" readonly value="{{ $pdata->adult_rate_without_vat }}" /></td>
                    <td><input type="text" id="adult_max_no_allowed{{$k}}" name="adult_max_no_allowed[]"  class="form-control onlynumbr" value="{{ $pdata->adult_max_no_allowed }}" /></td>
                    <td><input type="text" id="adult_min_no_allowed{{$k}}"  name="adult_min_no_allowed[]"  class="form-control onlynumbr" value="{{ $pdata->adult_min_no_allowed }}" /></td>
                  </tr>
				  <tr>
                    <td>Child</td>
					<td><input type="text" id="chield_rate_with_vat{{$k}}"  name="chield_rate_with_vat[]"  class="form-control onlynumbrf vatCal" value="{{ $pdata->chield_rate_with_vat }}"  data-withvatinputid="chield_rate_without_vat{{$k}}" /></td>
					<td><input type="text" id="chield_rate_without_vat{{$k}}"  name="chield_rate_without_vat[]"  class="form-control onlynumbr" readonly  value="{{ $pdata->chield_rate_without_vat }}" /></td>
                    <td><input type="text" id="chield_max_no_allowed{{$k}}"  name="chield_max_no_allowed[]"  class="form-control onlynumbr" value="{{ $pdata->chield_max_no_allowed }}" /></td>
                    <td><input type="text" id="chield_min_no_allowed{{$k}}" name="chield_min_no_allowed[]"  class="form-control onlynumbr" value="{{ $pdata->chield_min_no_allowed }}" /></td>
                  </tr>
				   <tr>
                    <td>Infant</td>
					<td><input type="text" id="infant_rate_with_vat{{$k}}"  name="infant_rate_with_vat[]"  class="form-control onlynumbrf vatCal"  value="{{ $pdata->infant_rate_with_vat }}"  data-withvatinputid="infant_rate_without_vat{{$k}}" /></td>
					<td><input type="text" id="infant_rate_without_vat{{$k}}"  name="infant_rate_without_vat[]"  class="form-control onlynumbr" readonly value="{{ $pdata->infant_rate_without_vat }}" /></td>
                    <td><input type="text" id="infant_max_no_allowed{{$k}}"  name="infant_max_no_allowed[]"  class="form-control onlynumbr" value="{{ $pdata->infant_max_no_allowed }}" /></td>
                    <td><input type="text" id="infant_min_no_allowed{{$k}}"  name="infant_min_no_allowed[]"  class="form-control onlynumbr" value="{{ $pdata->infant_min_no_allowed }}" /></td>
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
					<td><input type="text" id="booking_window_valueto{{$k}}"  name="booking_window_valueto[]" required class="form-control onlynumbr"  value="{{ $pdata->booking_window_valueto }}"  /></td>
                    <td><input type="text" id="cancellation_value_to{{$k}}"  name="cancellation_value_to[]"  class="form-control onlynumbr"  value="{{ $pdata->cancellation_value_to }}" /></td>
                  </tr>
				  @if($activity->sic_TFRS==1)
				  <tr>
					@else
					<tr style="display:none">
					@endif
					
                    <td>Ticket with SIC TFR</td>
					<td><input type="text" id="booking_window_valueSIC{{$k}}"  name="booking_window_valueSIC[]"  class="form-control onlynumbr"   value="{{ $pdata->booking_window_valueSIC }}" /></td>
                    <td><input type="text" id="cancellation_valueSIC{{$k}}"  name="cancellation_valueSIC[]"  class="form-control onlynumbr"  value="{{ $pdata->cancellation_valueSIC }}" /></td>
                  </tr>
				   @if($activity->pvt_TFRS==1)
				  <tr>
					@else
					<tr style="display:none">
					@endif
                    <td>Ticket with PVT TFR</td>
					<td><input type="text" id="booking_window_valuePVT{{$k}}"  name="booking_window_valuePVT[]"  class="form-control onlynumbr"  value="{{ $pdata->booking_window_valuePVT }}"  /></td>
                    <td><input type="text" id="cancellation_valuePVT{{$k}}"  name="cancellation_valuePVT[]"  class="form-control onlynumbr"  value="{{ $pdata->cancellation_valuePVT }}" /></td>
                  </tr>
				  </table>
              </div>
			  </div>
			  @php
			  $rowCount++;
			  @endphp
			  
			 @endforeach
			 @endif
            </div>
			
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12 mb-3">
          <a href="{{ route('activities.index') }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-success float-right">Save</button>
        </div>
      </div>
    </form>
    </section>
    <!-- /.content -->
@endsection
@section('scripts')
 <!-- Script -->
 <script type="text/javascript">
    $(document).ready(function() {
	var rowCount = "{{$rowCount}}";
	
	$(document).on('click', '#addMoreBtn', function() {
		rowCount++;
		var data = {
    rowCount: rowCount,
	activity_id : $('#activity_id').val()	
};
	$.ajax({
    url: "{{ route('activity.prices.new.row') }}",
	data: data,	
    type: 'GET',
    dataType: 'json',
    success: function(response) {
        // Append the content to the DOM
		
			$('.card-body').append(response.html);
				$('.datepicker').datepicker({
				weekStart: 1,
				daysOfWeekHighlighted: "6,0",
				autoclose: true,
				todayHighlight: true,
				format: 'yyyy-mm-dd'
			});
			$('.timepicker').datetimepicker({
				format: 'hh:mm a'
			});

    },
    error: function(xhr, status, error) {
        console.error(error);
    }
});
});

$("body").on('click','.remove-btn',function(){
			$(this).parent().parent().remove();
		});

});
$(document).on('keypress', '.onlynumbr', function(evt) {
	var charCode = (evt.which) ? evt.which : evt.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
  return true;

});

$(document).on('keypress', '.onlynumbrf', function(evt) {
	var charCode = (evt.which) ? evt.which : evt.keyCode
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
  return true;

});

$(document).on('keypress', '.onlynumbr_text', function(evt) {
	var regex = new RegExp("^[a-zA-Z0-9]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
       event.preventDefault();
       return false;
    }

});

$(document).on('change', '.vatCal', function(evt) {
	let vat = parseFloat("{{$activity->vat}}")/100;
	let inputvale = parseFloat($(this).val());
	
	let taxvalu = vat*inputvale;
	let taxAmount = inputvale - taxvalu;
	let withVatInputId = $(this).data('withvatinputid');
	//alert(withVatInputId);
	$("body #"+withVatInputId).val(taxAmount.toFixed(2));
	
});

   
  </script>   
  
@endsection
 
 
