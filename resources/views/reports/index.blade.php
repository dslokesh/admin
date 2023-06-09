@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Vouchers Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Vouchers Report</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
				<div class="card-tools">
				<!-- <a href="{{ route('voucherReportExport', request()->input()) }}">Export to Excel</a> -->
				   </div>
				   <div class="row">
            <form id="filterForm" class="form-inline" method="get" action="{{ route('voucherReport') }}" >
              <div class="form-row align-items-center">
			   <div class="col-auto col-md-3">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Search Result</div>
                  </div>
                 <select name="booking_type" id="booking_type" class="form-control">
                    <option value = "1">Booking Date</option>
					<option value = "2">Travel Date</option>
					<option value = "3">Deadline Date</option>
                 </select>
                </div>
              </div>
			  <div class="col-auto col-md-3">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">Form Date</div></div>
                    <input type="text" name="from_date" value="{{ request('from_date') }}" class="form-control datepicker"  placeholder="Form Date" />
                  </div>
                </div>
				<div class="col-auto col-md-3">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">To Date</div></div>
                    <input type="text" name="to_date" value="{{ request('to_date') }}" class="form-control datepicker"  placeholder="To Date" />
                  </div>
                </div>
                <div class="col-auto col-md-3">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">Reference Number</div></div>
                    <input type="text" name="reference" value="{{ request('reference') }}" class="form-control"  placeholder="Reference Number" />
                  </div>
                </div>
                <div class="col-auto col-md-3">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Booking Status</div>
                  </div>
                 <select name="booking_status" id="booking_status" class="form-control">
						<option value = "">All</option>
						<option value = "1">Vouchered</option>
						<option value = "2">Confirmed</option>
						<option value = "3">Completed</option>
						<option value = "4">Cancelled</option>
						<option value = "5">Auto-Released</option>
						<option value = "6">On Request</option>
						<option value = "7">InProcess</option>
						<option value = "8">InQueue</option>
						<option value = "9">Rejected</option>
                 </select>
                </div>
              </div>
               
              <div class="col-auto col-md-2">
                <button class="btn btn-info mb-2" type="submit">Filter</button>
                <a class="btn btn-default mb-2  mx-sm-2" href="{{ route('voucherReport') }}">Clear</a>
              </div>
            </form>
          </div>
        </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
					<th>VOUCHER CODE</th>
                    <th>SERVICE DATE</th>
					<th>SERVICE</th>
					<th>NAME</th>
					<th>GUEST'S CONTACT</th>
					<th>PICKUP LOCATION</th>
					<th>DROPOFF LOCATION</th>
                    <th>A</th>
                    <th>C</th>
                    <th>I</th>
					<th>SIC/PVT</th>
					<th>DROP OFF TIME</th>
					<th>DRIVER NAME</th>
					<th>SUPPLIER TICKET</th>
					<th>SUPPLIER TRANSFER</th>
					<th>TOTAL TICKET COST</th>
					<th>TOTAL TRANSFER COST</th>
					<th>AGENCY</th>
					<th>REMARKS</th>
					<th>ACTUAL PICK UP TIME</th>
                  </tr>
				  
                  </thead>
                  <tbody>
				  @foreach ($records as $record)
                  <tr>
					<td>{{$record->voucher->code}}</td>
                    <td>{{$record->tour_date}}</td>
					<td>{{$record->activity->title}}</td>
					<td>{{$record->voucher->customer->name}}</td>
					<td>{{$record->voucher->customer->mobile}}</td>
					<td>PICKUP LOCATION</td>
					<td>DROPOFF LOCATION</td>
                    <td>{{$record->adult}}</td>
                    <td>{{$record->child}}</td>
                    <td>{{$record->infant}}</td>
					<td>
					@if($record->transfer_option == "Shared Transfer")
					SIC
					@endif
					@if($record->transfer_option == 'Pvt Transfer')
					PVT
					@endif
					
				</td>
					<td>DROP OFF TIME</td>
					<td>DRIVER NAME</td>
					<td>SUPPLIER TICKET</td>
					<td>SUPPLIER TRANSFER</td>
					<td>{{$record->totalprice}}</td>
					<td>
					@if($record->transfer_option == "Shared Transfer")
					@php
					$markup_sic_transfer =  (($record->zonevalprice_without_markup) * ($record->markup_p_sic_transfer/100));
					@endphp
					{{$record->zonevalprice_without_markup + $markup_sic_transfer}}
					@endif
					@if($record->transfer_option == 'Pvt Transfer')
					{{$record->pvt_traf_val_with_markup}}
					@endif
					</td>
					<td>{{$record->voucher->agent->full_name}}</td>
					<td>REMARKS</td>
					<td>ACTUAL PICK UP TIME</td>
                  </tr>
                  </tbody>
                  @endforeach
                </table>
				<div class="pagination pull-right mt-3"> 
				{!! $records->appends(request()->query())->links() !!}
				</div> 
				
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
