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
                <label for="inputName">Date Of Birth:</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') ?: $user->date_of_birth }}" class="form-control"  placeholder="Date Of Birth" />
              </div>
              <div class="form-group">
                <label for="inputName">Position:</label>
                <input type="text" id="position" name="position" value="{{ old('position') ?: $user->position }}" class="form-control"  placeholder="Position" />
                @if ($errors->has('position'))
                    <span class="text-danger">{{ $errors->first('position') }}</span>
                @endif
              </div>
			  @if($user->roles[0]->name == "Technician") 
              <div class="form-group">
                <label for="inputName">Company:</label>
                  <select name="company_id" id="company_id" class="form-control">
                      <option value = "">-Select Company-</option>
                      @foreach($companies as $company)
                        <option value="{{ $company->id }}" @if(($company->id == old('company_id')) OR ($company->id == $user->company_id)) selected="selected" @endif >{{ $company->name }}</option>
                      @endforeach
                  </select>
                </div>
				@endif
              <div class="form-group">
                <label for="inputName">Job Title:</label>
                <input type="text" id="job_title" name="job_title" value="{{ old('job_title') ?: $user->job_title }}" class="form-control"  placeholder="Job Title" />
                @if ($errors->has('job_title'))
                    <span class="text-danger">{{ $errors->first('job_title') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="inputName">Delivery Address:</label>
                <textarea name="delivery_address" id="delivery_address" class="form-control"placeholder="Delivery Address" >{{ old('delivery_address') ?: $user->delivery_address }}</textarea>
                @if ($errors->has('delivery_address'))
                    <span class="text-danger">{{ $errors->first('delivery_address') }}</span>
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

              @if($user->roles[0]->name == "Technician")  
              <div class="form-group">
                <label for="inputName">Newsletter Subscription:</label>
                <input type="checkbox" id="is_newsletter" name="is_newsletter" class="icheck-primary d-inline" @if((old('is_newsletter') == 'on') OR ($user->is_newsletter == 1)) checked @endif  />
              </div>
              <div class="form-group">
                <label for="inputName">Notification Enabled:</label>
                <input type="checkbox" id="is_notification" name="is_notification" class="icheck-primary d-inline" @if((old('is_notification') == 'on') OR ($user->is_notification == 1)) checked @endif  />
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