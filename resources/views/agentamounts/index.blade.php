@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Agent Amount Debit/Credit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Agent Amount Debit/Credit</li>
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
                <h3 class="card-title">Agent Amount Debit/Credit</h3>
				<div class="card-tools">
				 <a href="{{ route('agentamounts.create') }}" class="btn btn-sm btn-info">
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
					<th>Receipt No.</th>
					<th>Agent Name</th>
					<th>Amount</th>
					<th>Date of Receipt</th>
					<th>Transaction Type</th>
					<th>Remark</th>
					<th>Created</th>
                  </tr>
				   <tr>
				    <form id="filterForm" method="get" action="{{route('agentamounts.index')}}" >
					<th><input type="text" name="receipt_no" value="{{request('receipt_no')}}" autocomplete="off" class="form-control"  placeholder="Receipt No" /></th>
					<th> <input type="text" id="agent_id" name="agent_id" value="{{ request('agent_id') ?: $agetName }}" class="form-control"  placeholder="Agent Name" />
					<input type="hidden" id="agent_id_select" name="agent_id_select" value="{{ request('agent_id_select') ?: $agetid }}"  />
					</th>
					<th><input type="text" name="amount" value="{{request('amount')}}" autocomplete="off" class="form-control"  placeholder="Amount" /></th>
					<th><input type="text" name="date_of_receipt" value="{{request('date_of_receipt')}}" class="form-control datepicker" autocomplete="off" placeholder="Date of Receipt" /></th>
					<th><select name="transaction_type" id="transaction_type" class="form-control">
                    <option value="" @if(request('transaction_type') =='') {{'selected="selected"'}} @endif>Select</option>
                    <option value="Debit" @if(request('transaction_type') == 'Debit') {{'selected="selected"'}} @endif>Debit</option>
					          <option value="Credit" @if(request('transaction_type') == 'Credit') {{'selected="selected"'}} @endif >Credit</option>
                 </select></th>
					<th></th>
					<th><button class="btn btn-info btn-sm" type="submit">Filter</button>
                    <a class="btn btn-default btn-sm" href="{{route('agentamounts.index')}}">Clear</a></th>
					 </form>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($records as $record)
				  
                  <tr>
				  <td>{{ ($record->receipt_no)}}</td>
                    <td>{{ ($record->agent)?$record->agent->full_name:''}}</td>
					<td>{{ $record->amount}}</td>
					<td>
					{{ $record->date_of_receipt ? date(config('app.date_format'),strtotime($record->date_of_receipt)) : null }}
					</td>
					<td>{{ ($record->transaction_type)}}</td>
					<td>{{ ($record->remark)}}</td>
					<td>{{ $record->created_at ? date(config('app.date_format'),strtotime($record->created_at)) : null }}</td>
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
<script type="text/javascript">
    var path = "{{ route('auto.agent') }}";
  
    $( "#agent_id" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
               search: request.term
            },
            success: function( data ) {
               response( data );
            }
          });
        },
		
        select: function (event, ui) {
           $('#agent_id').val(ui.item.label);
           //console.log(ui.item); 
		   $('#agent_id_select').val(ui.item.value);
		    $('#agent_details').html(ui.item.agentDetails);
           return false;
        },
        change: function(event, ui){
            // Clear the input field if the user doesn't select an option
            if (ui.item == null){
                $('#agent_id').val('');
				 $('#agent_id_select').val('');
				 $('#agent_details').html('');
            }
        }
      });
  
</script>
@endsection