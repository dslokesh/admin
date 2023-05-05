@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Voucher Details</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('vouchers.index') }}">Vouchers</a></li>
              <li class="breadcrumb-item active">Voucher Details</li>
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
            
			
			<div class="card-body">
			
			
			<header class="profile-header">
          
				<div class="profile-content">
					<div class="row">
               <div class="col-lg-6 mb-3">
                <label for="inputName">Agent Name:</label>
               {{ $voucher->agent->full_name }} </br>
			   <b>Code:</b>{{$voucher->agent->code}} <b> Email:</b>{{$voucher->agent->email}} <b>Mobile No:</b>{{$voucher->agent->mobile}} <b>Address:</b>{{$voucher->agent->address. " ".$voucher->agent->postcode;}}
              </div>
			 
			      <div class="col-lg-6 mb-3">
                <label for="inputName">Customer Name:</label>
                {{ $voucher->customer->name }} </br>
				<b>Email:</b>{{$voucher->customer->email}} <b>Mobile No:</b>{{$voucher->customer->mobile}} <b>Address:</b>{{$voucher->customer->address. " ".$voucher->customer->zip_code;}}
              </div>
			  <div class="form-group col-lg-6 mb-3">
                <label for="inputName">Country:</label>
                {{($voucher->country)?$voucher->country->name:''}}
              </div>
            
             
              <div class="form-group col-lg-6 mb-3">
			        <label for="inputName">Status:</label>
					{!! SiteHelpers::statusColor($voucher->status) !!}
              </div>
			  <div class="col-lg-3 mb-3">
                <label for="inputName">Arrival Airline:</label>
                {{ ($voucher->arrivalairline)?$voucher->arrivalairline->name:'' }}
              </div>
			  <div class="col-lg-3 mb-3">
                <label for="inputName">Arrival Date:</label>
				{{ $voucher->arrival_date ? date(config('app.date_format'),strtotime($voucher->arrival_date)) : null }}
              </div>
			 
			  <div class="col-lg-3 mb-3">
                <label for="inputName">Arrival Airport:</label>
                {{ $voucher->arrival_airport }}
              </div>
			   <div class="col-lg-3 mb-3">
                <label for="inputName">Arrival Terminal:</label>
                {{ $voucher->arrival_terminal }}
              </div>
			 
			 
			  <div class="col-lg-3 mb-3">
                <label for="inputName">Depature Airline:</label>
				 {{ ($voucher->depatureairline)?$voucher->depatureairline->name:'' }}
              </div>
			  <div class="col-lg-3 mb-3">
                <label for="inputName">Depature Date:</label>
				{{ $voucher->depature_date ? date(config('app.date_format'),strtotime($voucher->depature_date)) : null }}
              </div>
			 
			  <div class="col-lg-3 mb-3">
                <label for="inputName">Depature Airport:</label>
                {{ $voucher->depature_airport }}
              </div>
			   <div class="col-lg-3 mb-3">
                <label for="inputName">Depature Terminal:</label>
                {{ $voucher->depature_terminal }}
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