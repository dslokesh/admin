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
                <input type="text" id="variant_name1" name="variant_name[]" value="{{ old('title') }}" class="form-control "  placeholder="Variant Name" required />
                @if ($errors->has('variant_name'))
                    <span class="text-danger">{{ $errors->first('variant_name') }}</span>
                @endif
				
				<input type="hidden" id="u_code1"  name="u_code[]"  class="form-control"  value="{{$activity->id.'-1'.time()}}" />
              </div>
			  <div class="form-group col-md-3">
                <label for="inputName">Variant Code: <span class="red">*</span></label>
                <input type="text" id="variant_code1"  name="variant_code[]"  class="form-control onlynumbr_text"  placeholder="Variant Code" required />
                @if ($errors->has('variant_code'))
                    <span class="text-danger">{{ $errors->first('variant_code') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-3">
                <label for="inputName">Slot Duration(In minutes):</label>
                <input type="text" id="slot_duration1" name="slot_duration[]" value="{{ old('slot_duration') }}" class="form-control"  placeholder="Slot Duration"  />
                @if ($errors->has('slot_duration'))
                    <span class="text-danger">{{ $errors->first('slot_duration') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Activity Duration(In minutes): <span class="red">*</span></label>
                <input type="text" id="activity_duration1" name="activity_duration[]" value="{{ old('activity_duration') }}" class="form-control"  placeholder="Activity Duration" required />
                @if ($errors->has('activity_duration'))
                    <span class="text-danger">{{ $errors->first('activity_duration') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-3">
			  
                <label for="inputName">Start Time (In 24 hrs): <span class="red">*</span></label>
                <input type="text" id="start_time1" name="start_time[]" value="{{ old('start_time') }}" class="form-control timepicker"  placeholder="Start Time" required />
                @if ($errors->has('start_time'))
                    <span class="text-danger">{{ $errors->first('start_time') }}</span>
                @endif
              </div>
                
				 <div class="form-group col-md-3">

                <label for="inputName">End Time (In 24 hrs): <span class="red">*</span></label>
                <input type="text" id="end_time1" name="end_time[]" value="{{ old('end_time') }}" class="form-control timepicker"  placeholder="End Time" required  />
                @if ($errors->has('end_time'))
                    <span class="text-danger">{{ $errors->first('end_time') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-3">
                <label for="inputName">Rate Valid From: <span class="red">*</span></label>
                <input type="text" id="rate_valid_from1" name="rate_valid_from[]" value="{{ old('rate_valid_from') }}" class="form-control datepicker"  placeholder="Rate Valid From" autocomplete="off" required="required" />
                @if ($errors->has('rate_valid_from'))
                    <span class="text-danger">{{ $errors->first('rate_valid_from') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-3">
                <label for="inputName">Rate Valid To: <span class="red">*</span></label>
                <input type="text" id="rate_valid_to1" name="rate_valid_to[]" value="{{ old('rate_valid_to') }}" class="form-control datepicker"  placeholder="Rate Valid To" autocomplete="off" required="required"  />
                @if ($errors->has('rate_valid_to'))
                    <span class="text-danger">{{ $errors->first('rate_valid_to') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">For Backend Only: <span class="red">*</span></label>
                <select name="for_backend_only[]" id="for_backend_only" class="form-control">
				<option value="1" @if(old('for_backend_only') ==1) {{'selected="selected"'}} @endif>Yes</option>
				<option value="0" @if(old('for_backend_only') ==0) {{'selected="selected"'}} @endif>No</option>
                   
                 </select>
				 @if ($errors->has('for_backend_only'))
                    <span class="text-danger">{{ $errors->first('for_backend_only') }}</span>
                @endif
              </div>
			    <div class="form-group col-md-3" style="display:none">
			  
                <label for="inputName">Pickup Time: <span class="red">*</span></label>
                <input type="text" id="pickup_time1" name="pickup_time[]" value="{{ old('pickup_time') }}" class="form-control "  placeholder="Pickup Time"  />
                @if ($errors->has('pickup_time'))
                    <span class="text-danger">{{ $errors->first('pickup_time') }}</span>
                @endif
              </div>
                
				 <div class="form-group col-md-3" style="display:none">

                <label for="inputName">Drop Time: <span class="red">*</span></label>
                <input type="text" id="drop_time1" name="drop_time[]" value="{{ old('drop_time') }}" class="form-control "  placeholder="Drop Time"  />
                @if ($errors->has('drop_time'))
                    <span class="text-danger">{{ $errors->first('drop_time') }}</span>
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
					<th>Start Age</th>
                    <th>End Age</th>
                  </tr>
				   <tr>
                    <td>Adult</td>
					<td><input type="text" id="adult_rate_with_vat1"  name="adult_rate_with_vat[]"  class="form-control onlynumbrf vatCal"  data-withvatinputid="adult_rate_without_vat1" value="0"  required /></td>
					<td><input type="text" id="adult_rate_without_vat1"  name="adult_rate_without_vat[]"  class="form-control onlynumbr "  readonly  value="0" /></td>
                    <td><input type="text" id="adult_max_no_allowed1" name="adult_max_no_allowed[]" value="0" class="form-control onlynumbr notNull"  /></td>
                    <td><input type="text" id="adult_min_no_allowed1"  name="adult_min_no_allowed[]" value="0" class="form-control onlynumbr notNull" /></td>
					 <td><input type="text" id="adult_start_age1" name="adult_start_age[]" value="0" class="form-control onlynumbr notNull" /></td>
					  <td><input type="text" id="adult_end_age1" name="adult_end_age[]" value="0" class="form-control onlynumbr notNull" /></td>
                  </tr>
				  <tr>
                    <td>Child</td>
					<td><input type="text" id="chield_rate_with_vat1"  name="chield_rate_with_vat[]"  class="form-control onlynumbrf vatCal" data-withvatinputid="chield_rate_without_vat1" value="0"  required  /></td>
					<td><input type="text" id="chield_rate_without_vat1"  name="chield_rate_without_vat[]"  class="form-control onlynumbr "  readonly  value="0" /></td>
                    <td><input type="text" id="chield_max_no_allowed1"  name="chield_max_no_allowed[]" value="0" class="form-control onlynumbr notNull"  /></td>
                    <td><input type="text" id="chield_min_no_allowed1" name="chield_min_no_allowed[]" value="0" class="form-control onlynumbr notNull" /></td>
					 <td><input type="text" id="chield_start_age1" name="chield_start_age[]" value="0" class="form-control onlynumbr notNull" /></td>
					  <td><input type="text" id="chield_end_age1" name="chield_end_age[]" value="0" class="form-control onlynumbr notNull" /></td>
                  </tr>
				   <tr>
                    <td>Infant</td>
					<td><input type="text" id="infant_rate_with_vat1"  name="infant_rate_with_vat[]"  class="form-control onlynumbrf vatCal" data-withvatinputid="infant_rate_without_vat1" value="0"  required /></td>
					<td><input type="text" id="infant_rate_without_vat1"  name="infant_rate_without_vat[]"  class="form-control onlynumbr "  readonly  value="0" /></td>
                    <td><input type="text" id="infant_max_no_allowed1"  name="infant_max_no_allowed[]" value="0" class="form-control onlynumbr notNull"  /></td>
                    <td><input type="text" id="infant_min_no_allowed1"  name="infant_min_no_allowed[]" value="0" class="form-control onlynumbr notNull" /></td>
					 <td><input type="text" id="infant_start_age1" name="infant_start_age[]" value="0" class="form-control onlynumbr notNull"  /></td>
                    <td><input type="text" id="infant_end_age1" name="infant_end_age[]" value="0" class="form-control onlynumbr notNull" /></td>
                  </tr>
				  </table>
              </div>
			  
			  <div class="form-group col-md-12">
                <label for="inputName">Booking Cut off & Cancellation:</label>
               <table class="table table-bordered">
                  <thead>
                  <tr>
                    <th>Variant</th>
					<th>Booking Window Value (In Minutes)</th>
					<th>Cancellation Value (In Minutes)</th>
                   
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
		
			$('.card-body').append(response.html).find('#rate_valid_from' + rowCount).datepicker({
			weekStart: 1,
			daysOfWeekHighlighted: "6,0",
			autoclose: true,
			todayHighlight: true,
			dateFormat: 'yy-mm-dd',
			onChangeMonthYear: function (year, month, inst) {
				var currentDate = $(this).datepicker('getDate');
				if (currentDate !== null) {
					var currentYear = currentDate.getFullYear();
					if (currentYear < 1000) {
						currentDate.setFullYear(currentYear + 2000);
						$(this).datepicker('setDate', currentDate);
					}
				}
			},
			onSelect: function (dateText) {
				$('body #rate_valid_from' + rowCount).val(dateText);
			}
		});
			
			$('.card-body').find('#rate_valid_to'+rowCount).datepicker({
				weekStart: 1,
				daysOfWeekHighlighted: "6,0",
				autoclose: true,
				todayHighlight: true,
				dateFormat: 'yy-mm-dd',
				onChangeMonthYear: function (year, month, inst) {
				var currentDate2 = $(this).datepicker('getDate');
					if (currentDate2 !== null) {
							var currentYear = currentDate2.getFullYear();
							if (currentYear < 1000) {
							currentDate2.setFullYear(currentYear + 2000);
							$(this).datepicker('setDate', currentDate2);
						}
					}
				},
				onSelect: function (dateText2) {
					$('body #rate_valid_to' + rowCount).val(dateText2);
				}
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
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
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
	var vat = parseFloat("{{$activity->vat}}")/100;
	if(isNaN(taxAmount)){
		vat = 0;
	}
	let inputvale = parseFloat($(this).val());
	if(inputvale == null || isNaN(inputvale))
	{
		inputvale = 0;
		$(this).val(0);
	}
	let taxvalu = parseFloat(1 + vat);
	var taxAmount = parseFloat(inputvale / taxvalu);
	let withVatInputId = $(this).data('withvatinputid');
	
	if(!isNaN(taxAmount)){
	$("body #"+withVatInputId).val(taxAmount.toFixed(2));
	}
	
});
$(document).on('change', 'body .notNull', function(evt) {
	let inputvale = parseFloat($(this).val());
	if(inputvale == null || isNaN(inputvale))
	{
		inputvale = 0;
		$(this).val(0);
	}
	
});
   
  </script>   
  
@endsection
 
 
