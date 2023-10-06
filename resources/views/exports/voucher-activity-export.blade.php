<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                   <tr>
					<th>Booking #</th>
                    <th>Service Date</th>
					<th>Service</th>
					<th>Variant</th>
					<th>Service Type</th>
					<th>Agency</th>
					<th>Guest Name</th>
					<th>Guest Contact No</th>
					<th>A</th>
                    <th>C</th>
                    <th>I</th>
					<th>TKT Supplier</th>
					<th>TKT Supplier Ref #</th>
					<th>TKT SP</th>
					<th>TKT Net Cost</th>
					<th>SIC/PVT</th>
					<th>Pickup</th>
					<th>Pickup Time</th>
					<th>Dropoff</th>
					<th>Dropoff Time</th>
					<th>TFR Supplier</th>
					<th>TFR Supplier Ref #</th>
					<th>Driver name</th>
					<th>TFR SP</th>
					<th>TFR Net Cost</th>
					<th>Remark</th>
                  </tr>
				  
                  </thead>
                  <tbody>
				 @foreach($records as $record)
				 
                  <tr>
					<td>{{($record->voucher)?$record->voucher->code:''}}</td>
                    <td>{{$record->tour_date}}</td>
					<td>{{($record->activity)?$record->activity->title:''}}</td>
					<td>{{($record->variant_name)?$record->variant_name:''}}</td>
					<td>{{$record->transfer_option}}</td>
					<td>{{($record->voucher->agent)?$record->voucher->agent->company_name:''}}</td>
					<td>{{($record->voucher)?$record->voucher->guest_name:''}}</td>
					<td>{{($record->voucher)?$record->voucher->guest_phone:''}}</td>
					<td>{{$record->adult}}</td>
                    <td>{{$record->child}}</td>
                    <td>{{$record->infant}}</td>
					<td>{{($record->supplierticket)?$record->supplierticket->name:''}}</td>
					<td>{{$record->ticket_supp_ref_no}}</td>
					<td>{{$record->totalprice}}</td>
					<td>{{$record->actual_total_cost}}</td>
					<td>
					@if($record->transfer_option == "Shared Transfer")
					SIC
					@php
					$zone = SiteHelpers::getZoneName($record->transfer_zone);
					@endphp
						- {{$zone->name}} 
					
					@endif
					@if($record->transfer_option == 'Pvt Transfer')
					PVT
					@endif
					
				</td>
				<td>{{$record->pickup_location}}</td>
				<td>{{$record->actual_pickup_time}}</td>
				<td>{{$record->dropoff_location}}</td>
				<td>{{$record->dropoff_time}}</td>
				<td>{{($record->suppliertransfer)?$record->suppliertransfer->name:''}}</td>
				<td>{{$record->transfer_supp_ref_no}}</td>
				<td>{{$record->driver_name}}</td>
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
					<td>{{$record->actual_transfer_cost}}</td>
					<td>{{$record->remark}}</td>
                  </tr>
				  @endforeach
                  </tbody>
                 
                </table>
				</body>
</html>