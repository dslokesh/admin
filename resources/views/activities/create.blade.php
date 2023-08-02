@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Activity Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('activities.index') }}">Activities</a></li>
              <li class="breadcrumb-item active">Activity Add</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('activities.store') }}" method="post" class="form" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add Activity</h3>
            </div>
            <div class="card-body row">
                <div class="form-group col-md-4">
                <label for="inputName">Title: <span class="red">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control"  placeholder="Title" />
                @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
              </div>
			
			  <div class="form-group col-md-4">
                <label for="inputName">Code: <span class="red">*</span></label>
                <input type="text" id="code" name="code" value="{{ old('code') }}" class="form-control"  placeholder="Name" />
                @if ($errors->has('code'))
                    <span class="text-danger">{{ $errors->first('code') }}</span>
                @endif
              </div>
                
				<div class="form-group col-md-4">
                <label for="inputName">Type of Activity: <span class="red">*</span></label>
                <select name="type_activity" id="type_activity" class="form-control">
				<option value="">--select--</option>
				@foreach($typeActivities as $key => $typeActivityName)
                    <option value="{{$key}}" @if(old('type_activity') == $key) {{'selected="selected"'}} @endif>{{$typeActivityName}}</option>
				@endforeach
                 </select>
				 @if ($errors->has('type_activity'))
                    <span class="text-danger">{{ $errors->first('type_activity') }}</span>
                @endif
              </div>
			  
			   <div class="form-group col-md-4">
                <label for="inputName">Entry Type: <span class="red">*</span></label>
                <select name="entry_type" id="entry_type" class="form-control">
				<option value="">--select--</option>
                   <option value="Ticket Only" @if(old('entry_type') =='Ticket Only') {{'selected="selected"'}} @endif>Ticket Only</option>
					<option value="Tour" @if(old('entry_type') == 'Tour') {{'selected="selected"'}} @endif >Tour</option>
          <option value="Tour" @if(old('entry_type') == 'Arrival') {{'selected="selected"'}} @endif >Arrival</option>
          <option value="Tour" @if(old('entry_type') == 'Departure') {{'selected="selected"'}} @endif >Departure</option>
          <option value="Tour" @if(old('entry_type') == 'Interhotel') {{'selected="selected"'}} @endif >Interhotel</option>
                 </select>
				 @if ($errors->has('entry_type'))
                    <span class="text-danger">{{ $errors->first('entry_type') }}</span>
                @endif
              </div>
			  
			   <div class="form-group col-md-4">
                <label for="inputName">Vat %:</label>
                <select  id="vat" name="vat" class="form-control">
				<option value="">--select--</option>
                    <option value="5" @if(old('vat') == 5) {{'selected="selected"'}} @endif>5</option>
                 </select>
				 @if ($errors->has('vat'))
                    <span class="text-danger">{{ $errors->first('vat') }}</span>
                @endif
              </div>
			  
			  
			  
			   <div class="form-group col-md-4">
                <label for="inputName">Is Open Dated: <span class="red">*</span></label>
                <select name="is_opendated" id="is_opendated" class="form-control">
                    <option value="1" @if(old('is_opendated') ==1) {{'selected="selected"'}} @endif>Yes</option>
					          <option value="0" @if(old('is_opendated') ==0) {{'selected="selected"'}} @endif >No</option>
                 </select>
              </div>
			  <div class="form-group col-md-4" id="valid_till_div">
                <label for="inputName">Valid Till (in Days from Date of Booking): <span class="red">*</span></label>
                <input type="text" id="valid_till" name="valid_till" value="{{ old('valid_till') }}" class="form-control"  placeholder="In Days from Date of Booking" />
                @if ($errors->has('valid_till'))
                    <span class="text-danger">{{ $errors->first('valid_till') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-4">
                <label for="inputName">Pvt TFRS: <span class="red">*</span></label>
                <select name="pvt_TFRS" id="pvt_TFRS" class="form-control">
                    <option value="1" @if(old('pvt_TFRS') ==1) {{'selected="selected"'}} @endif>Yes</option>
					          <option value="0" @if(old('pvt_TFRS') ==0) {{'selected="selected"'}} @endif >No</option>
                 </select>
              </div>
			   <div class="form-group col-md-4" id="transfer_plan_div">
                <label for="inputName">Transfer Plan: <span class="red">*</span></label>
                <select name="transfer_plan" id="transfer_plan" class="form-control">
				<option value="">--select--</option>
				@foreach($transfers as $transfer)
                    <option value="{{$transfer->id}}" @if(old('transfer_plan') == $transfer->id) {{'selected="selected"'}} @endif>{{$transfer->name}}</option>
				@endforeach
                 </select>
				 @if ($errors->has('transfer_plan'))
                    <span class="text-danger">{{ $errors->first('transfer_plan') }}</span>
                @endif
              </div>
			    <div class="form-group col-md-12">
                <label for="inputName">Black Out/Sold Out Date(separate By Comma YYYY-MM-DD): <span class="red">*</span></label>
                <input type="text" id="black_sold_out" name="black_sold_out" value="{{ old('black_sold_out') }}" class="form-control"  placeholder="Black Out/Sold Out Date" />
                @if ($errors->has('black_sold_out'))
                    <span class="text-danger">{{ $errors->first('black_sold_out') }}</span>
                @endif
              </div>
			  <div class="col-sm-12">
				<label for="inputName">Availability: <span class="red">*</span></label>
					<div class="form-group clearfix">
					<div class="icheck-primary d-inline">
					<input type="checkbox" id="allDaysCheckbox" name="AllDay" value="All" >
					<label for="checkboxPrimary1">All Days</label>
					</div>
					<div class="icheck-primary d-inline">
					<input type="checkbox" id="checkboxMonday" value="Monday" name="day[0]"  >
					<label for="checkboxPrimary1">Monday</label>
					</div>
					<div class="icheck-primary d-inline">
					<input type="checkbox" id="checkboxTuesday" value="Tuesday" name="day[1]" >
					<label for="checkboxPrimary1">Tuesday</label>
					</div>
					<div class="icheck-primary d-inline">
					<input type="checkbox" id="checkboxPrimary1" value="Wednesday" name="day[2]">
					<label for="checkboxPrimary1">Wednesday</label>
					</div>
					<div class="icheck-primary d-inline">
					<input type="checkbox" id="checkboxPrimary1" value="Thursday" name="day[3]">
					<label for="checkboxPrimary1">Thursday</label>
					</div>
					<div class="icheck-primary d-inline">
					<input type="checkbox" id="checkboxPrimary1" value="Friday" name="day[4]" >
					<label for="checkboxPrimary1">Friday</label>
					</div>
					<div class="icheck-primary d-inline">
					<input type="checkbox" id="checkboxPrimary1" value="Saturday" name="day[5]" >
					<label for="checkboxPrimary1">Saturday</label>
					</div>
					<div class="icheck-primary d-inline">
					<input type="checkbox" id="checkboxPrimary1" value="Sunday" name="day[6]">
					<label for="checkboxPrimary1">Sunday</label>
					</div>
					</div>
			</div>
			<div class="form-group col-md-6">
                <label for="inputName">SIC TFRS: <span class="red">*</span></label>
                <select name="sic_TFRS" id="sic_TFRS" class="form-control">
                    <option value="1" @if(old('sic_TFRS') ==1) {{'selected="selected"'}} @endif>Yes</option>
					          <option value="0" @if(old('sic_TFRS') ==0) {{'selected="selected"'}} @endif >No</option>
                 </select>
              </div>
			<div class="form-group col-md-6" id="zones_div">
                <label for="inputName"></label>
				<table id="myTable" class="table">
					  <tr>
						<th>Zone</th>
						<th>Value</th>
						<th>Pick Up Time</th>
						<th>Drop Up Time</th>
						<th><a id="add-row" class="btn btn-success btn-sm">Add </a></th>
					  </tr>
					  <tr>
						<td> <select name="zones[]" id="zones" class="form-control">
				<option value="">--select--</option>
				@foreach($zones as $zone)
                    <option value="{{$zone->id}}" >{{$zone->name}}</option>
				@endforeach
                 </select></td>
						<td><input type="text" id="zone_val" class="form-control" name="zoneValue[]"></td>
						<td><input type="text" id="pickup_time" value="" class="form-control " name="pickup_time[]"></td>
						<td><input type="text" id="dropup_time" value="" class="form-control " name="dropup_time[]"></td>
						<td></td>
					  </tr>
					
					</table>
					
				
              </div>
			  <!--form-group-->
              <div class="form-group col-md-12">
                  <label for="featured_image">Featured Image</label>
                  <input type="file" class="form-control" name="featured_image" accept="image/x-png,image/gif,image/jpeg">
                  @if ($errors->has('featured_image'))
                      <span class="text-danger">{{ $errors->first('featured_image') }}</span>
                  @endif
                </div>
			<!--form-group-->
              <div class="form-group col-md-12">
                  <label for="featured_image">Brand Logo</label>
                  <input type="file" class="form-control" name="brand_logo" accept="image/x-png,image/gif,image/jpeg">
                  @if ($errors->has('brand_logo'))
                      <span class="text-danger">{{ $errors->first('brand_logo') }}</span>
                  @endif
                </div>
			   <div class="form-group col-md-12">
                  <label for="featured_image">Images</label>
                  <div class="control-group">
                    <div class="file-loading">
                        <input id="image" type="file" name="image[]" data-min-file-count="0" multiple>
                    </div>
                  </div>
                @if($errors->has('image'))
                  <div class="col-md-12"><span class="text-danger">{{ $errors->first('image') }}</span></div>
                @endif
              </div><!--form control--> 
			   <div class="form-group col-md-12">
                <label for="inputName">Description: <span class="red">*</span></label>
				
                <textarea placeholder="Description" name="description" cols="50" rows="10" id="content" class="form-control box-size text-editor">{{ old('description') }}</textarea>
                @if ($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">Inclusion:</label>
				
                <textarea placeholder="Inclusion" id="inclusion" name="inclusion" cols="50" rows="10" id="inclusion" class="form-control box-size short-text-editor">{{ old('inclusion') }}</textarea>
                @if ($errors->has('inclusion'))
                    <span class="text-danger">{{ $errors->first('inclusion') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">Important Information: </label>
				
                <textarea placeholder="Exclusion" name="exclusion" cols="50" rows="10" id="exclusion" class="form-control box-size short-text-editor2">{{ old('exclusion') }}</textarea>
                @if ($errors->has('exclusion'))
                    <span class="text-danger">{{ $errors->first('exclusion') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-12">
                <label for="inputName">Cancellation Policy: </label>
				
                <textarea placeholder="Cancellation Policy" name="cancellation_policy" cols="50" rows="10" id="cancellation_policy" class="form-control box-size short-text-editor3">{{ old('cancellation_policy') }}</textarea>
                @if ($errors->has('cancellation_policy'))
                    <span class="text-danger">{{ $errors->first('cancellation_policy') }}</span>
                @endif
              </div>
			  
			 <div class="form-group col-md-12">
                <label for="inputName">Status: <span class="red">*</span></label>
                <select name="status" id="status" class="form-control">
                    <option value="1" @if(old('status') ==1) {{'selected="selected"'}} @endif>Active</option>
					          <option value="0" @if(old('status') ==0) {{'selected="selected"'}} @endif >Inactive</option>
                 </select>
              </div>
               
             
			 
			 
			  
            </div>
			
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-12 mb-3">
          <a href="{{ route('activities.index') }}" class="btn btn-secondary">Cancel</a>
		<button type="submit" name="save_and_continue" class="btn btn-success float-right  ml-3">Save and Continue</button>
		   <button type="submit" name="save" class="btn btn-primary float-right">Save</button>
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
  // Hide the text input initially
  if($('#is_opendated').find(":selected").val() == 0)
  {
	   $('#valid_till_div').hide();
  }
  if($('#pvt_TFRS').find(":selected").val() == 0)
  {
	   $('#transfer_plan_div').hide();
  }
  if($('#sic_TFRS').find(":selected").val() == 0)
  {
	   $('#zones_div').hide();
  }
 
  
 
  
  // Attach change event handler to the checkbox input
  $('#is_opendated').on('change', function() {
    // If the checkbox is checked, show the text input
    if ($(this).val()==1) {
      $('#valid_till_div').show();
	  $('#valid_till').prop('required', true);
    } else {
      // Otherwise, hide the text input
	  $('#valid_till').prop('required', false);
      $('#valid_till_div').hide();
    }
  });
  
  $('#pvt_TFRS').on('change', function() {
    // If the checkbox is checked, show the text input
    if ($(this).val()==1) {
      $('#transfer_plan_div').show();
	  $('#transfer_plan').prop('required', true);
    } else {
      // Otherwise, hide the text input
	  $('#transfer_plan').prop('required', false);
      $('#transfer_plan_div').hide();
    }
  });
  
  
  
  $('#allDaysCheckbox').on('change', function() {
    // If the "All Days" checkbox is checked, disable other day checkboxes
    if ($(this).is(':checked')) {
      $('input[type="checkbox"]').not(this).prop('disabled', true);
    } else {
      // Otherwise, enable other day checkboxes
      $('input[type="checkbox"]').not(this).prop('disabled', false);
    }
  });
  
  $('#sic_TFRS').on('change', function() {
    // If the checkbox is checked, show the text input
    if ($(this).val()==1) {
      $('#zones_div').show();
	  $('#zones').prop('required', true);
	  $('#zone_val').prop('required', true);
    } else {
      // Otherwise, hide the text input
	  $('#zones').prop('required', false);
	  $('#zone_val').prop('required', false);
      $('#zones_div').hide();
    }
  });
  
  // Add Row
$("#add-row").on("click", function() {
	$('.timepicker').datetimepicker({
				format: 'hh:mm a'
			});
  var newRow = $("<tr>");
  var cols = "";
  cols += '<td><select name="zones[]"  class="form-control"><option value="">--select--</option>@foreach($zones as $zone)<option value="{{$zone->id}}" >{{$zone->name}}</option>@endforeach                </select></td>';
  cols += '<td><input type="text"  class="form-control" name="zoneValue[]"></td>';
   cols += '<td><input type="text"  class="form-control " name="pickup_time[]"></td>';
  cols += '<td><input type="text"  class="form-control " name="dropup_time[]"></td>';
  cols += '<td><a class="delete-row btn btn-danger btn-sm">Delete</a></td>';
  newRow.append(cols);
  $("#myTable").append(newRow);
  $('#myTable .timepicker').datetimepicker({
				format: 'hh:mm a'
			});
});

// Remove Row
$("#myTable").on("click", ".delete-row", function() {
  $(this).closest("tr").remove();
});

 $("#image").fileinput({
        theme: 'fa',
        allowedFileExtensions: ['jpg', 'png','jpeg'],
        overwriteInitial: false,
        maxFileCount: 5,
        showUpload:false
    });
});
       

   
  </script>   
  @include('inc.ckeditor')
@endsection
 
 
