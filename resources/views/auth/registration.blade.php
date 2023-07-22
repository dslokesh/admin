@extends('layouts.signUp')
  
@section('content')
<main class="login-form">
  <div class="cotainer">
      <div class="row justify-content-center">
          <div class="col-md-12">
              <div class="card">
                 
                  <div class="card-body">
  
                      <form action="{{ route('register.post') }}" method="post" class="form" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
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
                <input type="text" id="mobile" name="mobile" required value="{{ old('mobile') }}" class="form-control"  placeholder="Mobile" />
                @if ($errors->has('mobile'))
                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">Email: <span class="red">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required class="form-control"  placeholder="Email" />
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
              </div>
			 
                <div class="form-group col-md-6">
                <label for="inputName">Address: <span class="red">*</span></label>
                <input type="text" id="address" name="address" value="{{ old('address') }}" class="form-control" required placeholder="Address" />
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
              <div class="form-group col-md-12">
                <label for="inputName">Referred By:</label>
                <input type="text" id="sales_person" name="sales_person" value="{{ old('sales_person') }}" class="form-control"   />
                @if ($errors->has('sales_person'))
                    <span class="text-danger">{{ $errors->first('sales_person') }}</span>
                @endif
              </div>
			  
            </div>
			
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-6 pt-3">
          
          <button type="submit" class="btn btn-lg btn-success float-right">Sign Up</button>

        
        </div>
        <div class="col-6 pt-3">
          
       

          <a href="{{ route('login') }}" class="btn btn-lg btn-info  float-right">Back</a>
        </div>
      </div>
    </form>
                      </form>
                        
                  </div>
              </div>
          </div>
      </div>
  </div>
</main>
@endsection
@section('scripts')
 @include('inc.citystatecountryjs')
 @endsection