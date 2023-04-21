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
                <label for="inputName">Code: <span class="red">*</span></label>
                <input type="text" id="code" name="code" value="{{ old('code') }}" class="form-control"  placeholder="Name" />
                @if ($errors->has('code'))
                    <span class="text-danger">{{ $errors->first('code') }}</span>
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
                <label for="inputName">Company Name:</label>
                <input type="text" id="company_name	" name="company_name" value="{{ old('company_name')}}" class="form-control"  placeholder="Company Name" />
                @if ($errors->has('company_name'))
                    <span class="text-danger">{{ $errors->first('company_name') }}</span>
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
@endsection
@section('scripts')
 <!-- Script -->
 <script type="text/javascript">
    function randomPassword(length) {
        var chars = "abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890";
        var pass = "";
        for (var x = 0; x < length; x++) {
            var i = Math.floor(Math.random() * chars.length);
            pass += chars.charAt(i);
        }
       // myform.row_password.value = pass;
        $('#password').val(pass);
    }

    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
  
    togglePassword.addEventListener('click', function (e) {
      // toggle the type attribute
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      // toggle the eye slash icon
      this.classList.toggle('fa-eye-slash');
  });
       

   
  </script>   
  
@include('inc.citystatecountryjs')

 
 
