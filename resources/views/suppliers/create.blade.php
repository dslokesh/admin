@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Supplier Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('suppliers.index') }}">Suppliers</a></li>
              <li class="breadcrumb-item active">Supplier Add</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('suppliers.store') }}" method="post" class="form" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add Supplier</h3>
            </div>
            <div class="card-body row">
                <div class="form-group col-md-6">
                <label for="inputName">Name: <span class="red">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control"  placeholder="Name" />
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
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
                <label for="inputName">Logo: <span class="red">*</span></label>
                <input type="file" id="logo" name="logo"  class="form-control"  />
                @if ($errors->has('logo'))
                    <span class="text-danger">{{ $errors->first('logo') }}</span>
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
                <input type="text" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" class="form-control"   />
                @if ($errors->has('zip_code'))
                    <span class="text-danger">{{ $errors->first('zip_code') }}</span>
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
          <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-success float-right">Create</button>
        </div>
      </div>
    </form>
    </section>
    <!-- /.content -->
@endsection
 @include('inc.citystatecountryjs')
