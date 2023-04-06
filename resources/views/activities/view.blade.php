@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Activity : {{ $activity->title }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('activities.index') }}">Activities</a></li>
              <li class="breadcrumb-item active">Activity Details</li>
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
              <h3 class="card-title">{{ $activity->title }}</h3>
            </div>
			
			<div class="card-body">
			
			
			<header class="profile-header">
          <div class="profile-image"> @if(!empty($activity->image))<img src="{{asset('uploads/activities/thumb/'.$activity->image)}}"  />@endif </div>
			
				<div class="profile-content">
					<div class="row">
              
			     
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Code:</label>
                {{ $activity->code }}
              </div>
			
			 
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Type of Activity:</label>
                {{ $typeActivities[$activity->type_activity]}}
              </div>
			 
              <div class="form-group col-lg-6 mb-3">
                <label for="inputName">Description:</label>
                {!!$activity->description!!}
              </div>
             
              <div class="form-group col-lg-6 mb-3">
			        <label for="inputName">Status:</label>
					{!! SiteHelpers::statusColor($activity->status) !!}
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