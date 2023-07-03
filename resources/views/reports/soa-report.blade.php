@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Accounts Receivables Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Accounts Receivables Report</li>
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
				 <div class="row">
				<a href="{{ route('soaReportExcel', request()->input()) }}" class="btn btn-info mb-2">Export to CSV</a>
				   </div></div>
				   
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  <div class="row">
            <form id="filterForm" class="form-inline" method="get" action="{{ route('soaReport') }}" >
              <div class="form-row align-items-center">
			   <div class="col-auto col-md-3">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Search Result</div>
                  </div>
                 <select name="booking_type" id="booking_type" class="form-control">
                    <option value = "1">Booking Date</option>
					<option value = "2">Travel Date</option>
                 </select>
                </div>
              </div>
			  <div class="col-auto col-md-3">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">From Date</div></div>
                    <input type="text" name="from_date" value="{{ request('from_date') }}" autocomplete ="off" class="form-control datepicker"  placeholder="From Date" />
                  </div>
                </div>
				<div class="col-auto col-md-3">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">To Date</div></div>
                    <input type="text" name="to_date" autocomplete ="off" value="{{ request('to_date') }}" class="form-control datepicker"  placeholder="To Date" />
                  </div>
                </div>
               
                <div class="col-auto col-md-3">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Booking Status</div>
                  </div>
                 <select name="booking_status" id="booking_status" class="form-control">
						<option value = "">All</option>
						@foreach($voucherStatus as $vsk => $vs)
						<option value = "{{$vsk}}" @if(request('booking_status')==$vsk) selected="selected" @endif>{{$vs}}</option>
						@endforeach
                 </select>
                </div>
              </div>
                <div class="col-auto col-md-3">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Agency</div>
                  </div>
                <input type="text" id="agent_id" name="agent_id" value="{{ request('agent_id') ?: $agetName }}" class="form-control"  placeholder="Agency Name" />
					<input type="hidden" id="agent_id_select" name="agent_id_select" value="{{ request('agent_id_select') ?: $agetid }}"  />
                </div>
              </div>
              <div class="col-auto col-md-2">
                <button class="btn btn-info mb-2" type="submit">Filter</button>
                <a class="btn btn-default mb-2  mx-sm-2" href="{{ route('soaReport') }}">Clear</a>
              </div>
            </form>
          </div>
        </div><div class="col-md-12" style="overflow-x:auto">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
					<th>Booking Date</th>
                    <th>Booking</th>
					<th>Invoice</th>
					<th>Agent Ref</th>
					<th>Service Date</th>
					<th>Guest Name</th>
					<th>Service Name</th>
                    <th>Variant</th>
                    <th>Transfer Type</th>
					<th>Transfer Cost</th>
                    <th>No.of Adult</th>
					<th>No. of Child</th>
					<th>Adult Rate</th>
					<th>Child Rate</th>
					<th>Discount</th>
					<th>Total Amount</th>
					
					
					
                  </tr>
				  
                  </thead>
                  <tbody>
				  @foreach ($records as $record)
                  <tr>
					<td>{{($record->voucher)?$record->voucher->booking_date:''}}</td>
					<td>{{($record->voucher)?$record->voucher->code:''}}</td>
					<td>{{($record->voucher)?$record->voucher->invoice_number:''}}</td>
                  
					<td>{{($record->voucher)?$record->voucher->agent_ref_no:''}}</td>
					<td>{{$record->tour_date}}</td>
					<td>{{($record->voucher)?$record->voucher->guest_name:''}}</td>
					<td>{{($record->activity)?$record->activity->title:''}}</td>
                    <td>{{$record->variant_name}}</td>
                    <td>{{$record->transfer_option}}
					@if($record->transfer_option == "Shared Transfer")
					SIC
					@php
					$zone = SiteHelpers::getZoneName($record->transfer_zone);
					@endphp
						- <b>Zone :</b> {{$zone->name}}
					
					@endif
					@php
					$totalPerson = $record->adult + $record->child;
					$transferCostPerPersonSIC = 0;
					$transferCostPerPersonPVT = 0;
					@endphp
					</td>
					<td>
					@if($record->transfer_option == "Shared Transfer")
					@php
					$markup_sic_transfer =  (($record->zonevalprice_without_markup) * ($record->markup_p_sic_transfer/100));
					$transferCostPerPersonSIC = ($record->zonevalprice_without_markup + $markup_sic_transfer)/$totalPerson; 
					@endphp
					{{$record->zonevalprice_without_markup + $markup_sic_transfer}} /{{$transferCostPerPersonSIC}}
					@endif
					@if($record->transfer_option == 'Pvt Transfer')
						@php
					$transferCostPerPersonPVT = $record->pvt_traf_val_with_markup/$totalPerson;
					@endphp					
					{{$record->pvt_traf_val_with_markup}}
					
					{{$transferCostPerPersonPVT}} 
					@endif
					</td>
                    <td>{{$record->adult}}</td>
					<td>{{$record->child}}</td>
					<td>
					@php
					$totalAdultPrice = $record->adultPrice + $transferCostPerPersonSIC + $transferCostPerPersonPVT;
					$totalChildPrice = $record->childPrice + $transferCostPerPersonSIC + $transferCostPerPersonPVT;
					$vatAd = ((5/100)+$totalAdultPrice);
					$vatCh = ((5/100)+$totalChildPrice);;
					$totalAdultPriceWithVat = $totalAdultPrice + $vatAd;
					$totalChildPriceWithVat = $totalChildPrice + $vatCh;
					@endphp	
					{{number_format($totalAdultPriceWithVat,2)}}/vat {{$vatAd}}/p-{{$record->adultPrice}}</td>
					<td>{{($record->child > 0)?number_format($totalChildPriceWithVat,2):0}}/vat {{$vatCh}}/p-{{$record->childPrice}}</td>
					<td>{{$record->discountPrice}}</td>
					<td>{{$record->totalprice}}</td>
					
					</tr>
                  </tbody>
                  @endforeach
                </table></div>
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
@section('scripts')
 <!-- Script -->
 <script type="text/javascript">
$(document).ready(function() {
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
	  
	$(document).on('change', '.inputsave', function(evt) {
		$("#loader-overlay").show();
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('voucherReportSave')}}",
            type: 'POST',
            dataType: "json",
            data: {
               id: $(this).data('id'),
			   inputname: $(this).data('name'),
			   val: $(this).val()
            },
            success: function( data ) {
               //console.log( data );
			  $("#loader-overlay").hide();
            }
          });
	 });	
});

  </script> 
  @endsection