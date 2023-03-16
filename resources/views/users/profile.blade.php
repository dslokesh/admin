@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Edit Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('users.update', $user->id) }}" method="post" class="form" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="put">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit User</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">First Name: <span class="red">*</span></label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name') ?: $user->name }}" class="form-control"  placeholder="Name" />
                @if ($errors->has('first_name'))
                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                @endif
              </div>
			  <div class="form-group">
                <label for="inputName">Last Name: <span class="red">*</span></label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name') ?: $user->lname }}" class="form-control"  placeholder="Last name" />
                @if ($errors->has('last_name'))
                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="inputName">Mobile Number:</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') ?: $user->phone }}" class="form-control"  placeholder="Mobile Number" />
                @if ($errors->has('phone'))
                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="inputName">Email Address: <span class="red">*</span></label>
                <input type="text" id="email" name="email" value="{{ old('email') ?: $user->email }}" class="form-control"  placeholder="Email Address" />
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
              </div>
          
            
              <div class="form-group">
                <label for="inputName">Postcode:</label>
                <input type="text" id="postcode" name="postcode" value="{{ old('postcode') ?: $user->postcode }}" class="form-control"  placeholder="Postcode" />
                @if ($errors->has('postcode'))
                    <span class="text-danger">{{ $errors->first('postcode') }}</span>
                @endif
              </div>
              
              <div class="form-group">
                <label for="inputName">Profile Image:</label>
                <input type="file" name="image" id="image" class="form-control" /> 
                @if ($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
              </div>
              @if($user->image)
              <div class="form-group">
                <img src="{{ url('/uploads/users/thumb/'.$user->image) }}"  alt="profile-image" />
              </div>
              @endif

             
              <div class="form-group">
                <label for="inputName">Status: <span class="red">*</span></label>
                <select name="is_active" id="is_active" class="form-control">
                    <option value="1" @if($user->is_active ==1) {{'selected="selected"'}} @endif>Active</option>
					          <option value="0" @if($user->is_active ==0) {{'selected="selected"'}} @endif >Inactive</option>
                 </select>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-success float-right">Update</button>
        </div>
      </div>
    </form>
    </section>
    <!-- /.content -->
@endsection