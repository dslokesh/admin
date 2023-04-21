@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Markup</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Markup</li>
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
                <h3 class="card-title">Markup</h3>
				<div class="card-tools">
				
				   </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  <form id="filterForm" method="post" action="{{route('suppliers.markup.price.save')}}" >
				   {{ csrf_field() }}
				 <input type="hidden" name="supplier_id" value="{{ $supplierId}}" />
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Activity Name</th>
					<th>Price</th>
                  </tr>
                  </thead>
                  <tbody>
				   
                  @foreach ($activities as $record)
				  <input type="hidden" name="activity_id[]" value="{{ $record->id}}" />
                  <tr>
					
                    <td>{{ $record->title}}</td>
					<td>
						<table class="table table-bordered table-striped">
						<tr>
							<th>Variant Code</th>
							<th>Ticket Only</th>
							@if($record->sic_TFRS==1)
							<th>SIC Transfer</th>
							@else
							<th style="display:none">SIC Transfer</th>
							@endif
							
							 @if($record->pvt_TFRS==1)
							<th>PVT Transfer</th>
							@else
							<th style="display:none">PVT Transfer</th>
							@endif
						</tr>
						@foreach($variants[$record->id] as $variant)
						@php
						$ticket_only = (isset($markups[$variant['variant_code']]))?$markups[$variant['variant_code']]['ticket_only']:'';
						$sic_transfer = (isset($markups[$variant['variant_code']]))?$markups[$variant['variant_code']]['sic_transfer']:'';
						$pvt_transfer = (isset($markups[$variant['variant_code']]))?$markups[$variant['variant_code']]['pvt_transfer']:'';
						@endphp
						<tr>
						<td>{{ $variant['variant_code']}}</td>
						<td>
						<input type="text"  name="ticket_only[{{ $record->id}}][{{$variant['variant_code']}}]" value="{{$ticket_only}}" min="0" max="100" class="form-control onlynumbr" required  />
						</td>
						 @if($record->sic_TFRS==1)
						<td>
						@else
							<td style="display:none">
						@endif
						<input type="text" name="sic_transfer[{{ $record->id}}][{{$variant['variant_code']}}]" value="{{$sic_transfer}}" min="0" max="100" class="form-control onlynumbr" required />
						</td>
						@if($record->pvt_TFRS==1)
						<td>
						@else
							<td style="display:none">
						@endif
						<input type="text" name="pvt_transfer[{{ $record->id}}][{{$variant['variant_code']}}]" value="{{$pvt_transfer}}" min="0" max="100" class="form-control onlynumbr" required />
						</td>
						</tr>
						@endforeach
						</table>
					</td>
                  </tr>
				 
                  @endforeach

                  </tbody>
                 
                </table>
				<button type="submit" class="btn btn-success float-right">Save</button>
				  </form>
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
 <script type="text/javascript">
$(document).on('keypress', '.onlynumbr', function(evt) {
	var charCode = (evt.which) ? evt.which : evt.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57))
  {
    return false;
  }
  else
  {
	return true;
	
  }
  

});

</script>   
  
@endsection