@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $agent->name }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('agents.index') }}">Agents</a></li>
              <li class="breadcrumb-item active">Agent Details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-md-12">
		
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">{{ $agent->name }}</h3>
            </div>
			
			<div class="card-body">
			
			
			<header class="profile-header">
          <div class="profile-image"> @if(!empty($agent->image))<img src="{{asset('uploads/users/thumb/'.$agent->image)}}"  />@endif </div>
			
				<div class="profile-content">
					<div class="row">
              
			 
			      <div class="col-lg-6 mb-3">
                <label for="inputName">Email:</label>
                {{ $agent->email }}
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Code:</label>
                {{ $agent->code }}
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Mobile:</label>
                {{ $agent->mobile }}
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Company Name:</label>
                {{ $agent->company_name }}
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Department:</label>
                {{ $agent->department }}
              </div>
			   <div class="col-lg-6 mb-3">
                <label for="inputName">Phone Number:</label>
                {{ $agent->phone_number }}
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Address:</label>
                {{ $agent->address }}
              </div>
              <div class="form-group col-lg-6 mb-3">
                <label for="inputName">City:</label>
                {{$agent->city->name}}
              </div>
			  <div class="form-group col-lg-6 mb-3">
                <label for="inputName">State:</label>
                {{$agent->state->name}}
              </div>
              <div class="form-group col-lg-6 mb-3">
                <label for="inputName">Country:</label>
                {{$agent->country->name}}
              </div>
              <div class="form-group col-lg-6 mb-3">
                <label for="inputName">Postcode:</label>
                {{$agent->postcode}}
              </div>
             
              <div class="form-group col-lg-6 mb-3">
			        <label for="inputName">Status:</label>
					{!! SiteHelpers::statusColor($agent->is_active) !!}
              </div>
            
          </div>	
				</div>
          
			
				</header>
		
			
          <!-- /.card-body --> 
        </div>
		
           
          </div>
          <!-- /.card -->
        </div>
      </div>
  
    </section>
    <!-- /.content -->
@endsection



@section('scripts')


@endsection