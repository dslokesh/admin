@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Agent Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('agents.index') }}">Agents</a></li>
              <li class="breadcrumb-item active">Agent Add</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('agents.store') }}" method="post" class="form" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add Agent</h3>
            </div>
            <div class="card-body row">
			 <div class="form-group col-md-6">
                <label for="inputName">Company Name:</label>
                <input type="text" id="company_name	" name="company_name" value="{{ old('company_name')}}" class="form-control"  placeholder="Company Name" />
                @if ($errors->has('company_name'))
                    <span class="text-danger">{{ $errors->first('company_name') }}</span>
                @endif
              </div>
                <div class="form-group col-md-6">
                <label for="inputName">First Name: <span class="red">*</span></label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" class="form-control"  placeholder="First Name" />
                @if ($errors->has('first_name'))
                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                @endif
              </div>
			<div class="form-group col-md-6">
                <label for="inputName">Last Name: <span class="red">*</span></label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" class="form-control"  placeholder="Last Name" />
                @if ($errors->has('last_name'))
                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                @endif
              </div>
			  
                <div class="form-group col-md-6">
                <label for="inputName">Mobile: <span class="red">*</span></label>
                <input type="text" id="mobile" name="mobile" value="{{ old('mobile') }}" class="form-control"  placeholder="Mobile" />
                @if ($errors->has('mobile'))
                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control"  placeholder="Email" />
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-6">
                <label for="inputName">Password: <span class="red">*</span></label>
                <input type="button" class="generate-pass button" value="Generate" onClick="randomPassword(10);" />
                <input type="password" id="password" name="password" value="{{ old('password') }}" class="form-control pass"  placeholder="Password" /><i class="far fa-eye" id="togglePassword"></i>
                @if ($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
              </div>
			    <div class="form-group col-md-6">
                <label for="inputName">Image: <span class="red">*</span></label>
                <input type="file" id="image" name="image"  class="form-control"  />
                @if ($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
				
              </div>
			 
			   <div class="form-group col-md-6">
                <label for="inputName">Department:</label>
                <input type="text" id="department" name="department" value="{{ old('department') }}" class="form-control"  placeholder="Department" />
                @if ($errors->has('department'))
                    <span class="text-danger">{{ $errors->first('department') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">Phone Number:</label>
                <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" class="form-control"  placeholder="Phone Number" />
                @if ($errors->has('phone_number'))
                    <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                @endif
              </div>
                <div class="form-group col-md-6">
                <label for="inputName">Address: <span class="red">*</span></label>
                <input type="text" id="address" name="address" value="{{ old('address') }}" class="form-control"  placeholder="Address" />
                @if ($errors->has('address'))
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                @endif
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
                <label for="inputName">State: <span class="red">*</span></label>
                <select name="state_id" id="state_id" class="form-control">
				<option value="">--select--</option>
				</select>
              </div>
              <div class="form-group col-md-6">
                <label for="inputName">City: <span class="red">*</span></label>
                <select name="city_id" id="city_id" class="form-control">
				<option value="">--select--</option>
				</select>
              </div>
               <div class="form-group col-md-6">
                <label for="inputName">Zip Code: <span class="red">*</span></label>
                <input type="text" id="postcode" name="postcode" value="{{ old('postcode') }}" class="form-control"   />
                @if ($errors->has('postcode'))
                    <span class="text-danger">{{ $errors->first('postcode') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">Vat:</label>
                <input type="text" id="vat" name="vat" value="{{ old('vat') }}" class="form-control"   />
                @if ($errors->has('vat'))
                    <span class="text-danger">{{ $errors->first('vat') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-6">
                <label for="inputName">Ticket Only%:</label>
                <input type="text" id="ticket_only" name="ticket_only"  value="{{ old('ticket_only')}}" class="form-control"   />
                @if ($errors->has('ticket_only'))
                    <span class="text-danger">{{ $errors->first('ticket_only') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">SIC Transfer%:</label>
                <input type="text" id="sic_transfer" name="sic_transfer"  value="{{ old('sic_transfer') }}" class="form-control"   />
                @if ($errors->has('sic_transfer'))
                    <span class="text-danger">{{ $errors->first('sic_transfer') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">PVT Transfer%:</label>
                <input type="text" id="pvt_transfer" name="pvt_transfer"  value="{{ old('pvt_transfer')}}" class="form-control"   />
                @if ($errors->has('pvt_transfer'))
                    <span class="text-danger">{{ $errors->first('pvt_transfer') }}</span>
                @endif
              </div>
			  
			   <div class="form-group col-md-6">
                <label for="inputName">Status: <span class="red">*</span></label>
                <select name="status" id="status" class="form-control">
                    <option value="1" @if(old('status') ==1) {{'selected="selected"'}} @endif>Active</option>
					          <option value="0" @if(old('status') ==0) {{'selected="selected"'}} @endif >Inactive</option>
                 </select>
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
						<tr>
						  <td><input type="text" class="form-control" name="a_name[]"></td>
						  <td><input type="text" class="form-control" name="a_department[]"></td>
						  <td><input type="text" class="form-control" name="a_mobile[]"></td>
						  <td><input type="text" class="form-control" name="a_phone[]"></td>
						  <td><input type="text" class="form-control" name="a_email[]"></td>
						  <td></td>
						</tr>
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
          <button type="submit" class="btn btn-success float-right">Create</button>
        </div>
      </div>
    </form>
    </section>
    <!-- /.content -->
 <!-- Script -->
  
@endsection
 
@section('scripts')
 @include('inc.citystatecountryjs')
 <script>
 $(document).ready(function() {
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

 
 