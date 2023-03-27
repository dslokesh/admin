@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $supplier->name }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('suppliers.index') }}">Suppliers</a></li>
              <li class="breadcrumb-item active">Supplier Details</li>
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
              <h3 class="card-title">{{ $supplier->name }}</h3>
            </div>
			
			<div class="card-body">
			
			
			<header class="profile-header">
          <div class="profile-image"> @if(!empty($supplier->logo))<img src="{{asset('uploads/suppliers/thumb/'.$supplier->logo)}}"  />@endif </div>
			
				<div class="profile-content">
					<div class="row">
              
			 
			      <div class="col-lg-6 mb-3">
                <label for="inputName">Email:</label>
                {{ $supplier->email }}
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Code:</label>
                {{ $supplier->code }}
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Mobile:</label>
                {{ $supplier->mobile }}
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Company Name:</label>
                {{ $supplier->company_name }}
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Department:</label>
                {{ $supplier->department }}
              </div>
			   <div class="col-lg-6 mb-3">
                <label for="inputName">Phone Number:</label>
                {{ $supplier->phone_number }}
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Address:</label>
                {{ $supplier->address }}
              </div>
              <div class="form-group col-lg-6 mb-3">
                <label for="inputName">City:</label>
                {{$supplier->city->name}}
              </div>
			  <div class="form-group col-lg-6 mb-3">
                <label for="inputName">State:</label>
                {{$supplier->state->name}}
              </div>
              <div class="form-group col-lg-6 mb-3">
                <label for="inputName">Country:</label>
                {{$supplier->country->name}}
              </div>
              <div class="form-group col-lg-6 mb-3">
                <label for="inputName">Postcode:</label>
                {{$supplier->postcode}}
              </div>
             
              <div class="form-group col-lg-6 mb-3">
			        <label for="inputName">Status:</label>
					{!! SiteHelpers::statusColor($supplier->status) !!}
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