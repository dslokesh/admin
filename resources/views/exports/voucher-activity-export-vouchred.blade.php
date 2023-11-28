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
					<th>Booking No</th>
					<th>Invoice Number</th>
                    <th>Service Date</th>
					<th>Ref No.</th>
					<th>Agency</th>
					<th>Pax Name</th>
					<th>A</th>
                    <th>C</th>
					<th>Service</th>
					<th>Total Cost</th>
					<th>Status</th>
					<th>Booking Status</th>
                  </tr>
				  
                  </thead>
                  <tbody>
				 @foreach ($records as $record)
                  <tr>
				  <td>{{@(!empty($record->voucher->booking_date))?$record->voucher->booking_date:''}} </td>
				  <td>{{@$record->voucher->code}} </td>
				   <td>{{@$record->voucher->invoice_number}} </td>
                    <td>{{$record->tour_date}}
					</td>
					<td>{{$record->ticket_supp_ref_no}}</td>
					<td>{{($record->voucher->agent)?$record->voucher->agent->company_name:''}}</td>
					<td>{{($record->voucher)?$record->voucher->guest_name:''}}</td>
					 <td>{{$record->adult}}</td>
                    <td>{{$record->child}}</td>
					<td>{{($record->activity)?$record->activity->title:''}}</td>
					<td>{{$record->totalprice}}</td>
					<td>
					{!! SiteHelpers::voucherStatus($record->status) !!}
					</td>
					<td>
					{!! SiteHelpers::voucherStatus($record->voucher->status_main) !!}
					</td>
					
                  </tr>
                  @endforeach
                  </tbody>
                 
                </table>
				</body>
</html>