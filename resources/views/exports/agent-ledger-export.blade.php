<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
       <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Agency Name</th>
					<th>Date</th>
					<th>Receipt No/ Inovice No.</th>
					<th>Transaction From</th>
					<th>Debit Amount</th>
					<th>Credit Amount</th>
                  </tr>
				  
                  </thead>
                  <tbody>
				  @php
				  $totalCredit = 0;
				  $totalDebit = 0;
				  @endphp
				  @foreach ($records as $record)
                  <tr>
                    <td>{{($record->agent)?$record->agent->company_name:''}}</td>
					<td>{{ $record->date_of_receipt ? date(config('app.date_format'),strtotime($record->date_of_receipt)) : null }}</td>
					<td>
					@if(isset($record->voucher))
						 {{ ($record->receipt_no)}}
					
					@else
						{{ ($record->receipt_no)}}
					@endif
				</td>
					<td>
					{{($record->transaction_from == '2')?'Vouchered':''}}
					{{($record->transaction_from == '3')?'Canceled':''}}
					</td>
					<td>
					@if($record->transaction_type == 'Debit')
					{{$record->amount}}
					@php
						$totalDebit += $record->amount;
						@endphp
					@endif
					
				</td>
					<td>@if($record->transaction_type == 'Credit')
						@php
						$totalCredit += $record->amount;
						@endphp
					
					{{$record->amount}}
					@endif</td>
					
					</tr>
                 
                  @endforeach
				  <tr>
                    <th colspan="3"></th>
					<th>Total</th>
					<th>
					{{$totalDebit}}
					
				</th>
					<th>{{$totalCredit}}</th>
           
					</tr>
					<tr>
                    <th colspan="3"></th>
					<th>Balance</th>
					<th colspan="2">
					{{$totalCredit - $totalDebit}}
					
				</th>
					
           
					</tr>
					 </tbody>
                </table>
				</body>
</html>