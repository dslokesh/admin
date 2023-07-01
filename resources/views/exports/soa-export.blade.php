<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
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
					<td></td>
					<td></td>
					<td></td>
                  
					<td></td>
					<td>{{$record->tour_date}}</td>
					<td></td>
					<td></td>
                    <td>{{$record->variant_name}}</td>
                    <td>{{$record->transfer_option}}
					@if($record->transfer_option == "Shared Transfer")
					SIC
					@php
					$zone = SiteHelpers::getZoneName($record->transfer_zone);
					@endphp
						- <b>Zone :</b> {{$zone->name}}
					
					@endif
					</td>
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
                    <td>{{$record->adult}}</td>
					<td>{{$record->child}}</td>
					<td>{{$record->adultPrice}}</td>
					<td>{{($record->child > 0)?$record->childPrice:0}}</td>
					<td>{{$record->discountPrice}}</td>
					<td>{{$record->totalprice}}</td>
					
					</tr>
                  </tbody>
                  @endforeach
                </table>
				</body>
</html>