			</hr>
			<div class="row bg-row">
			<div class="form-group col-md-12 mt-3">
			<a class="btn btn-danger btn-sm float-right remove-btn" href="javascript:void(0)">Remove Block <i class="fas fa-trash"></i></a>
			</div>
			
                <div class="form-group col-md-3">
                <label for="inputName">Variant Name: <span class="red">*</span></label>
                <input type="text" id="variant_name{{$rowCount}}"  name="variant_name[]"  class="form-control"  placeholder="Variant Name" required />
                @if ($errors->has('variant_name'))
                    <span class="text-danger">{{ $errors->first('variant_name') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-3">
                <label for="inputName">Variant Code: <span class="red">*</span></label>
                <input type="text" id="variant_code{{$rowCount}}"  name="variant_code[]"  class="form-control onlynumbr_text"  placeholder="Variant Code" required />
                @if ($errors->has('variant_code'))
                    <span class="text-danger">{{ $errors->first('variant_code') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-3">
                <label for="inputName">Slot Duration(In minutes): <span class="red">*</span></label>
                <input type="text" id="slot_duration{{$rowCount}}" name="slot_duration[]" value="{{ old('slot_duration') }}" class="form-control"  placeholder="Slot Duration" required />
                @if ($errors->has('slot_duration'))
                    <span class="text-danger">{{ $errors->first('slot_duration') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3"> 
                <label for="inputName">Activity Duration(In minutes): <span class="red">*</span> </label>
                <input type="text" id="activity_duration{{$rowCount}}" name="activity_duration[]"  class="form-control"  placeholder="Activity Duration" required/>
                @if ($errors->has('activity_duration'))
                    <span class="text-danger">{{ $errors->first('activity_duration') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-3">
			  
                <label for="inputName">Start Time: <span class="red">*</span></label>
                <input type="text" id="start_time{{$rowCount}}" name="start_time[]"  class="form-control timepicker"  placeholder="Start Time" required />
                @if ($errors->has('start _time'))
                    <span class="text-danger">{{ $errors->first('start _time') }}</span>
                @endif
              </div>
                
				 <div class="form-group col-md-3">
                <label for="inputName">End Time: <span class="red">*</span></label>
                <input type="text" id="end_time{{$rowCount}}" name="end_time[]"  class="form-control timepicker"  placeholder="End Time" />
                @if ($errors->has('end_time'))
                    <span class="text-danger">{{ $errors->first('end_time') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-3">
                <label for="inputName">Rate Valid From: <span class="red">*</span></label>
                <input type="text" id="rate_valid_from{{$rowCount}}" name="rate_valid_from[]"  class="form-control"  placeholder="Rate Valid From (yyyy-mm-dd)"  required readonly autocomplete="off" />
                @if ($errors->has('rate_valid_from'))
                    <span class="text-danger">{{ $errors->first('rate_valid_from') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-3">
                <label for="inputName">Rate Valid To: <span class="red">*</span></label>
                <input type="text" id="rate_valid_to{{$rowCount}}" name="rate_valid_to[]" class="form-control"  placeholder="Rate Valid To (yyyy-mm-dd)"  required readonly autocomplete="off"  />
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
					<th>Start Age</th>
                    <th>End Age</th>
                  </tr>
				   <tr>
                    <td>Adult</td>
					<td><input type="text" id="adult_rate_with_vat{{$rowCount}}" name="adult_rate_with_vat[]"  class="form-control onlynumbr vatCal" data-withvatinputid="adult_rate_without_vat{{$rowCount}}" value="0"  required /></td>
					<td><input type="text" id="adult_rate_without_vat{{$rowCount}}" name="adult_rate_without_vat[]"  class="form-control onlynumbr"  readonly  value="0" /></td>
                    <td><input type="number" id="adult_max_no_allowed{{$rowCount}}" name="adult_max_no_allowed[]" value="0" class="form-control onlynumbr"  /></td>
                    <td><input type="number" id="adult_min_no_allowed{{$rowCount}}" name="adult_min_no_allowed[]" value="0" class="form-control onlynumbr" /></td>
					 <td><input type="number" id="adult_start_age{{$rowCount}}" name="adult_start_age[]" value="0" class="form-control onlynumbr" /></td>
					  <td><input type="number" id="adult_end_age{{$rowCount}}" name="adult_end_age[]" value="0" class="form-control onlynumbr" /></td>
                  </tr>
				  <tr>
                    <td>Child</td>
					<td><input type="text" id="chield_rate_with_vat{{$rowCount}}" name="chield_rate_with_vat[]"  class="form-control onlynumbr vatCal" data-withvatinputid="chield_rate_without_vat{{$rowCount}}" value="0"  required  /></td>
					<td><input type="text" id="chield_rate_without_vat{{$rowCount}}" name="chield_rate_without_vat[]"  class="form-control onlynumbr" readonly  value="0" /></td>
                    <td><input type="number" id="chield_max_no_allowed{{$rowCount}}" name="chield_max_no_allowed[]" value="0" class="form-control onlynumbr"  /></td>
                    <td><input type="number" id="chield_min_no_allowed{{$rowCount}}" name="chield_min_no_allowed[]" value="0" class="form-control onlynumbr" /></td>
					 <td><input type="number" id="chield_start_age{{$rowCount}}" name="chield_start_age[]" value="0" class="form-control onlynumbr" /></td>
					  <td><input type="number" id="chield_end_age{{$rowCount}}" name="chield_end_age[]" value="0" class="form-control onlynumbr" /></td>
                  </tr>
				   <tr>
                    <td>Infant</td>
					<td><input type="text"   id="infant_rate_with_vat{{$rowCount}}" name="infant_rate_with_vat[]"  class="form-control onlynumbr vatCal"  data-withvatinputid="infant_rate_without_vat{{$rowCount}}" value="0"  required /></td>
					<td><input type="text" id="infant_rate_without_vat{{$rowCount}}" name="infant_rate_without_vat[]"  class="form-control onlynumbr"  readonly  value="0" /></td>
                    <td><input type="number" id="infant_max_no_allowed{{$rowCount}}" name="infant_max_no_allowed[]" value="0" class="form-control onlynumbr"  /></td>
                    <td><input type="number" id="infant_min_no_allowed{{$rowCount}}" name="infant_min_no_allowed[]" value="0" class="form-control onlynumbr" /></td>
					 <td><input type="number" id="infant_start_age{{$rowCount}}" name="infant_start_age[]" value="0" class="form-control onlynumbr"  /></td>
                    <td><input type="number" id="infant_end_age{{$rowCount}}" name="infant_end_age[]" value="0" class="form-control onlynumbr" /></td>
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
					<td><input type="text" id="booking_window_valueto{{$rowCount}}"  name="booking_window_valueto[]" required class="form-control onlynumbr"   /></td>
                    <td><input type="text" id="cancellation_value_to1"  name="cancellation_value_to[]"  class="form-control onlynumbr" /></td>
                  </tr>
				  @if($activity->sic_TFRS==1)
				  <tr>
					@else
					<tr style="display:none">
					@endif
                    <td>Ticket with SIC TFR</td>
					<td><input type="text" id="booking_window_valueSIC{{$rowCount}}"  name="booking_window_valueSIC[]"  class="form-control onlynumbr"   /></td>
                    <td><input type="text" id="cancellation_valueSIC1"  name="cancellation_valueSIC[]"  class="form-control onlynumbr" /></td>
                  </tr>
				    @if($activity->pvt_TFRS==1)
				  <tr>
					@else
					<tr style="display:none">
					@endif
                    <td>Ticket with PVT TFR</td>
					<td><input type="text" id="booking_window_valuePVT{{$rowCount}}"  name="booking_window_valuePVT[]"  class="form-control onlynumbr"   /></td>
                    <td><input type="text" id="cancellation_valuePVT1"  name="cancellation_valuePVT[]"  class="form-control onlynumbr" /></td>
                  </tr>
				  </table>
              </div>
			  </div>
	
 
 
  
