<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
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
				 @foreach($records as $record)
				 
                  <tr>
					<td>{{($record->voucher)?$record->voucher->code:''}}</td>
                    <td>{{$record->tour_date}}</td>
					<td>{{($record->activity)?$record->activity->title:''}}</td>
					<td>{{($record->voucher->customer)?$record->voucher->customer->name:''}}</td>
					<td>{{($record->voucher->customer)?$record->voucher->customer->mobile:''}}</td>
					<td>{{$record->pickup_location}}</td>
					<td>{{$record->dropoff_location}}</td>
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
					<td>{{$record->dropoff_time}}</td>
					<td>{{$record->driver_name}}</td>
					<td>{{$record->supplier_ticket}}</td>
					<td>{{$record->supplier_transfer}}</td>
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
					<td>{{($record->voucher->agent)?$record->voucher->agent->full_name:''}}</td>
					<td>{{$record->remark}}</td>
					<td>{{$record->actual_pickup_time}}</td>
                  </tr>
				  @endforeach
                  </tbody>
                 
                </table>
				</body>
</html>