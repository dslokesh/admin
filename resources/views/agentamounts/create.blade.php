@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Agent Amount Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('agentamounts.index') }}">Agent Amounts</a></li>
              <li class="breadcrumb-item active">Agent Amount Add</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('agentamounts.store') }}" method="post" class="form">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add Agent Amount</h3>
            </div>
            <div class="card-body row">
              <div class="form-group col-md-12">
                <label for="inputName">Agency Name: <span class="red">*</span></label>
                <input type="text" id="agent_id" name="agent_id" value="{{ old('agent_id') }}" class="form-control"  placeholder="Agency Name" />
                @if ($errors->has('agent_id'))
                    <span class="text-danger">{{ $errors->first('agent_id') }}</span>
                @endif
				
				<input type="hidden" id="agent_id_select" name="agent_id_select"  />
				
              </div>
			   <div class="form-group col-md-12" id="agent_details">
			   </div>
			     <div class="form-group col-md-4">
                <label for="inputName">Amount: <span class="red">*</span></label>
                 <input type="text" id="amount" name="amount" value="{{ old('amount') }}" class="form-control"  placeholder="Amount" />
				  @if ($errors->has('amount'))
                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-4">
                <label for="inputName">Date of Receipt: <span class="red">*</span></label>
               <input type="text" id="date_of_receipt" name="date_of_receipt" value="{{ old('date_of_receipt') }}" class="form-control datepicker"  placeholder="Date of Receipt" />
				  @if ($errors->has('date_of_receipt'))
                    <span class="text-danger">{{ $errors->first('date_of_receipt') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-4">
                <label for="inputName">Transaction Type:</label>
                <select name="transaction_type" id="transaction_type" class="form-control">
                    <option value="Debit" @if(old('transaction_type') == 'Debit') {{'selected="selected"'}} @endif>Debit</option>
					<option value="Credit" @if(old('transaction_type') == 'Credit') {{'selected="selected"'}} @endif >Credit</option>
                 </select>
              </div>
			   <div class="form-group col-md-6 hide">
                <label for="inputName">Payment Against:</label>
                <select name="is_vat_invoice" id="is_vat_invoice" class="form-control">
                    <option value="1" @if(old('is_vat_invoice') == '1') {{'selected="selected"'}} @endif>VAT Invoice</option>
					<option value="0" @if(old('is_vat_invoice') == '0') {{'selected="selected"'}} @endif >Non VAT Invoice</option>
                 </select>
              </div>
			  <div class="form-group col-md-6">
                <label for="inputName">Remark:</label>
                 <input type="text" id="remark" name="remark" value="{{ old('remark') }}" class="form-control"  placeholder="Remark" />
				  @if ($errors->has('remark'))
                    <span class="text-danger">{{ $errors->first('remark') }}</span>
                @endif
              </div>
           
			 </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <a href="{{ route('vouchers.index') }}" class="btn btn-secondary">Cancel</a>
          
		   <button type="submit" name="save_and_view" class="btn btn-primary float-right">Save</button>
        </div>
      </div>
    </form>

    </section>
    <!-- /.content -->
@endsection
@section('scripts')
@include('inc.citystatecountryjs')
<script type="text/javascript">
    var path = "{{ route('auto.agent') }}";
  
    $( "#agent_id" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
               search: request.term,
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