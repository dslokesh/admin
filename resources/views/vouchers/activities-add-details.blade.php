@extends('layouts.app')
@section('content')
<style>

.form-control {
    display: block;
    width: 100%;
    height: calc(2.25rem + 2px);
    padding: 0.375rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    box-shadow: inset 0 0 0 transparent;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    text-align: left;
}

.card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    min-height: 1px;
    padding: 0.75rem;
}
table.rounded-corners {
  border-spacing: 0;
  border-collapse: separate;
  border-radius: 10px;
}

table.rounded-corners th, table.rounded-corners td {
  /* border: 1px solid #dee2e6; */
  padding: 5px;
  vertical-align: middle;
}
table.rounded-corners {
  border-spacing: 0;
  border-collapse: separate;
  border-radius: 10px;
  border: 1px solid #dee2e6;
}

table.rounded-corners {
 border-spacing: 0;
 border-collapse: separate;
 border-radius: 5px;
 border: 1px solid #dee2e6;
}

/* Apply a border to the right of all but the last column */
table.rounded-corners th:not(:last-child),
table.rounded-corners td:not(:last-child) {
 /* border-right: 1px solid #dee2e6; */
}

/* Apply a border to the bottom of all but the last row */
table.rounded-corners>thead>tr:not(:last-child)>th,
table.rounded-corners>thead>tr:not(:last-child)>td,
table.rounded-corners>tbody>tr:not(:last-child)>th,
table.rounded-corners>tbody>tr:not(:last-child)>td,
table.rounded-corners>tfoot>tr:not(:last-child)>th,
table.rounded-corners>tfoot>tr:not(:last-child)>td,
table.rounded-corners>tr:not(:last-child)>td,
table.rounded-corners>tr:not(:last-child)>th,
table.rounded-corners>thead:not(:last-child),
table.rounded-corners>tbody:not(:last-child),
table.rounded-corners>tfoot:not(:last-child) {
 border-bottom: 1px solid #dee2e6;
}

table.rounded-corners th {
  background-color: #ddd;
}

table.rounded-corners {
 /* Change these properties */
 --border: 1px solid #dee2e6;
 border-radius: 5px;
 

 /* Don't change these properties */
 border-spacing: 0;
 border-collapse: separate;
 border: var(--border);
 overflow: hidden;
}

/* Apply a border to the right of all but the last column */
table.rounded-corners th:not(:last-child),
table.rounded-corners td:not(:last-child) {
 /* border-right: var(--border); */
}

/* Apply a border to the bottom of all but the last row */
table.rounded-corners>thead>tr:not(:last-child)>th,
table.rounded-corners>thead>tr:not(:last-child)>td,
table.rounded-corners>tbody>tr:not(:last-child)>th,
table.rounded-corners>tbody>tr:not(:last-child)>td,
table.rounded-corners>tfoot>tr:not(:last-child)>th,
table.rounded-corners>tfoot>tr:not(:last-child)>td,
table.rounded-corners>tr:not(:last-child)>td,
table.rounded-corners>tr:not(:last-child)>th,
table.rounded-corners>thead:not(:last-child),
table.rounded-corners>tbody:not(:last-child),
table.rounded-corners>tfoot:not(:last-child) {
 border-bottom: var(--border);
}
table.rounded-corners tbody tr:hover {
  background-color: #eeeeee;
}
.card-body-hover:hover
{
  background-color: #eeeeee;
}
.form-control:disabled, .form-control[readonly] {
    background-color: #fff;
    opacity: 1;
}

