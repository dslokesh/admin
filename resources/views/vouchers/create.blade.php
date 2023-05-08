@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Voucher Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('vouchers.index') }}">Vouchers</a></li>
              <li class="breadcrumb-item active">Voucher Add</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('vouchers.store') }}" method="post" class="form">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add Voucher</h3>
            </div>
            <div class="card-body row">
              <div class="form-group col-md-6">
                <label for="inputName">Agent Name: <span class="red">*</span></label>
                <input type="text" id="agent_id" name="agent_id" value="{{ old('agent_id') }}" class="form-control"  placeholder="Agent Name" />
                @if ($errors->has('agent_id'))
                    <span class="text-danger">{{ $errors->first('agent_id') }}</span>
                @endif
				
				<input type="hidden" id="agent_id_select" name="agent_id_select"  />
				
              </div>
			   
			  <div class="form-group col-md-6">
                <label for="inputName">Customer Name: <span class="red">*</span> <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Create New</button></label>
                <input type="text" id="customer_id" name="customer_id" value="{{ old('customer_id') }}" class="form-control"  placeholder="Customer  Name" />
                @if ($errors->has('customer_id'))
                    <span class="text-danger">{{ $errors->first('customer_id') }}</span>
                @endif
				
				<input type="hidden" id="customer_id_select" name="customer_id_select"  />
				
              </div>
			  <div class="form-group col-md-6" id="agent_details">
			   </div>
			   <div class="form-group col-md-6" id="cus_details">
			   
			   </div>
			    <div class="form-group col-md-6">
                <label for="inputName">Country: <span class="red">*</span></label>
                <select name="country_id" id="country_id" class="form-control">
				<option value="">--select--</option>
				@foreach($countries as $country)
                    <option value="{{$country->id}}" @if(old('country_id') == $country->id) {{'selected="selected"'}} @endif>{{$country->name}}</option>
				@endforeach
                 </select>
				 @if ($errors->has('country_id'))
                    <span class="text-danger">{{ $errors->first('country_id') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">Hotel: <span class="red">*</span></label>
                <select name="is_hotel" id="is_hotel" class="form-control">
                    <option value="1" @if(old('is_hotel') ==1) {{'selected="selected"'}} @endif>Yes</option>
					  <option value="0" @if(old('is_hotel') ==0) {{'selected="selected"'}} @endif >No</option>
                 </select>
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">Flight: <span class="red">*</span></label>
                <select name="is_flight" id="is_flight" class="form-control">
                    <option value="1" @if(old('is_flight') ==1) {{'selected="selected"'}} @endif>Yes</option>
					<option value="0" @if(old('is_flight') ==0) {{'selected="selected"'}} @endif >No</option>
                 </select>
              </div>
			  <div class="form-group col-md-6">
                <label for="inputName">Status: <span class="red">*</span></label>
                <select name="status" id="status" class="form-control">
                    <option value="1" @if(old('status') ==1) {{'selected="selected"'}} @endif>Active</option>
					<option value="0" @if(old('status') ==0) {{'selected="selected"'}} @endif >Inactive</option>
                 </select>
				 
              </div>
			   <div class="form-group col-md-3 flight_is_div">
                <label for="inputName">Arrival Airline: <span class="red">*</span></label>
                <select name="arrival_airlines_id" id="arrival_airlines_id" class="form-control">
				<option value="">--select--</option>
                   @foreach($airlines as $airline)
                    <option value="{{$airline->id}}" @if(old('arrival_airlines_id') == $airline->id) {{'selected="selected"'}} @endif>{{$airline->name}}</option>
				@endforeach
                 </select>
				  @if ($errors->has('arrival_airlines_id'))
                    <span class="text-danger">{{ $errors->first('arrival_airlines_id') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3 flight_is_div">
                <label for="inputName">Arrival Date: <span class="red">*</span></label>
                 <input type="text" id="arrival_date" name="arrival_date" value="{{ old('arrival_date') }}" class="form-control datepicker"  placeholder="Arrival Date" />
				  @if ($errors->has('arrival_date'))
                    <span class="text-danger">{{ $errors->first('arrival_date') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-3 flight_is_div">
                <label for="inputName">Arrival Airport: <span class="red">*</span></label>
                 <input type="text" id="arrival_airport" name="arrival_airport" value="{{ old('arrival_airport') }}" class="form-control"  placeholder="Arrival Airport" />
				  @if ($errors->has('arrival_airport'))
                    <span class="text-danger">{{ $errors->first('arrival_airport') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-3 flight_is_div">
                <label for="inputName">Arrival Terminal: <span class="red">*</span></label>
                 <input type="text" id="arrival_terminal" name="arrival_terminal" value="{{ old('arrival_terminal') }}" class="form-control "  placeholder="Arrival Terminal" />
				  @if ($errors->has('arrival_terminal'))
                    <span class="text-danger">{{ $errors->first('arrival_terminal') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-3 flight_is_div">
                <label for="inputName">Depature Airline: <span class="red">*</span></label>
                <select name="depature_airlines_id" id="depature_airlines_id" class="form-control">
				<option value="">--select--</option>
                   @foreach($airlines as $airline)
                    <option value="{{$airline->id}}" @if(old('depature_airlines_id') == $airline->id) {{'selected="selected"'}} @endif>{{$airline->name}}</option>
				@endforeach
                 </select>
				  @if ($errors->has('depature_airlines_id'))
                    <span class="text-danger">{{ $errors->first('depature_airlines_id') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3 flight_is_div">
                <label for="inputName">Depature Date: <span class="red">*</span></label>
                <input type="text" id="depature_date" name="depature_date" value="{{ old('depature_date') }}" class="form-control datepicker"  placeholder="Depature Date" />
				 @if ($errors->has('depature_date'))
                    <span class="text-danger">{{ $errors->first('depature_date') }}</span>
                @endif
              </div>
			    <div class="form-group col-md-3 flight_is_div">
                <label for="inputName">Depature Airport: <span class="red">*</span></label>
                 <input type="text" id="depature_airport" name="depature_airport" value="{{ old('depature_airport') }}" class="form-control"  placeholder="Depature Airport" />
				  @if ($errors->has('depature_airport'))
                    <span class="text-danger">{{ $errors->first('depature_airport') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-3 flight_is_div">
                <label for="inputName">Depature Terminal: <span class="red">*</span></label>
                 <input type="text" id="depature_terminal" name="depature_terminal" value="{{ old('depature_terminal') }}" class="form-control "  placeholder="Depature Terminal" />
				  @if ($errors->has('depature_terminal'))
                    <span class="text-danger">{{ $errors->first('depature_terminal') }}</span>
                @endif
              </div>
           
			 </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <a href="{{ route('vouchers.index') }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" name="save_and_hotel" class="btn btn-success float-right  ml-3">Save & Add Hotel</button>
		   <button type="submit" name="save_and_view" class="btn btn-primary float-right">Save</button>
        </div>
      </div>
    </form>
	
	<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header"> Add New Customer
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
       <form action="{{ route('customers.store') }}" id="newCustomerForm" method="post" class="form">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card-primary">
          <div id="message"></div>
		  <div id="errors"></div>
            <div class="card-body row">
                <div class="form-group col-md-6">
                <label for="inputName">Name: <span class="red">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control"  placeholder="Name" />
                    <span class="text-danger" id="err_name"></span>
              </div>
			  <div class="form-group col-md-6">
                <label for="inputName">Code: <span class="red">*</span></label>
                <input type="text" id="code" name="code" value="{{ old('code') }}" class="form-control"  placeholder="Name" />
                    <span class="text-danger" id="err_code"></span>
              </div>
                <div class="form-group col-md-6">
                <label for="inputName">Mobile: <span class="red">*</span></label>
                <input type="text" id="mobile" name="mobile" value="{{ old('mobile') }}" class="form-control"  placeholder="Mobile" />
                  <span class="text-danger" id="err_mobile"></span>
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control"  placeholder="Email" />
                    <span class="text-danger" id="err_email"></span>
              </div>
                <div class="form-group col-md-6">
                <label for="inputName">Address: <span class="red">*</span></label>
                <input type="text" id="address" name="address" value="{{ old('address') }}" class="form-control"  placeholder="Address" />
                    <span class="text-danger" id="err_address"></span>
              </div>
               
			  <div class="form-group col-md-6">
                <label for="inputName">Country: <span class="red">*</span></label>
                <select name="country_id" id="country_id" class="form-control">
				<option value="">--select--</option>
				@foreach($countries as $country)
                    <option value="{{$country->id}}" @if(old('country_id') == $country->id) {{'selected="selected"'}} @endif>{{$country->name}}</option>
				@endforeach
                 </select>
				 <span class="text-danger" id="err_country_id"></span>
              </div>
			  <div class="form-group col-md-6">
                <label for="inputName">State: <span class="red">*</span></label>
                <select name="state_id" id="state_id" class="form-control">
				<option value="">--select--</option>
				</select>
				 <span class="text-danger" id="err_state_id"></span>
              </div>
              <div class="form-group col-md-6">
                <label for="inputName">City: <span class="red">*</span></label>
                <select name="city_id" id="city_id" class="form-control">
				<option value="">--select--</option>
				</select>
				 <span class="text-danger" id="err_city_id"></span>
              </div>
               <div class="form-group col-md-6">
                <label for="inputName">Zip Code: <span class="red">*</span></label>
                <input type="text" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" class="form-control"   />
                  <span class="text-danger" id="err_zip_code"></span>
				  
				  <input type="hidden" id="status" name="status" value="1"  />
              </div>
			  
            </div>
			
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <button type="submit" class="btn btn-success float-right">Create</button>
        </div>
      </div>
    </form>
      </div>
     
    </div>

  </div>
</div>

    </section>
    <!-- /.content -->
@endsection
@section('scripts')
@include('inc.citystatecountryjs')
<script type="text/javascript">
    var path = "{{ route('auto.agent') }}";
  
    $( "#agent_id" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
               search: request.term
            },
            success: function( data ) {
               response( data );
            }
          });
        },
		
        select: function (event, ui) {
           $('#agent_id').val(ui.item.label);
           //console.log(ui.item); 
		   $('#agent_id_select').val(ui.item.value);
		    $('#agent_details').html(ui.item.agentDetails);
           return false;
        },
        change: function(event, ui){
            // Clear the input field if the user doesn't select an option
            if (ui.item == null){
                $('#agent_id').val('');
				 $('#agent_id_select').val('');
				 $('#agent_details').html('');
            }
        }
      });
  
  var pathcustomer = "{{ route('auto.customer') }}";
  
    $( "#customer_id" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: pathcustomer,
            type: 'GET',
            dataType: "json",
            data: {
               search: request.term
            },
            success: function( data ) {
               response( data );
            }
          });
        },
        select: function (event, ui) {
           $('#customer_id').val(ui.item.label);
           //console.log(ui.item); 
		   $('#customer_id_select').val(ui.item.value);
		    $('#cus_details').html(ui.item.cusDetails);
           return false;
        },
        change: function(event, ui){
            // Clear the input field if the user doesn't select an option
            if (ui.item == null){
                $('#customer_id').val('');
				 $('#customer_id_select').val('');
				 $('#cus_details').html('');
            }
        }
      });
	  
	$(document).ready(function() {
		if($('#is_flight').find(":selected").val() == 1)
		{
		$('.flight_is_div').css('display','block');
		}else{
			$('.flight_is_div').css('display','none');
		}
  
		$('#is_flight').change(function() {
			var selectedOption = $(this).val(); // Get the selected option value
			if(selectedOption==1){
				 $('.flight_is_div').css('display','block');
			}else{
				 $('.flight_is_div').css('display','none');
			}
		});
	});
	
	$(document).ready(function() {
  $('body #newCustomerForm').on('submit', function(e) {
    e.preventDefault(); // Prevent the form from submitting normally
    
    var formData = $(this).serialize(); // Serialize the form data
    
    // Send an Ajax request to the controller method
    $.ajax({
      url: $(this).attr('action'),
      type: 'POST',
      data: formData,
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          // Display a success message
          $('#message').html(response.message);
          $('#message').removeClass('text-danger').addClass('text-success');
		  $('.text-danger').html('');
		  $('#newCustomerForm')[0].reset();
		  //$('#myModal').modal('hide');
        }
      },
      error: function(response) {
        if (response.status === 422) {
          // Display validation errors
          var errors = response.responseJSON.errors;
          var errorHtml = '';
          $.each(errors, function(field, messages) {
			  $('#err_'+field).html(messages[0]);
          });
          
          $('#message').html('Please correct the errors below.');
          $('#message').removeClass('text-success').addClass('text-danger');
        } else {
          // Display a general error message
          $('#message').html('Error: ' + response.responseText);
          $('#message').removeClass('text-success').addClass('text-danger');
        }
      }
    });
  });
});
</script>


@endsection