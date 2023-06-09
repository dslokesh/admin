@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Agent Edit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('agents.index') }}">Agents</a></li>
              <li class="breadcrumb-item active">Agent Edit</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('agents.update', $record->id) }}" method="post" class="form" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="put">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit Agent</h3>
            </div>
            <div class="card-body row">
			 <div class="form-group col-md-6">
                <label for="inputName">Company Name:</label>
                <input type="text" id="company_name	" name="company_name" value="{{ old('company_name') ?: $record->company_name }}" class="form-control"  placeholder="Company Name" />
                @if ($errors->has('company_name'))
                    <span class="text-danger">{{ $errors->first('company_name') }}</span>
                @endif
              </div>
              <div class="form-group col-md-6">
                <label for="inputName">First Name: <span class="red">*</span></label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name') ?: $record->name }}" class="form-control"  placeholder="First Name" />
                @if ($errors->has('first_name'))
                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                @endif
              </div>
			<div class="form-group col-md-6">
                <label for="inputName">Last Name: <span class="red">*</span></label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name') ?: $record->lname }}" class="form-control"  placeholder="Last Name" />
                @if ($errors->has('last_name'))
                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                @endif
              </div>
			   
               <div class="form-group col-md-6">
                <label for="inputName">Mobile: <span class="red">*</span></label>
                <input type="text" id="mobile" name="mobile" value="{{ old('mobile') ?: $record->mobile }}" class="form-control"  placeholder="Mobile" />
                @if ($errors->has('mobile'))
                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email') ?: $record->email }}" class="form-control"  placeholder="Email" />
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
              </div>
			 
				  
			  @if($record->image)
			  <div class="form-group col-md-4">
			@else
				<div class="form-group col-md-6">
				@endif
                <label for="inputName">Image: <span class="red">*</span></label>
                <input type="file" id="image" name="image"  class="form-control"   />
                @if ($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
              </div>
			   @if($record->image)
              <div class="form-group col-md-2">
                <img src="{{ url('/uploads/users/thumb/'.$record->image) }}" width="50"  alt="airlines-logo" />
              </div>
              @endif
			  <div class="form-group col-md-6">
                     <label for="inputName">Password </label>
                     <input type="password" class="form-control" id="password" name="password" placeholder="password" value="" >
                     @if ($errors->has('password'))
                     <span class="text-danger">{{ $errors->first('password') }}</span>
                     @endif
                  </div>
                  <div class="form-group col-md-6">
                     <label for="inputName">Confirm Password </label>
                     <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" value="" >
                     @if ($errors->has('password_confirmation'))
                     <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                     @endif
                  </div>
			   <div class="form-group col-md-6">
                <label for="inputName">Department:</label>
                <input type="text" id="department" name="department" value="{{ old('department') ?: $record->department }}" class="form-control"  placeholder="Department" />
                @if ($errors->has('department'))
                    <span class="text-danger">{{ $errors->first('department') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">Phone Number:</label>
                <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') ?: $record->phone }}" class="form-control"  placeholder="Phone Number" />
                @if ($errors->has('phone_number'))
                    <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                @endif
              </div>
                <div class="form-group col-md-6">
                <label for="inputName">Address: <span class="red">*</span></label>
                <input type="text" id="address" name="address" value="{{ old('address') ?: $record->address }}" class="form-control"  placeholder="Address" />
                @if ($errors->has('address'))
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                @endif
              </div>
             
			<div class="form-group col-md-6">
			  <label for="inputName">Country: <span class="red">*</span></label>
                <select name="country_id" id="country_id" class="form-control">
				<option value="">--select--</option>
				@foreach($countries as $country)
                    <option value="{{$country->id}}" @if($record->country_id == $country->id) {{'selected="selected"'}} @endif>{{$country->name}}</option>
				@endforeach
                 </select>
				 @if ($errors->has('country_id'))
                    <span class="text-danger">{{ $errors->first('country_id') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-6">
			  <label for="inputName">State: <span class="red">*</span></label>
                <select name="state_id" id="state_id" class="form-control">
				<option value="">--select--</option>
				@foreach($states as $state)
                    <option value="{{$state->id}}" @if($record->state_id == $state->id) {{'selected="selected"'}} @endif>{{$state->name}}</option>
				@endforeach
                 </select>
				 @if ($errors->has('state_id'))
                    <span class="text-danger">{{ $errors->first('state_id') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-6">
                <label for="inputName">City: <span class="red">*</span></label>
                <select name="city_id" id="city_id" class="form-control">
				<option value="">--select--</option>
        	@foreach($cities as $city)
                    <option value="{{$city->id}}" @if($record->city_id == $city->id) {{'selected="selected"'}} @endif>{{$city->name}}</option>
				@endforeach
				</select>
              </div>
               <div class="form-group col-md-6">
                <label for="inputName">Zip Code: <span class="red">*</span></label>
                <input type="text" id="postcode" name="postcode"  value="{{ old('postcode') ?: $record->postcode }}" class="form-control"   />
                @if ($errors->has('postcode'))
                    <span class="text-danger">{{ $errors->first('postcode') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">TRN No.:</label>
                <input type="text" id="vat" name="vat"  value="{{ old('vat') ?: $record->vat }}" class="form-control"   />
                @if ($errors->has('vat'))
                    <span class="text-danger">{{ $errors->first('vat') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">Ticket Only%:</label>
                <input type="text" id="ticket_only" name="ticket_only"  value="{{ old('ticket_only') ?: $record->ticket_only }}" class="form-control"   />
                @if ($errors->has('ticket_only'))
                    <span class="text-danger">{{ $errors->first('ticket_only') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">SIC Transfer%:</label>
                <input type="text" id="sic_transfer" name="sic_transfer"  value="{{ old('sic_transfer') ?: $record->sic_transfer }}" class="form-control"   />
                @if ($errors->has('sic_transfer'))
                    <span class="text-danger">{{ $errors->first('sic_transfer') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">PVT Transfer%:</label>
                <input type="text" id="pvt_transfer" name="pvt_transfer"  value="{{ old('pvt_transfer') ?: $record->pvt_transfer }}" class="form-control"   />
                @if ($errors->has('pvt_transfer'))
                    <span class="text-danger">{{ $errors->first('pvt_transfer') }}</span>
                @endif
              </div>
             <div class="form-group col-md-6">
                <label for="inputName">Agent Category:</label>
                <input type="text" id="agent_category" name="agent_category"  value="{{ old('agent_category') ?: $record->agent_category}}" class="form-control"   />
                @if ($errors->has('agent_category'))
                    <span class="text-danger">{{ $errors->first('agent_category') }}</span>
                @endif
              </div>
			 
			  <div class="form-group col-md-6">
                <label for="inputName">Sales Person:</label>
                <input type="text" id="sales_person" name="sales_person"  value="{{ old('sales_person') ?: $record->sales_person}}" class="form-control"   />
                @if ($errors->has('sales_person'))
                    <span class="text-danger">{{ $errors->first('sales_person') }}</span>
                @endif
              </div>
              <div class="form-group col-md-6">
                <label for="inputName">Status: <span class="red">*</span></label>
                <select name="status" id="status" class="form-control">
                    <option value="1" @if($record->is_active ==1) {{'selected="selected"'}} @endif>Active</option>
					          <option value="0" @if($record->is_active ==0) {{'selected="selected"'}} @endif >Inactive</option>
                 </select>
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName"> Agent Crrent Credit Limit (Amount):</label>
               <br/>{{ $record->agent_credit_limit}}
			   <br/>
                <a href="javascript:;" id="c_limit_btn" class="btn btn-secondary btn-sm">Change Limit</a>
				<div id="credit_limit_div" class="hide">
				<div class="row">
			   <div class="form-group col-md-4">
                <label for="inputName">Type: <span class="red">*</span></label>
                <select name="credit_limit_type" id="credit_limit_type" class="form-control">
					<option value="">Select</option>
                    <option value="1">Plus (+)</option>
					<option value="2" >Minus (-)</option>
                 </select>
              </div>
			  <div class="form-group col-md-8">
                <label for="inputName">Amount: <span class="red">*</span></label>
                 <input type="text" id="credit_amount" name="credit_amount"  value="0" class="form-control"   />
              </div>
			  </div>
			   </div>
              </div>
			   
			   <div class="form-group col-md-12">
                <label for="inputName">Additional Contact:</label>
				<a id="addRowBtn" class="btn btn-success btn-sm">Add Row</a>
                <table id="myTable" class="table table-bordered ">
					  <thead>
						<tr>
						  <th>Name</th>
						  <th>Department</th>
						  <th>Mobile</th>
						  <th>Phone</th>
						  <th>Email</th>
						</tr>
					  </thead>
					  <tbody>
					  @if(empty($agentAdditionalUsers))
						<tr>
						  <td><input type="text" class="form-control" name="a_name[]"></td>
						  <td><input type="text" class="form-control" name="a_department[]"></td>
						  <td><input type="text" class="form-control" name="a_mobile[]"></td>
						  <td><input type="text" class="form-control" name="a_phone[]"></td>
						  <td><input type="text" class="form-control" name="a_email[]"></td>
						  <td></td>
						</tr>
					@else
						 @foreach($agentAdditionalUsers as $k => $agentAdditionalUser)
							<tr>
						  <td><input type="text" class="form-control" value="{{$agentAdditionalUser->name}}" name="a_name[]"></td>
						  <td><input type="text" class="form-control" value="{{$agentAdditionalUser->department}}" name="a_department[]"></td>
						  <td><input type="text" class="form-control" value="{{$agentAdditionalUser->mobile}}" name="a_mobile[]"></td>
						  <td><input type="text" class="form-control" value="{{$agentAdditionalUser->phone}}" name="a_phone[]"></td>
						  <td><input type="text" class="form-control" value="{{$agentAdditionalUser->email}}" name="a_email[]"></td>
						  <td>@if($k > 0)<a class="removeRowBtn btn btn-danger btn-sm" >-</a>@endif</td>
						</tr>
						@endforeach
					@endif
					  </tbody>
					</table>

					
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12 pb-3">
          <a href="{{ route('agents.index') }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-success float-right">Update</button>
        </div>
      </div>
    </form>
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
 @include('inc.citystatecountryjs')
 <script>
 $(document).ready(function() {
	 $("#c_limit_btn").click(function() {
		 if ($('#credit_limit_div').hasClass('hide'))
		 {
			 $("#credit_limit_div").removeClass("hide").addClass("show");
			 $("#c_limit_btn").text("Cancel");
			 $('#credit_limit_type').prop("required",true);
			 $('#credit_amount').prop("required",true);
		 }
		 else if ($('#credit_limit_div').hasClass('show'))
		 {
			 $("#credit_limit_div").removeClass("show").addClass("hide");
			 $("#c_limit_btn").text("Change Limit");
			 $('#credit_limit_type').prop("required",false);
			 $('#credit_amount').prop("required",true);
		 }
		 
	 });
  // add row with input fields when "Add Row" button is clicked
  $("#addRowBtn").click(function() {
    // create new row
    var newRow = $("<tr>");
    
    // add cells to the row
    var nameCell = $("<td>").html('<input type="text" required class="form-control" name="a_name[]">');
    var departmentCell = $("<td>").html('<input type="text" class="form-control" name="a_department[]">');
    var mobileCell = $("<td>").html('<input type="text" class="form-control" name="a_mobile[]">');
	 var phoneCell = $("<td>").html('<input type="text" class="form-control" name="a_phone[]">');
	 var emailCell = $("<td>").html('<input type="text" class="form-control" name="a_email[]">');
    var actionsCell = $("<td>").html('<a class="removeRowBtn btn btn-danger btn-sm" >-</a>');
    
    // add cells to the row
    newRow.append(nameCell);
    newRow.append(departmentCell);
    newRow.append(mobileCell);
    newRow.append(phoneCell);
	newRow.append(emailCell);
	newRow.append(actionsCell);
    
    // add row to the table body
    $("#myTable tbody").append(newRow);
  });
  
  // remove row when "Remove" button is clicked
  $(document).on("click", ".removeRowBtn", function() {
    $(this).closest("tr").remove();
  });
});
</script>

@endsection