.disabled-date { background-color: #ccc; }
.available-date { background-color: #b2ffb2; }
.disabled-day { background-color: #FF00B9; }
</style>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Voucher Code :{{$voucher->code}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
			 <li class="breadcrumb-item"><a href="{{ route('vouchers.index') }}">Vouchers</a></li>
              <li class="breadcrumb-item"><a href="{{ route('voucher.add.activity',[$voucher->id]) }}">Activities</a></li>
              <li class="breadcrumb-item active">Activity Details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-md-12">
		
          <div class="card">
           
			
			<div class="card-body">
			
			 <div class="row">
			
				  <div class="form-group col-md-3" style="">
                 @if(!empty($activity->image))
               
                  <img src="{{asset('uploads/activities/thumb/'.$activity->image)}}"  class="cimage" />
                
				@endif
              </div>
			   
				 <div class="slider-outer col-md-4">
				 <div class="owl-theme owl-carousel  float-right">
				 
                       @if($activity->images->count() > 0)
                           
                                
                                @foreach($activity->images as $image)
                                <div clss="item">
                              <img src="{{asset('uploads/activities/thumb/'.$image->filename)}}"  class="img-responsive">
                                </div>
                                @endforeach
                           
                            @endif 
                            </div>
				 </div>
				 
			 </div>
			 <hr class="col-xs-12">
			  <div class="row">
			   <div class="col-md-6" >
				 <h3><i class="far fa-fw  fa-check-circle"></i> {{$activity->title}}</h3>
				 
              </div>
			   <div class="col-md-6 text-right">
			   @php
            $minPrice = SiteHelpers::getActivityLowPrice($activity->id,$activity->agent_id,$voucher);
          @endphp
		  <small>Starting From </small><br/>
				 <h3>AED {{$minPrice}}</h3>
              </div>
			  
			  </div>
			  <hr class="col-xs-12">
			    <div class="row">
					<div class="col-md-12">
						<ul class="list-inline list-group list-group-horizontal">
							<li style="padding-right: 10px;">
							<i class="fas fa-fw fa-clock"></i> 2 Hours Approx
							</li>
							<li style="padding-right: 10px;">
							<i class="far fa-fw  fa-check-circle "></i> Mobile Voucher Accepted
							</li>
							<li style="padding-right: 10px;">
							<i class="far fa-fw  fa-check-circle"></i> Instant Confirmation 
							</li>
							<li style="padding-right: 10px;">
							<i class="fas fa-exchange-alt"></i> Transfer Available 
							</li>
						</ul>
					</div>
			  </div>
			 
			  <hr class="col-xs-12">

				<form action="{{route('voucher.activity.save')}}" method="post" class="form" >
				{{ csrf_field() }}
				 <input type="hidden" id="activity_id" name="activity_id" value="{{ $aid }}"  />
				 <input type="hidden" id="v_id" name="v_id" value="{{ $vid }}"  />
				 <input type="hidden" id="activity_vat" name="activity_vat" value="{{ ($activity->vat > 0)?$activity->vat:0 }}"  />
				 <input type="hidden" id="vat_invoice" name="vat_invoice" value="{{ $voucher->vat_invoice }}"  />
			
				<div class="row   mt-2" style="">
				<div class="col-lg-12">
				<h4>Tour Options</h4>
				</div>
				
				  </div>
				<div id="hDetailsDiv">
				<div class="row p-2" >
			 
			  <div class="col-md-12">
			  <table class="table rounded-corners" style="border-radius: 10px !important;font-size:10pt;">
                  <thead>
				  @if(!empty($activityPrices))
					  @foreach($activityPrices as $kk => $ap)
				  @if($kk == 0)
                  <tr>
					<th>Tour Option</th>
                    <th id="top"  colspan="2">Transfer Option</th>
					<th>Tour Date</th>
					<th>Adult</th>
                    <th>Child<br/><small>({{$ap->chield_start_age}}-{{$ap->chield_end_age}} Yrs)</small></th>
                    <th>Infant<br/><small>(Below {{$ap->chield_start_age}} Yrs)</small></th>
					<th>Ticket Only</th>
					<th>SIC Transfer</th>
					<th>PVT Transfer</th>
					<th>Net Disc</th>
					<th>Total Amount</th>
                  </tr>
				  @endif
				  
				  @php
				  $markup = SiteHelpers::getAgentMarkup($voucher->agent_id,$ap->activity_id,$ap->variant_code);
				  $actZone = SiteHelpers::getZone($activity->zones,$activity->sic_TFRS);
				 
				  @endphp
				   <tr>
                    <td><input type="checkbox"  name="activity_select[{{ $ap->u_code }}]" id="activity_select{{$kk}}" value="{{ $aid }}" class="actcsk" data-inputnumber="{{$kk}}" /> <strong>{{$ap->variant_name}}</strong>
					<input type="hidden"  name="variant_unique_code[{{ $ap->u_code }}]" id="variant_unique_code{{$kk}}" value="{{ $ap->u_code }}" data-inputnumber="{{$kk}}" /> 
					<input type="hidden"  name="variant_name[{{ $ap->u_code }}]" id="variant_name{{$kk}}" value="{{ $ap->variant_name }}" data-inputnumber="{{$kk}}" /> 
					<input type="hidden"  name="variant_code[{{ $ap->u_code }}]" id="variant_code{{$kk}}" value="{{ $ap->variant_code }}" data-inputnumber="{{$kk}}" /> 
					</td>
					<td> <select name="transfer_option[{{ $ap->u_code }}]" id="transfer_option{{$kk}}" class="form-control t_option" data-inputnumber="{{$kk}}" disabled="disabled">
						<option value="">--Select--</option>
						@if($activity->entry_type=='Ticket Only')
						<option value="Ticket Only" data-id="1">Ticket Only</option>
						@endif
						@if($activity->sic_TFRS==1)
						<option value="Shared Transfer" data-id="2">Shared Transfer</option>
						@endif
						@if($activity->pvt_TFRS==1)
						<option value="Pvt Transfer" data-id="3">Pvt Transfer</option>
						@endif
						</select>
						<input type="hidden" id="pvt_traf_val{{$kk}}" value="0"  name="pvt_traf_val[{{ $ap->u_code }}]"    />
						</td>
						<td> 
						<div style="display:none;border:none" id="transfer_zone_td{{$kk}}">
						@if($activity->sic_TFRS==1)
						@if(!empty($actZone))
						<select name="transfer_zone[{{ $ap->u_code }}]" id="transfer_zone{{$kk}}" class="form-control zoneselect"  data-inputnumber="{{$kk}}"  >
						
						
						@foreach($actZone as $z)
						<option value="{{$z['zone_id']}}" data-zonevalue="{{$z['zoneValue']}}" data-zoneptime="{{$z['pickup_time']}}">{{$z['zone']}}</option>
						@endforeach
						@else
							<input type="hidden" id="transfer_zone{{$kk}}" value=""  name="transfer_zone[{{ $ap->u_code }}]"    />
						@endif
						</select>
						@else
							<input type="hidden" id="transfer_zone{{$kk}}" value=""  name="transfer_zone[{{ $ap->u_code }}]"    />
						@endif
						
						<input type="hidden" id="zonevalprice{{$kk}}" value="0"  name="zonevalprice[{{ $ap->u_code }}]"    />
						</div> 
					</td>
							<input type="text" style="display:none"  id="pickup_location{{$kk}}" value=""  name="pickup_location[{{ $ap->u_code }}]" placeholder="Pickup Location" class="form-control "   />
					<td>
					<input type="text"id="tour_date{{$kk}}" value=""  name="tour_date[{{ $ap->u_code }}]" required disabled="disabled"  placeholder="Tour Date" class="form-control tour_datepicker"   />
					
					</td>
					<td><select name="adult[{{ $ap->u_code }}]" id="adult{{$kk}}" class="form-control priceChange" required data-inputnumber="{{$kk}}" disabled="disabled">
						<option value="">0</option>
						@for($a=$ap->adult_min_no_allowed; $a<=$ap->adult_max_no_allowed; $a++)
						<option value="{{$a}}">{{$a}}</option>
						@endfor
						</select></td>
                    <td><select name="child[{{ $ap->u_code }}]" id="child{{$kk}}" class="form-control priceChange" data-inputnumber="{{$kk}}" disabled="disabled">
						@for($child=$ap->chield_min_no_allowed; $child<=$ap->chield_max_no_allowed; $child++)
						<option value="{{$child}}">{{$child}}</option>
						@endfor
						</select></td>
                    <td><select name="infant[{{ $ap->u_code }}]" id="infant{{$kk}}" class="form-control priceChange" data-inputnumber="{{$kk}}" disabled="disabled">
						@for($inf=$ap->infant_min_no_allowed; $inf<=$ap->infant_max_no_allowed; $inf++)
						<option value="{{$inf}}">{{$inf}}</option>
						@endfor
						</select></td>
						<td>
						{{$markup['ticket_only']}}%
						<input type="hidden" value="{{$markup['ticket_only']}}" id="markup_p_ticket_only{{$kk}}"  name="markup_p_ticket_only[{{ $ap->u_code }}]"    />
						</td>
						<td>
						{{$markup['sic_transfer']}}%
						<input type="hidden" value="{{$markup['sic_transfer']}}" id="markup_p_sic_transfer{{$kk}}"  name="markup_p_sic_transfer[{{ $ap->u_code }}]"    />
						</td>
						<td>
						{{$markup['pvt_transfer']}}%
						<input type="hidden" value="{{$markup['pvt_transfer']}}" id="markup_p_pvt_transfer{{$kk}}"  name="markup_p_pvt_transfer[{{ $ap->u_code }}]"    />
						</td>
						<td>
						<input type="text" id="discount{{$kk}}" value="0"  name="discount[{{ $ap->u_code }}]" disabled="disabled" data-inputnumber="{{$kk}}" class="form-control onlynumbrf priceChangedis"    />
						</td>
						<td>
						@php
						$priceAd = ($ap->adult_rate_with_vat*$ap->adult_min_no_allowed);
						$mar = (($priceAd * $markup['ticket_only'])/100);
						$price = ($priceAd + ($ap->chield_rate_with_vat*$ap->chield_min_no_allowed) + ($ap->infant_rate_with_vat*$ap->infant_min_no_allowed));
						
						$price +=$mar;
						if($activity->vat > 0){
						$vat = (($activity->vat * $price)/100);
						$price +=$vat;
						}
						
						@endphp
						@if($voucher->vat_invoice == '1')
						<input type="hidden" value="{{$ap->adult_rate_without_vat}}" id="adultPrice{{$kk}}"  name="adultPrice[{{ $ap->u_code }}]"    />
						
						<input type="hidden" value="{{$ap->chield_rate_without_vat}}" id="childPrice{{$kk}}"  name="childPrice[{{ $ap->u_code }}]"    />
						<input type="hidden" value="{{$ap->infant_rate_without_vat}}" id="infPrice{{$kk}}"  name="infPrice[{{ $ap->u_code }}]"    />

						@else 

						<input type="hidden" value="{{$ap->adult_rate_with_vat}}" id="adultPrice{{$kk}}"  name="adultPrice[{{ $ap->u_code }}]"    />
						
						<input type="hidden" value="{{$ap->chield_rate_with_vat}}" id="childPrice{{$kk}}"  name="childPrice[{{ $ap->u_code }}]"    />
						<input type="hidden" value="{{$ap->infant_rate_with_vat}}" id="infPrice{{$kk}}"  name="infPrice[{{ $ap->u_code }}]"    />
						@endif
						<span id="price{{$kk}}" style="font-weight:bold">0</span>
						<input type="hidden" id="totalprice{{$kk}}" value="0"  name="totalprice[{{ $ap->u_code }}]"    />
						
					</td>
                  </tr>
				  @endforeach
				 @endif
				  </table>
              </div>
			 </div>	
			 </div>	
			  <div class="row">

        <div class="col-12 mt-3">
         
			<button type="submit" class="btn btn-success float-right mr-2" name="save_and_continue">Add To Cart</button>
        </div>
      </div>
			 </form>
		<div class="col-md-12">
			  <div class="row mt-5">
				
				  <div class="form-group col-md-12">
				  <hr class="col-xs-12">
                <h4>Description</h4>
				{!! $activity->description !!}
              </div>
			   <div class="form-group col-md-12" >
			   <hr class="col-xs-12">
				<h4>Inclusion</h4>
				{!! $activity->inclusion !!}
              </div>
			   <div class="form-group col-md-12">
			   <hr class="col-xs-12">
			   <h4>Booking Policy</h4>
				{!! $activity->booking_policy !!}
              </div>
			   <div class="form-group col-md-12" >
			   <hr class="col-xs-12">
			   <h4>Cancellation Policy</h4>
				{!! $activity->cancellation_policy !!}
              </div>
              </div>
			 
			  </div>
<div class="row mb-20" style="margin-bottom: 20px;">
<hr class="col-xs-12">
	<div class="col-md-2 mb-20">
	<a href="{{route('voucher.add.activity',$vid)}}" class="btn btn-secondary mr-2">Back</a>
	</div>
	<div class="col-md-2 offset-8 mb-20 pull-right">
		<a href="{{route('vouchers.show',$vid)}}" class="btn btn-primary mr-2">View Voucher</a>
	</div>
	

</div>
</div>	 	 
		  
		 
		
          <!-- /.card-body --> 
        </div>
		
          
			
          </div>
		 
          <!-- /.card -->
        </div>
      </div>
  
    </section>
    <!-- /.content -->
@endsection

@php
$dates = SiteHelpers::getDateListBoth($voucher->travel_from_date,$voucher->travel_to_date,$activity->black_sold_out)
@endphp

@section('scripts')
 <script>
         $(function() {
          
            var disabledDates = "{{$dates['disabledDates']}}";
            var availableDates = "{{$dates['availableDates']}}";

            
            $(".tour_datepicker").datepicker({
                beforeShowDay: function(date) {
                    var dateString = $.datepicker.formatDate('yy-mm-dd', date);
                    
					/* 
					if (disabledDates.indexOf(dateString) != -1) {
                        return [false, "disabled-date", "This date is disabled"];
                    }
					if (date.getDay() === 2) {
                        return [false, "disabled-day", "Sunday is disabled"];
                    } */
                    if (availableDates.indexOf(dateString) != -1) {
                        return [true, "available-date", "This date is available"];
                    } else {
					return [false, "disabled-date", "This date is disabled"];	
					}
						
                    return [true];
                },
				weekStart: 1,
				daysOfWeekHighlighted: "6,0",
				autoclose: true,
				todayHighlight: true,
				dateFormat: 'dd-mm-yy'
            });
        }); 
    </script>
 <script type="text/javascript">
 $(document).ready(function() {
	

$(document).on('change', '.priceChange', function(evt) {
	let inputnumber = $(this).data('inputnumber');
	var activity_id = $("#activity_id").val();
	var is_vat_invoice = $("body  #vat_invoice").val();
	if(is_vat_invoice == 1){
		var activity_vat = $("#activity_vat").val();
	} else {
		var activity_vat = 0;
	}

	
	let adult = parseInt($("body #adult"+inputnumber).val());
	let child = parseInt($("body #child"+inputnumber).val());
	let infant = parseInt($("body #infant"+inputnumber).val());
	let discount = parseFloat($("body #discount"+inputnumber).val());
	//alert(discount);
	let markup_p_ticket_only = parseFloat($("body #markup_p_ticket_only"+inputnumber).val());
	let markup_p_sic_transfer = parseFloat($("body #markup_p_sic_transfer"+inputnumber).val());
	let markup_p_pvt_transfer = parseFloat($("body #markup_p_pvt_transfer"+inputnumber).val());
	
	let adultPrice = $("body #adultPrice"+inputnumber).val();
	let childPrice = $("body #childPrice"+inputnumber).val();
	let infPrice = $("body #infPrice"+inputnumber).val();
	var ad_price = (adult*adultPrice) ;
	var chd_price = (child*childPrice) ;
	var ad_ch_TotalPrice = ad_price + chd_price;
	var ticket_only_markupamt = ((ad_ch_TotalPrice*markup_p_ticket_only)/100);
	
	
	let t_option_val = $("body #transfer_option"+inputnumber).find(':selected').data("id");
	//$("body #pickup_location"+inputnumber).val('');
	let grandTotal = 0;
	let grandTotalAfterDis = 0;
	if(t_option_val == 3)
	{
		var totaladult = parseInt(adult + child);
	getPVTtransfer(activity_id,totaladult,markup_p_pvt_transfer,inputnumber);
	$("#loader-overlay").show();	
	waitForInputValue(inputnumber, function(pvt_transfer_markupamt_total) {
		var totalPrice = parseFloat(ad_ch_TotalPrice + (infant * infPrice) + ticket_only_markupamt  + pvt_transfer_markupamt_total);
		
		grandTotal = ( (totalPrice - discount));
		let vatPrice = parseFloat(((activity_vat/100) * grandTotal));
		grandTotalAfterDis = parseFloat(grandTotal+vatPrice);
			 
		if(isNaN(grandTotalAfterDis))
		{
		$("body #totalprice"+inputnumber).val(0);
		$("body #price"+inputnumber).text(0);
		}
		else
		{
			if(grandTotalAfterDis > 0)
			{
			$("body #totalprice"+inputnumber).val(grandTotalAfterDis.toFixed(2));
			$("body #price"+inputnumber).text("AED "+grandTotalAfterDis.toFixed(2));
			}
			else
			{
				$("body #totalprice"+inputnumber).val(0);
				$("body #price"+inputnumber).text(0);
			}
		}
		$("#loader-overlay").hide();
		});
	}
	else
	{
		if(t_option_val == 2)
		{
			let zonevalue = parseFloat($("#transfer_zone"+inputnumber).find(':selected').data("zonevalue"));
			let zoneptime = $("#transfer_zone"+inputnumber).find(':selected').data("zoneptime");
			
			//$("body #pickup_location"+inputnumber).val(zoneptime);
			var totaladult = parseInt(adult + child);
			let zonevalueTotal = (totaladult * zonevalue);
			$("#zonevalprice"+inputnumber).val(zonevalueTotal);
			var sic_transfer_markupamt = ((zonevalueTotal *  markup_p_sic_transfer)/100);
			var totalPrice = parseFloat(ad_ch_TotalPrice + (infant * infPrice) + ticket_only_markupamt + sic_transfer_markupamt + zonevalueTotal);
			
			grandTotal = ( (totalPrice - discount));
			 let vatPrice = parseFloat(((activity_vat/100) * grandTotal));
			 grandTotalAfterDis = parseFloat(vatPrice + grandTotal);
		}
		else
		{
			var totalPrice = parseFloat(ad_ch_TotalPrice + (infant * infPrice) + ticket_only_markupamt);
			
			 grandTotal = ( (totalPrice - discount));
			let vatPrice = parseFloat(((activity_vat/100) * grandTotal));
			 grandTotalAfterDis = parseFloat(vatPrice + grandTotal);
			
		}
		
		if(isNaN(grandTotalAfterDis))
		{
		$("body #totalprice"+inputnumber).val(0);
		$("body #price"+inputnumber).text(0);
		}
		else
		{
		if(grandTotalAfterDis > 0)
			{
			$("body #totalprice"+inputnumber).val(grandTotalAfterDis.toFixed(2));
			$("body #price"+inputnumber).text("AED "+grandTotalAfterDis.toFixed(2));
			}
			else
			{
				$("body #totalprice"+inputnumber).val(0);
				$("body #price"+inputnumber).text(0);
			}
		}
	}
	
	
	
});
$(document).on('blur','.priceChangedis',function(){
	let inputnumber = $(this).data('inputnumber');
	let inputvale = parseFloat($(this).val());
	if(inputvale == null || isNaN(inputvale))
	{
		inputvale = 0;
		$(this).val(0);
	}
  $("#adult"+inputnumber).trigger("change");
});
$(document).on('change', '.actcsk', function(evt) {
	let inputnumber = $(this).data('inputnumber');
	if ($(this).is(':checked')) {
      $("body #transfer_option"+inputnumber).prop('required',true);
	  $("body #tour_date"+inputnumber).prop('required',true);
	  
	  $("body #transfer_option"+inputnumber).prop('disabled',false);
	  $("body #tour_date"+inputnumber).prop('disabled',false);
	  $("body #adult"+inputnumber).prop('disabled',false);
	  $("body #child"+inputnumber).prop('disabled',false);
	  $("body #infant"+inputnumber).prop('disabled',false);
	  $("body #discount"+inputnumber).prop('disabled',false);
    } else {
      $("body #transfer_option"+inputnumber).prop('required',false);
	  $("body #tour_date"+inputnumber).prop('required',false);
	  
	  $("body #transfer_option"+inputnumber).prop('disabled',true);
	  $("body #tour_date"+inputnumber).prop('disabled',true);
	  $("body #adult"+inputnumber).prop('disabled',true);
	  $("body #child"+inputnumber).prop('disabled',true);
	  $("body #infant"+inputnumber).prop('disabled',true);
	  $("body #discount"+inputnumber).prop('disabled',true);
    }
});

$(document).on('change', '.t_option', function(evt) {
	//alert("Asas");
	//alert("Asas");
	let inputnumber = $(this).data('inputnumber');
	let t_option_val = $(this).find(':selected').data("id");
	//$("#top").removeAttr("colspan");
	$("#transfer_zone_td"+inputnumber).css("display","none");
	$("#pickup_location_td"+inputnumber).css("display","none");
	$("body #transfer_zone"+inputnumber).prop('required',false);
	$("#zonevalprice"+inputnumber).val(0);
	$('#transfer_zone'+inputnumber).prop('selectedIndex',0);
	$("#pvt_traf_val"+inputnumber).val(0);
	$("#adult"+inputnumber).trigger("change");
	if(t_option_val == 2){
		//$("#top").attr("colspan",2);
		$("#transfer_zone_td"+inputnumber).css("display","block");
		//$("#pickup_location_td"+inputnumber).css("display","block");
		$("body #transfer_zone"+inputnumber).prop('required',true);
	} else if(t_option_val == 3){
		//$("#top").attr("colspan",2);
		//$("#pickup_location_td"+inputnumber).css("display","block");
		var activity_id = $("#activity_id").val();
		let adult = parseInt($("body #adult"+inputnumber).find(':selected').val());
		let child = parseInt($("body #child"+inputnumber).find(':selected').val());
		var totaladult = parseInt(adult + child);
		//alert(totaladult);
		let markup_p_pvt_transfer = parseFloat($("body #markup_p_pvt_transfer"+inputnumber).val());
		getPVTtransfer(activity_id,totaladult,markup_p_pvt_transfer,inputnumber);
		$("#adult"+inputnumber).trigger("change");
	}
});

$(document).on('change', '.zoneselect', function(evt) {
	let inputnumber = $(this).data('inputnumber');
	let zonevalue = parseFloat($(this).find(':selected').data("zonevalue"));
	//$("#top").attr("colspan",2);
	let adult = parseInt($("body #adult"+inputnumber).find(':selected').val());
		let child = parseInt($("body #child"+inputnumber).find(':selected').val());
		var totaladult = parseInt(adult + child);
		let zonevalueTotal = totaladult * zonevalue;
		$("#zonevalprice"+inputnumber).val(zonevalueTotal);
		$("#adult"+inputnumber).trigger("change");
});

function getPVTtransfer(acvt_id,adult,markupPer,inputnumber)
{
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('voucher.getPVTtransferAmount')}}",
            type: 'POST',
            dataType: "json",
            data: {
               acvt_id: acvt_id,
			   adult: adult,
			   markupPer: markupPer
            },
            success: function( data ) {
               //console.log( data );
			   $("#pvt_traf_val"+inputnumber).val(data);
            }
          });
}

function waitForInputValue(inputnumber, callback) {
  var $input = $("body #pvt_traf_val" + inputnumber);
  
  var interval = setInterval(function() {
    var pvt_transfer_markupamt_total = parseFloat($input.val());
    
    if (!isNaN(pvt_transfer_markupamt_total)) {
      // Value is available, execute the callback function
      clearInterval(interval); // Stop the interval
      callback(pvt_transfer_markupamt_total);
    }
  }, 2000); // Check every 100 milliseconds
}
});

$(document).on('keypress', '.onlynumbrf', function(evt) {
	var charCode = (evt.which) ? evt.which : evt.keyCode
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
  return true;

});

  </script>  

<script type="text/javascript">
$(window).on('load', function(){
 var owl = $('.owl-carousel');
owl.owlCarousel({
    loop:true,
    nav:true,
	dots:false,
    margin:10,
	items:1
  
});

  
  
});


</script>  
@endsection