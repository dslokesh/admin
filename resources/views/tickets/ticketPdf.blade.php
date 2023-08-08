<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="initial-scale=1.0"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="format-detection" content="telephone=no"/>
<title>Ticket</title>

<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700&subset=latin,cyrillic,greek" rel="stylesheet" type="text/css">
<style>
body
{
  font-size: 10pt;
}
.col-6 {
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
}
</style>
</head>
  <body  style=" width:100%; height:100%;">
  @foreach($tickets as $ticket)

  <div class="width:100%; padding: 10px 0px;">
            <div style="width: 30%;float: left;">
                @if(file_exists(public_path('uploads/activities/'.$voucherActivity->activity->brand_logo)) && !empty($voucherActivity->activity->brand_logo))
                  <img src="{{asset('uploads/activities/thumb/'.$voucherActivity->activity->brand_logo)}}" style="max-width: 200px; display: block !important; width: 200px; height: 150px;" alt="logo-top" border="0" hspace="0" vspace="0" height="auto">
                  @else
                  {{-- Code to show a placeholder or alternate image --}}
                  <img src="{{ asset('uploads/activities/thumb/no-image.png') }}" style="max-width: 200px;width: 200px;height: 150px" alt="no-image">
                  @endif
            </div>
            <div style="width: 60%;float: right;background-color: #ddd;padding: 5px;">
               <h3>This your Tickets</h3>
               <p>This ticket is non-refundable, non-transferable and Voild if altered</p>
            </div>
             
          </div>
          <div style="clear:both; width: 100%;height: 10px;border-bottom: 2px #000 solid;">&nbsp;</div>
      <div style="width: 100%;margin-top: 10px;">
          
          <div style="width:100%; padding: 10px 0px;">
             <div style="width: 70%;float: left;background-color: #ddd;text-align:center;">
<h3>{{$voucherActivity->activity->title}} - {{ $voucherActivity->variant_name }}</h3>
                            <table class="table table-condensed table-striped" cellspacing="0" cellpadding="3px">
                                <thead>
								
                                  <tr >
                                    <th style="text-align: left;">
                                      Guest Name 
                                    </th>
                                    <th style="text-align: left;">
									{{(empty($voucher->guest_name))?$voucher->agent->name:$voucher->guest_name}}
                                    </th>
                                   </tr>
								    <tr >
									<th style="text-align: left;">
                                       Ticket Type
                                    </th>
                                    <th style="text-align: left;">
									{{ $ticket->ticket_for }}
                                    </th>
                                   </tr>
								   
								   <tr >
									<th style="text-align: left;">
                                       Service Date
                                    </th>
                                    <th style="text-align: left;">
									{{ $voucherActivity->tour_date ? date(config('app.date_format'),strtotime($voucherActivity->tour_date)) : null }}
                                    </th>
                                   </tr>
								  
									 <tr>
                   <th style="text-align: left;">
                                      Confirmation Id
                                    </th>
                                    <th style="text-align: left;">
                                    {{ $voucher->code}}
                                    </th>
									 </tr>
									  <tr >
                    <th style="text-align: left;">
                                       Valid Until
                                    </th>
                                    <th style="text-align: left;">
                                     {{ $ticket->valid_till ? date(config('app.date_format'),strtotime($ticket->valid_till)) : null }}
                                    </th>
									 </tr>
								  
                                </thead>
                               
                    <tr>
                    
                    </tr>
                  </table>
             </div>
             <div style="width: 28%;float: right;text-align: center;">
<img src="https://chart.googleapis.com/chart?cht=qr&chs=200x200&choe=UTF-8&chld=L|1&chl={{$ticket->ticket_no}}" width="150" style="max-width: 150px; display: block !important; width: 150px; height: 150px;margin: 0px auto;" alt="logo-top" border="0" hspace="0" vspace="0" height="auto">
				{{ $ticket->ticket_no}}
             </div>
          </div>
      </div>
      <div style="clear:both; width: 100%;height: 10px;border-bottom: 2px #000 solid;">&nbsp;</div>
      <div style="width: 100%;margin-top:10px;text-align:justify;">
      @if(file_exists(public_path('uploads/activities/'.$voucherActivity->activity->image)) && !empty($voucherActivity->activity->image))
            <img src="{{asset('uploads/activities/'.$voucherActivity->activity->image)}}"  alt="logo-top" border="0" hspace="0" vspace="0" height="auto" style="max-width: 100%;width: 100%;height: auto;max-height: 250px;">
           
            @endif   
      <h3>Terms And Conditions</h3>
						<p style="font-size: 9px;">{!! $ticket->terms_and_conditions !!}</p>
          
              
      </div>
      @endforeach
     
    </body>
</html>