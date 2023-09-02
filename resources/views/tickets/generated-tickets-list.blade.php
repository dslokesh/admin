@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Generated Tickets</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Generated Tickets</li>
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
                <h3 class="card-title">Generated Tickets</h3>
				<div class="card-tools">
				
				 
				   </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table rounded-corners">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Created</th>
                    <th>Booking #</th>
                    <th>Agency</th>
                    <th>Guest Name</th>
					<th>Ticket No.</th>
					<th>Serial Number</th>
					<th>Valid From</th>
					<th>Valid Till</th>
					<th>Activity</th>
          <th>Variant</th>
					<th>Ticket For</th>
					<th>Type Of Ticket</th>
					
				
                   
                  </tr>
				  <tr>
                    <form id="filterForm" method="get" action="{{route('tickets.generated.tickets')}}" >
					 <th></th>
           <th></th>
				    <th></th>
                   <th></th>
                   <th></th>
                    <th><input type="text" name="ticket_no" value="{{request('ticket_no')}}" class="form-control"  placeholder="Ticket Number" autocomplete="off" /></th>
                     <th><input type="text" name="serial_number" value="{{request('serial_number')}}" class="form-control"  placeholder="Serial Number" autocomplete="off" /></th>
                    <th><input type="text" name="valid_from" value="{{request('valid_from')}}" class="form-control datepicker"  placeholder="Valid From" autocomplete="off" /></th>
					 <th><input type="text" name="valid_till" value="{{request('valid_till')}}" class="form-control datepicker"  placeholder="Valid Till" autocomplete="off" /></th>
					 <th></th>
                    <th></th>
					 <th></th>
                   
                    <th width="10%"><button class="btn btn-info btn-sm" type="submit">Filter</button>
                    <a class="btn btn-default btn-sm" href="{{route('tickets.generated.tickets')}}">Clear</a></th>
                  
                  </form>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($records as $record)
				  
                  <tr>
                  <td>{{ $loop->index + 1 }}</td>
                  <td>{{ $record->created_at ? date(config('app.date_format'),strtotime($record->created_at)) : null }}</td>
                  <td> <a class="btn btn-info btn-xs" target="_blank" href="{{route('voucherView',$record->voucher->id)}}">{{ ($record->voucher)?$record->voucher->code:''}}</a></td>
                  <td>{{ ($record->voucher)?$record->voucher->agent->company_name:''}}</td>
                  <td>{{ $record->voucher->guest_name}}</td>
					<td>{{ $record->ticket_no}}</td>
					<td>{{ $record->serial_number}}</td>
					<td>{{ $record->valid_from ? date(config('app.date_format'),strtotime($record->valid_from)) : null }}</td>
                    <td>{{ $record->valid_till ? date(config('app.date_format'),strtotime($record->valid_till)) : null }}</td>
					<td>{{ ($record->activity)?$record->activity->title:''}}</td>
                    <td>{{ ($record->voucheractivity)?$record->voucheractivity->variant_name:''}}</td>
					<td>{{ $record->ticket_for}}</td>
                    <td>{{ $record->type_of_ticket}}</td>
				
                  
                  
                   
                    
                  </tr>
				 
                  @endforeach
                  </tbody>
                 
                </table>
				<div class="pagination pull-right mt-3"> {!! $records->appends(request()->query())->links() !!} </div> 
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

@section('scripts')
 @include('inc.citystatecountryjs')
@endsection
