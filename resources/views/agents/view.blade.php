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
                <label for="inputName">Ticket Only:</label>
                {{$agent->ticket_only}}%
              </div>
			  
			  <div class="form-group col-lg-6 mb-3">
                <label for="inputName">SIC Transfer:</label>
                {{$agent->sic_transfer}}%
              </div>
			  
			  <div class="form-group col-lg-6 mb-3">
                <label for="inputName">PVT Transfer:</label>
                {{$agent->pvt_transfer}}%
              </div>
             
              <div class="form-group col-lg-6 mb-3">
			        <label for="inputName">Status:</label>
					{!! SiteHelpers::statusColor($agent->is_active) !!}
              </div>
            
          </div>
			
				</div>
          
			
				</header>
		
			<div class="row">
				<div class="form-group col-lg-12 mb-3">
				
					 <table id="example1" class="table table-bordered table-striped">
                  <thead>
				  <tr>
                    <th colspan="2" ><h3>Markup</h3></th>
                  </tr>
                  <tr>
                    <th>Activity Name</th>
					<th>Price</th>
                  </tr>
                  </thead>
                  <tbody>
				   
                  @foreach ($markups as $activityName => $record)
                  <tr>
					
                    <td>{{ $activityName }}</td>
					<td>
						<table class="table table-bordered table-striped">
						<tr>
							<th>Variant Code</th>
							<th>Ticket Only</th>
							<th>SIC Transfer</th>
							<th>PVT Transfer</th>
						</tr>
						@foreach($record as $variant_code => $variant)
						@php
						$ticket_only = (isset($variant['ticket_only']))?$variant['ticket_only']:'';
						$sic_transfer = (isset($variant['sic_transfer']))?$variant['sic_transfer']:'';
						$pvt_transfer = (isset($variant['pvt_transfer']))?$variant['pvt_transfer']:'';
						
						@endphp
						<tr>
						<td>{{ $variant_code }}</td>
						<td>
						{{$ticket_only}}%
						</td>
						<td>
						{{$sic_transfer}}%
						</td>
						<td>
						{{$pvt_transfer}}%
						</td>
						</tr>
						@endforeach
						</table>
					</td>
                  </tr>
				 
                  @endforeach

                  </tbody>
                 
                </table>
				</div>
			</div>
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