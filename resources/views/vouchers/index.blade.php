@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Vouchers</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Vouchers</li>
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
                <h3 class="card-title">Vouchers</h3>
				<div class="card-tools">
				 <a href="{{ route('vouchers.create') }}" class="btn btn-sm btn-info">
                      <i class="fas fa-plus"></i>
                      Create
                  </a> 
				   </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
				   <th>Code</th>
                    <th>Agent</th>
					<th>Customer</th>
					<th>Country</th>
					<th>Hotel</th>
					<th>Flight</th>
					<th>Activity</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Updated</th>
					<th>Hotels</th>
					<th>Invoice</th>
					<th>Itinerary</th>
					<th width="7%">Activities</th>
                    <th width="12%"></th>
                  </tr>
				  
                  </thead>
                  <tbody>
                  @foreach ($records as $record)
				  
                  <tr>
				  <td>{{ ($record->code)}}</td>
                    <td>{{ ($record->agent)?$record->agent->full_name:''}}</td>
					<td>{{ ($record->customer)?$record->customer->name:''}}</td>
					<td>{{ ($record->countr)?$record->country->name:''}}</td>
					 <td>{!! SiteHelpers::statusColorYesNo($record->is_hotel) !!}</td>
					  <td>{!! SiteHelpers::statusColorYesNo($record->is_flight) !!}</td>
					   <td>{!! SiteHelpers::statusColorYesNo($record->is_activity) !!}</td>
                     <td>{!! SiteHelpers::statusColor($record->status) !!}</td>
                    <td>{{ $record->created_at ? date(config('app.date_format'),strtotime($record->created_at)) : null }}</td>
                    <td>{{ $record->updated_at ? date(config('app.date_format'),strtotime($record->updated_at)) : null }}</td>

					 <td>
					 @if($record->is_hotel == 1)
					 <a class="btn btn-info btn-sm" href="{{route('voucher.add.hotels',$record->id)}}">
                              <i class="fas fa-plus">
                              </i>
                             
                          </a>
						  @endif
						  </td>
						   <td>
						   
					 <a class="btn btn-info btn-sm" href="{{route('voucherInvoicePdf',$record->id)}}" style="display:none">
                              <i class="fas fa-download">
                              </i>
                             
                          </a>
						  
						  </td>
						   <td>
					 @if($record->is_activity == 1)
					 <a class="btn btn-info btn-sm" href="{{route('voucherActivityItineraryPdf',$record->id)}}">
                              <i class="fas fa-download">
                              </i>
                             
                          </a>
						  @endif
						  </td>
					 <td>
					 @if($record->is_activity == 1)
					 <a class="btn btn-info btn-sm" href="{{route('voucher.add.activity',$record->id)}}">
                              <i class="fas fa-plus">
                              </i>
                             
                          </a>
						  @endif
						  </td>
                     <td>
					 <a class="btn btn-info btn-sm" href="{{route('vouchers.show',$record->id)}}">
                              <i class="fas fa-eye">
                              </i>
                              
                          </a>
					 <a class="btn btn-info btn-sm" href="{{route('vouchers.edit',$record->id)}}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              
                          </a>
						   <form id="delete-form-{{$record->id}}" method="post" action="{{route('vouchers.destroy',$record->id)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$record->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            "><i class="fas fa-trash"></i></a>
                         </td>
                  </tr>
				 
                  @endforeach
                  </tbody>
                 
                </table>
				
				<div class="pagination pull-right mt-3"> {!! $records->links() !!} </div> 
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
