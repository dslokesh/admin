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
                <div class="form-group col-md-6">
                <label for="inputName">Title: <span class="red">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control"  placeholder="Title" />
                @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
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
			 
			    <div class="form-group col-md-6">
                <label for="inputName">Image:</label>
                <input type="file" id="image" name="image"  class="form-control"  />
                @if ($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
				
              </div>
			 <div class="form-group col-md-12">
                <label for="inputName">Status: <span class="red">*</span></label>
                <select name="status" id="status" class="form-control">
                    <option value="1" @if(old('status') ==1) {{'selected="selected"'}} @endif>Active</option>
					          <option value="0" @if(old('status') ==0) {{'selected="selected"'}} @endif >Inactive</option>
                 </select>
              </div>
                <div class="form-group col-md-12">
                <label for="inputName">Description: <span class="red">*</span></label>
				
                <textarea placeholder="Description" name="description" cols="50" rows="10" id="content" class="form-control box-size text-editor">{{ old('description') }}</textarea>
                @if ($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
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
          <a href="{{ route('activities.index') }}" class="btn btn-secondary">Cancel</a>
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

 
 
