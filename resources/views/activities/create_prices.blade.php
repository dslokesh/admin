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
			
			<div class="bg-row row p-2">
                <div class="form-group col-md-3">
                <label for="inputName">Variant Name: <span class="red">*</span></label>
                <input type="text" id="variant_name1" name="variant_name[]" value="{{ old('title') }}" class="form-control"  placeholder="Variant Name" required />
                @if ($errors->has('variant_name'))
                    <span class="text-danger">{{ $errors->first('variant_name') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-3">
                <label for="inputName">Slot Duration: <span class="red">*</span></label>
                <input type="text" id="slot_duration1" name="slot_duration[]" value="{{ old('slot_duration') }}" class="form-control"  placeholder="Slot Duration" required />
                @if ($errors->has('slot_duration'))
                    <span class="text-danger">{{ $errors->first('slot_duration') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Activity Duration: <span class="red">*</span></label>
                <input type="text" id="activity_duration1" name="activity_duration[]" value="{{ old('activity_duration') }}" class="form-control"  placeholder="Activity Duration" required />
                @if ($errors->has('activity_duration'))
                    <span class="text-danger">{{ $errors->first('activity_duration') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-3">
			  
                <label for="inputName">Start Time: <span class="red">*</span></label>
                <input type="text" id="start_time1" name="start_time[]" value="{{ old('start_time') }}" class="form-control timepicker"  placeholder="Start Time" required />
                @if ($errors->has('start_time'))
                    <span class="text-danger">{{ $errors->first('start_time') }}</span>
                @endif
              </div>
                
				 <div class="form-group col-md-3">

                <label for="inputName">End Time: <span class="red">*</span></label>
                <input type="text" id="end_time1" name="end_time[]" value="{{ old('end_time') }}" class="form-control timepicker"  placeholder="End Time" required />
                @if ($errors->has('end_time'))
                    <span class="text-danger">{{ $errors->first('end_time') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-3">
                <label for="inputName">Rate Valid From: <span class="red">*</span></label>
                <input type="text" id="rate_valid_from1" name="rate_valid_from[]" value="{{ old('rate_valid_from') }}" class="form-control datepicker"  placeholder="Rate Valid From"  />
                @if ($errors->has('rate_valid_from'))
                    <span class="text-danger">{{ $errors->first('rate_valid_from') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-3">
                <label for="inputName">Rate Valid To: <span class="red">*</span></label>
                <input type="text" id="rate_valid_to1" name="rate_valid_to[]" value="{{ old('rate_valid_to') }}" class="form-control datepicker"  placeholder="Rate Valid To" />
                @if ($errors->has('rate_valid_to'))
                    <span class="text-danger">{{ $errors->first('rate_valid_to') }}</span>
                @endif
              </div>
			   
			  <div class="col-md-12">
                <table class="table table-bordered">
                  <thead>
                  <tr>
                    <th>Pax Type</th>
					<th>Rate (Without VAT)</th>
					<th>Rate Including VAT</th>
                    <th>Max No Allowed</th>
                    <th>Min No Allowed</th>
                  </tr>
				   <tr>
                    <td>Adult</td>
					<td><input type="text" id="adult_rate_without_vat1"  name="adult_rate_without_vat[]"  class="form-control onlynumbr vatCal"  data-withvatinputid="adult_rate_with_vat1" /></td>
					<td><input type="text" id="adult_rate_with_vat1" readonly name="adult_rate_with_vat[]"  class="form-control onlynumbr"   /></td>
                    <td><input type="text" id="adult_max_no_allowed1" name="adult_max_no_allowed[]"  class="form-control onlynumbr"  /></td>
                    <td><input type="text" id="adult_min_no_allowed1"  name="adult_min_no_allowed[]"  class="form-control onlynumbr" /></td>
                  </tr>
				  <tr>
                    <td>Child</td>
					<td><input type="text" id="chield_rate_without_vat1"  name="chield_rate_without_vat[]"  class="form-control onlynumbr vatCal" data-withvatinputid="chield_rate_with_vat1"   /></td>
					<td><input type="text" id="chield_rate_with_vat1" readonly name="chield_rate_with_vat[]"  class="form-control onlynumbr"   /></td>
                    <td><input type="text" id="chield_max_no_allowed1"  name="chield_max_no_allowed[]"  class="form-control onlynumbr"  /></td>
                    <td><input type="text" id="chield_min_no_allowed1" name="chield_min_no_allowed[]"  class="form-control onlynumbr" /></td>
                  </tr>
				   <tr>
                    <td>Infant</td>
					<td><input type="text" id="infant_rate_without_vat1"  name="infant_rate_without_vat[]"  class="form-control onlynumbr vatCal" data-withvatinputid="infant_rate_with_vat1"  /></td>
					<td><input type="text" id="infant_rate_with_vat1" readonly name="infant_rate_with_vat[]"  class="form-control onlynumbr"   /></td>
                    <td><input type="text" id="infant_max_no_allowed1"  name="infant_max_no_allowed[]"  class="form-control onlynumbr"  /></td>
                    <td><input type="text" id="infant_min_no_allowed1"  name="infant_min_no_allowed[]"  class="form-control onlynumbr" /></td>
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
					<td><input type="text" id="booking_window_valueto1"  name="booking_window_valueto[]" required class="form-control onlynumbr"   /></td>
                    <td><input type="text" id="cancellation_value_to1"  name="cancellation_value_to[]"  class="form-control onlynumbr" /></td>
                  </tr>
				  @if($activity->sic_TFRS==1)
				  <tr>
					@else
					<tr style="display:none">
					@endif
                    <td>Ticket with SIC TFR</td>
					<td><input type="text" id="booking_window_valueSIC1"  name="booking_window_valueSIC[]"  class="form-control onlynumbr"   /></td>
                    <td><input type="text" id="cancellation_valueSIC1"  name="cancellation_valueSIC[]"  class="form-control onlynumbr" /></td>
                  </tr>
				   @if($activity->pvt_TFRS==1)
				  <tr>
					@else
					<tr style="display:none">
					@endif
                    <td>Ticket with PVT TFR</td>
					<td><input type="text" id="booking_window_valuePVT1"  name="booking_window_valuePVT[]"  class="form-control onlynumbr"   /></td>
                    <td><input type="text" id="cancellation_valuePVT1"  name="cancellation_valuePVT[]"  class="form-control onlynumbr" /></td>
                  </tr>
				  </table>
              </div>
			  
			  </div>
			 
            </div>
			
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
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
	var rowCount = 1;
	
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

$(document).on('change', '.vatCal', function(evt) {
	let vat = parseFloat("{{$activity->vat}}")/100;
	let inputvale = parseFloat($(this).val());
	
	let taxvalu = vat*inputvale;
	let taxAmount = inputvale+taxvalu;
	let withVatInputId = $(this).data('withvatinputid');
	//alert(withVatInputId);
	$("body #"+withVatInputId).val(taxAmount.toFixed(2));
	
});

   
  </script>   
  
@endsection
 
 
