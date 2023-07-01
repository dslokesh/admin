
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="initial-scale=1.0"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="format-detection" content="telephone=no"/>
<title>Invoice</title>

<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700&subset=latin,cyrillic,greek" rel="stylesheet" type="text/css">
<style>

.table
{
	border-collapse:collapse!important;
	width: 100%;
}
.table td,.table th
{
	background-color:#fff!important;
	text-align: left;
}
.table-bordered th,.table-bordered td
{
	border:1px solid #000!important;
}
.table-borderless th,.table-borderless td
{
	border:none!important;
}
.table-striped>thead>tr:nth-of-type(odd){background-color:#f9f9f9}
</style>
</head>
  <body  style="font-size:16px; width:100%; height:100%;">
      <table id="mainStructure" class="full-width" width="800" align="center" border="0" cellspacing="0" cellpadding="0" style="background-color: #efefef; max-width: 800px;   margin: 0px auto;"><!--START LAYOUT-2 ( LOGO / MENU )-->
        <tr>
          <td align="center" valign="top" style="background-color: #ffffff;" bgcolor="#ffffff">  
            <table width="760" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; max-width: 760px; margin: 0px auto;">
              <tr>
                <td valign="top">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="full-width" style="max-width: 100%; margin: 0px auto;">
                    <tr>
                      <td valign="top" colspan="2" height="11" style="height: 11px; font-size: 0px; line-height: 0; border-collapse: collapse;"></td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" width="136" style="width: 136px;">
                         
                            <img src="https://www.abateratourism.com/templates/shaper_travel/images/styles/style4/logo.png" width="100" style="max-width: 100px; display: block !important; width: 136px; height: auto;" alt="logo-top" border="0" hspace="0" vspace="0" height="auto">
                            <h3>Abatera Tourism LLC</h3>
                        </td>
                        <td  align="center" valign="middle" > <h1>
						@if($voucher->vat_invoice == 1)
							VAT INVOICE
						@else
							PROFORMA INVOICE
						@endif
						</h1></td>
                    </tr>
                    <tr>
                      <td valign="top" colspan="2" height="11" style="height: 11px; font-size: 0px; line-height: 0; border-collapse: collapse;"></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr><!--END LAYOUT-2 ( LOGO / MENU )--><!--START LAYOUT-13 ( 2-COL TEXT / BG )  -->
        <tr>
          <td align="center" valign="top" style="background-color: #ffffff;" bgcolor="#ffffff">  
            <table width="760" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; max-width: 760px; margin: 0px auto;">
              <tr style="border-top: 2px solid #000;">
                <td valign="top">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="full-width" style="max-width: 100%; margin: 0px auto;">
                    <tr>
                      <td valign="top" colspan="2" height="11" style="height: 11px; font-size: 0px; line-height: 0; border-collapse: collapse; border-top: 2px solid #000!important;"></td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
						@if(!empty($agent))
                         <p>Invoice To</p>
                         <p>{{$agent->company_name}}</p>
                         <p>{{$agent->address}} {{$agent->address}}/{{($agent->city)?$agent->city->name:''}}/{{($agent->state)?$agent->state->name:''}}/{{($agent->country)?$agent->country->name:''}}</p>
                         <p>{{$agent->phone}},{{$agent->mobile}}</p>
                         <p>{{$agent->email }}</p>
						 <p>TRN No. : {{$agent->vat}}</p>
						 @endif
                        </td>
                        <td align="right" valign="top">
                          <p>Invoice No.:<br/> {{$voucher->invoice_number}}</p>
                          <p>Invoice Date.:<br/> {{date("d-M-Y")}}</p>
                          <p>Guest Name: <br/>{{$customer->guest_name}}</p>
                         
                         </td>
                    </tr>
                    <tr>
                      <td valign="top" colspan="2" height="11" style="height: 11px; font-size: 0px; line-height: 0; border-collapse: collapse;"></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr><!--END LAYOUT-2 ( LOGO / MENU )--><!--START LAYOUT-13 ( 2-COL TEXT / BG )  -->
        <tr>
          <td align="center" valign="top" style="background-color: #ffffff;" bgcolor="#ffffff">  
            <table width="760" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; max-width: 760px; margin: 0px auto;">
              <tr style="border-top: 2px solid #000;">
                <td valign="top">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="full-width" style="max-width: 100%; margin: 0px auto;">
                    <tr>
                      <td valign="top"  height="11" style="height: 11px; font-size: 0px; line-height: 0; border-collapse: collapse; "></td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
                            <table class="table table-bordered table-striped" cellspacing="0" cellpadding="10px">
                                <thead>
                                  <tr>
                                    <th>
                                      Service 
                                    </th>
                                    <th>
                                      Service Date
                                    </th>
                                    <th>
                                      Time Slot
                                    </th>
                                    <th>
                                      No. of Pax(s)
                                    </th>
                                    <th>
                                      Agent Ref
                                    </th>
                                    <th>
                                      Amount
                                    </th>
                                  </tr>
                                </thead>
                                <tbody>
								 @if(!empty($dataArray))
					  @foreach($dataArray as $ap)
					 
                                  <tr>
                                    <td>
                                      {{$ap['hhotelActName']}}
                                    </td>
                                    <td>
									{{$ap['TouCheckInCheckOutDate']}}
                                    </td>
                                    <td>
                                      
                                    </td>
                                    <td>
									@if($ap['hotel'])
									{{$ap['NoofPax']}}
									@else
									Adult : {{$ap['adult']}} <br/>
									Child : {{$ap['child']}} <br/>
									@endif
                                    </td>
                                    <td>
                                     {{$voucher->agent_ref_no}}
                                    </td>
                                    <td>
									{{number_format($ap['totalprice'],2)}}
                                     
                                    </td>
                                  </tr>
								   @endforeach
				 @endif
                                </tbody>
                            </table>
                        </td>
                      
                    </tr>
                    <tr>
                      <td valign="top" height="11" style="height: 11px; font-size: 0px; line-height: 0; border-collapse: collapse;"></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr><!--END LAYOUT-2 ( LOGO / MENU )--><!--START LAYOUT-13 ( 2-COL TEXT / BG )  -->
        <tr>
          <td align="center" valign="top" style="background-color: #ffffff;" bgcolor="#ffffff">  
            <table width="760" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; max-width: 760px; margin: 0px auto;">
              <tr style="border-top: 2px solid #000;">
                <td valign="top">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="full-width" style="max-width: 100%; margin: 0px auto;">
                    <tr>
                      <td valign="top" colspan="2" height="11" style="height: 11px; font-size: 0px; line-height: 0; border-collapse: collapse; border-top: 2px solid #000!important;"></td>
                    </tr>
                    <tr>
					 <td align="left" valign="top">
						
                        </td>
                        <td align="right" valign="top">
						<p>Sub Total: AED {{number_format($subWithOutVat,2)}}</p>
						<p>Vat(5%): AED {{number_format($vatTotal,2)}}</p>
                          <p>Grant Total: AED {{number_format($subTotalGrand,2)}}</p>
                         
                         </td>
                    </tr>
                        <td align="left" valign="top">
						<div style="width:100%">
						<p>Bank Details</p>
						<div style="width:33%; float:left">
                         
						 <p>ABATERA TOURISM LLC<br/>
Account -0033488116001  <br/> IBAN - AE530400000033488116001
Corresponding Bank (USD) : <br/>BANK OF NEW YORK,NEW YORK, U.S.A<br/>
SWIFT CODE (AED) : NRAKAEAK<br/> | Swift Code(USD) : IRVTUS3N<br/>
Branch Name: Bur Dubai Branch<br/>
</div>
 <div style="width:33%; float:left">

ABATERA TOURISM LLC<br/>
Account -1001303922 <br/> IBAN -  AE870230000001001303922<br/>
SWIFT CODE(AED) : CBDUAEAD<br/>
Branch Name: Immigration Branch<br/>
 
</div>
<div style="width:33%; float:left">
 
ABATERA TOURISM LLC  <br/>
Account – 9622223261<br/>
IBAN - AE850860000009622223261s<br/>
SWIFT CODE(AED) : WIOBAEADXXX</p>
</div>
</div>
                        </td>
                        
                    </tr>
                    <tr>
                      <td valign="top" colspan="2" height="11" style="height: 11px; font-size: 0px; line-height: 0; border-collapse: collapse;"></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr><!--END LAYOUT-2 ( LOGO / MENU )--><!--START LAYOUT-13 ( 2-COL TEXT / BG )  -->
        <tr>
          <td align="center" valign="top" style="background-color: #ffffff;" bgcolor="#ffffff">  
            <table width="760" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; max-width: 760px; margin: 0px auto;">
              <tr style="border-top: 2px solid #000;">
                <td valign="top">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="full-width" style="max-width: 100%; margin: 0px auto;">
                    <tr>
                      <td valign="top" colspan="2" height="11" style="height: 11px; font-size: 0px; line-height: 0; border-collapse: collapse; border-top: 2px solid #000!important;"></td>
                    </tr>
                    <tr>
                       
                        <td align="left" valign="middle">
						@if($voucher->vat_invoice == 1)
							<p>VAT Credit on this Tax Invoice can only be claimed after maturity of service date</p>
						@endif
						
                          <p>System generated invoice no signature is required.</p>
                         
                         </td>
                    </tr>
                    <tr>
                      <td valign="top"  height="11" style="height: 11px; font-size: 0px; line-height: 0; border-collapse: collapse;"></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr><!--END LAYOUT-2 ( LOGO / MENU )--><!--START LAYOUT-13 ( 2-COL TEXT / BG )  -->
      </table>
    </body>
</html>