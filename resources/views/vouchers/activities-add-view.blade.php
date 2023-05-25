@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Voucher Code :{{$voucher->code}} , Activity : {{ $activity->title }} </h1>
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
			
			
			<header class="profile-header">
          <div class="profile-image" style="border-radius:0px;height:auto;"> @if(!empty($activity->image))<img src="{{asset('uploads/activities/'.$activity->image)}}"  />@endif </div>
				<div class="profile-content">
				
					<div class="row">
              
			      <div class="col-lg-4 mb-3">
                <label for="inputName">Name:</label>
                {{$activity->title}}
              </div>
			  <div class="col-lg-4 mb-3">
                <label for="inputName">Code:</label>
                {{$activity->code}}
              </div>
			   <div class="col-lg-4 mb-3">
                <label for="inputName">Type of Activity:</label>
                {{ $typeActivities[$activity->type_activity]}}
              </div>
			  <div class="col-lg-4 mb-3">
                <label for="inputName">Entry Type:</label>
               {{ $activity->entry_type }}
              </div>
			  
			  <div class="col-lg-4 mb-3">
                <label for="inputName">Priror Booking Time:</label>
               {{ $activity->priror_booking_time }}
              </div>
              
			  @if($activity->is_opendated)
			  <div class="col-lg-4 mb-3">
                <label for="inputName">Valid Till (in Days from Date of Booking):</label>
               {{ $activity->valid_till }}
              </div>
			  @endif
			<div class="col-lg-12 mb-3">
                <label for="inputName">Availability:</label>
               @if($activity->availability=='All')
				   All Days
			   @else
			   {{$activity->availability}}
			   @endif
              </div>
			
          </div>	
		  
				</div>
          
			
				</header>
				
				<form action="{{route('voucher.activity.save')}}" method="post" class="form" >
				{{ csrf_field() }}
				 <input type="hidden" id="activity_id" name="activity_id" value="{{ $aid }}"  />
				 <input type="hidden" id="v_id" name="v_id" value="{{ $vid }}"  />
				 <input type="hidden" id="activity_vat" name="activity_vat" value="{{ ($activity->vat > 0)?$activity->vat:0 }}"  />
				<div class="row p-2">
				<div class="col-lg-12">
				<h3>Activity Details</h3>
				</div>
				
				  </div>
				<div id="hDetailsDiv">
				<div class="row p-2">
			 
			  <div class="col-md-12">
                <table class="table table-bordered">
                  <thead>
				  
                  <tr>
					<th>Tour Option</th>
                    <th id="top">Transfer Option</th>
					<th>Tour Date</th>
					<th>Adult</th>
                    <th>Child(3-10Yrs)</th>
                    <th>Infant</th>
					<th>Ticket Only</th>
					<th>SIC Transfer</th>
					<th>PVT Transfer</th>
					<th>Total Amount</th>
                  </tr>
				  @if(!empty($activityPrices))
					  @foreach($activityPrices as $kk => $ap)
				  
				  @php
				  $markup = SiteHelpers::getAgentMarkup($voucher->agent_id,$ap->activity_id,$ap->variant_code);
				  $actZone = SiteHelpers::getZone($activity->zones,$activity->sic_TFRS);
				 
				  @endphp
				   <tr>
                    <th><input type="checkbox"  name="activity_select[]" id="activity_select{{$kk}}" value="{{ $aid }}" class="actcsk" data-inputnumber="{{$kk}}" /> {{$ap->variant_name}} - {{$ap->variant_code}}
					<input type="hidden"  name="variant_name[]" id="variant_name{{$kk}}" value="{{ $ap->variant_name }}" data-inputnumber="{{$kk}}" /> 
					<input type="hidden"  name="variant_code[]" id="variant_code{{$kk}}" value="{{ $ap->variant_code }}" data-inputnumber="{{$kk}}" /> 
					</th>
					<td> <select name="transfer_option[]" id="transfer_option{{$kk}}" class="form-control t_option" data-inputnumber="{{$kk}}" disabled="disabled">
						<option value="">--Select--</option>
						@if($activity->entry_type=='Activity')
						<option value="Without Transfer" data-id="1">Without Transfer</option>
						@endif
						@if($activity->sic_TFRS==1)
						<option value="Shared Transfer" data-id="2">Shared Transfer</option>
						@endif
						@if($activity->pvt_TFRS==1)
						<option value="Pvt Transfer" data-id="3">Pvt Transfer</option>
						@endif
						</select>
						<input type="hidden" id="pvt_traf_val{{$kk}}" value="0"  name="pvt_traf_val[]"    />
						</td>
						<td style="display:none" id="transfer_zone_td{{$kk}}"> 
						
						<select name="transfer_zone[]" id="transfer_zone{{$kk}}" class="form-control zoneselect"  data-inputnumber="{{$kk}}">
						<option value="" data-zonevalue="0">--Select Zone--</option>
						@if($activity->sic_TFRS==1)
						@foreach($actZone as $z)
						<option value="{{$z['zone_id']}}" data-zonevalue="{{$z['zoneValue']}}">{{$z['zone']}}</option>
						@endforeach
						@endif
						</select>
						
						<input type="hidden" id="zonevalprice{{$kk}}" value="0"  name="zonevalprice[]"    />
					</td>
					<td><input type="text" id="tour_date{{$kk}}"  name="tour_date[]"  class="form-control datepicker"  disabled="disabled" /></td>
					<td><select name="adult[]" id="adult{{$kk}}" class="form-control priceChange" data-inputnumber="{{$kk}}" disabled="disabled">
						
						@for($a=$ap->adult_min_no_allowed; $a<=$ap->adult_max_no_allowed; $a++)
						<option value="{{$a}}">{{$a}}</option>
						@endfor
						</select></td>
                    <td><select name="child[]" id="child{{$kk}}" class="form-control priceChange" data-inputnumber="{{$kk}}" disabled="disabled">
						@for($child=$ap->chield_min_no_allowed; $child<=$ap->chield_max_no_allowed; $child++)
						<option value="{{$child}}">{{$child}}</option>
						@endfor
						</select></td>
                    <td><select name="infant[]" id="infant{{$kk}}" class="form-control priceChange" data-inputnumber="{{$kk}}" disabled="disabled">
						@for($inf=$ap->infant_min_no_allowed; $inf<=$ap->infant_max_no_allowed; $inf++)
						<option value="{{$inf}}">{{$inf}}</option>
						@endfor
						</select></td>
						<td>
						{{$markup['ticket_only']}}%
						<input type="hidden" value="{{$markup['ticket_only']}}" id="markup_p_ticket_only{{$kk}}"  name="markup_p_ticket_only[]"    />
						</td>
						<td>
						{{$markup['sic_transfer']}}%
						<input type="hidden" value="{{$markup['sic_transfer']}}" id="markup_p_sic_transfer{{$kk}}"  name="markup_p_sic_transfer[]"    />
						</td>
						<td>
						{{$markup['pvt_transfer']}}%
						<input type="hidden" value="{{$markup['pvt_transfer']}}" id="markup_p_pvt_transfer{{$kk}}"  name="markup_p_pvt_transfer[]"    />
						</td>
						<td>
						@php
						$priceAd = ($ap->adult_rate_without_vat*$ap->adult_min_no_allowed);
						$mar = (($priceAd * $markup['ticket_only'])/100);
						$price = ($priceAd + ($ap->chield_rate_without_vat*$ap->chield_min_no_allowed) + ($ap->infant_rate_without_vat*$ap->infant_min_no_allowed));
						
						$price +=$mar;
						if($activity->vat > 0){
						$vat = (($activity->vat * $price)/100);
						$price +=$vat;
						}
						
						@endphp
						<input type="hidden" value="{{$ap->adult_rate_without_vat}}" id="adultPrice{{$kk}}"  name="adultPrice[]"    />
						
						<input type="hidden" value="{{$ap->chield_rate_without_vat}}" id="childPrice{{$kk}}"  name="childPrice[]"    />
						<input type="hidden" value="{{$ap->infant_rate_without_vat}}" id="infPrice{{$kk}}"  name="infPrice[]"    />
						<span id="price{{$kk}}">{{number_format($price, 2, '.', '')}}</span>
						<input type="hidden" id="totalprice{{$kk}}" value="{{$price}}"  name="totalprice[]"    />
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
          <a href="{{ route('vouchers.index') }}" class="btn btn-secondary">Back To Vouchers</a>
		  
		   <a href="{{route('vouchers.show',$vid)}}" class="btn btn-secondary mr-2">View Vouchers</a>
          <button type="submit" class="btn btn-primary float-right" name="save">Save</button>
			<button type="submit" class="btn btn-success float-right mr-2" name="save_and_continue">Save & Add More Activity</button>
        </div>
      </div>
			 </form>
          <!-- /.card-body --> 
        </div>
		
          
			
          </div>
		 
          <!-- /.card -->
        </div>
      </div>
  
    </section>
    <!-- /.content -->
@endsection



@section('scripts')
 <script type="text/javascript">
 $(document).ready(function() {
	

$(document).on('change', '.priceChange', function(evt) {
	let inputnumber = $(this).data('inputnumber');
	var activity_id = $("#activity_id").val();
	let activity_vat = $("#activity_vat").val();
	
	let adult = $("body #adult"+inputnumber).val();
	let child = $("body #child"+inputnumber).val();
	let infant = $("body #infant"+inputnumber).val();
	let markup_p_ticket_only = parseFloat($("body #markup_p_ticket_only"+inputnumber).val());
	let markup_p_sic_transfer = parseFloat($("body #markup_p_sic_transfer"+inputnumber).val());
	let markup_p_pvt_transfer = parseFloat($("body #markup_p_pvt_transfer"+inputnumber).val());
	let zonevalprice = parseFloat($("body #zonevalprice"+inputnumber).val());
	let adultPrice = $("body #adultPrice"+inputnumber).val();
	let childPrice = $("body #childPrice"+inputnumber).val();
	let infPrice = $("body #infPrice"+inputnumber).val();
	var ad_price = (adult*adultPrice);
	var ticket_only_markupamt = ((ad_price*markup_p_ticket_only)/100);
	var sic_transfer_markupamt = ((zonevalprice*markup_p_sic_transfer)/100);
	
	let t_option_val = $("body #transfer_option"+inputnumber).find(':selected').data("id");
	
	if(t_option_val == 3)
	{
	getPVTtransfer(activity_id,adult,markup_p_pvt_transfer,inputnumber);
	$("#loader-overlay").show();	
	waitForInputValue(inputnumber, function(pvt_transfer_markupamt_total) {
		var totalPrice = parseFloat(ad_price + (child * childPrice) + (infant * infPrice) + ticket_only_markupamt + sic_transfer_markupamt + zonevalprice + pvt_transfer_markupamt_total);
		let vatPrice = parseFloat(((totalPrice*activity_vat)/100));
		let grandTotal = (vatPrice + totalPrice);
		$("body #totalprice"+inputnumber).val(grandTotal.toFixed(2));
		$("body #price"+inputnumber).text(grandTotal.toFixed(2));
		$("#loader-overlay").hide();
		});
	}
	else
	{
		var totalPrice = parseFloat(ad_price + (child * childPrice) + (infant * infPrice) + ticket_only_markupamt + sic_transfer_markupamt + zonevalprice);
		let vatPrice = parseFloat(((totalPrice*activity_vat)/100));
		let grandTotal = (vatPrice + totalPrice);
		$("body #totalprice"+inputnumber).val(grandTotal.toFixed(2));
		$("body #price"+inputnumber).text(grandTotal.toFixed(2));
	}
	
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
    } else {
      $("body #transfer_option"+inputnumber).prop('required',false);
	  $("body #tour_date"+inputnumber).prop('required',false);
	  
	  $("body #transfer_option"+inputnumber).prop('disabled',true);
	  $("body #tour_date"+inputnumber).prop('disabled',true);
	  $("body #adult"+inputnumber).prop('disabled',true);
	  $("body #child"+inputnumber).prop('disabled',true);
	  $("body #infant"+inputnumber).prop('disabled',true);
    }
});

$(document).on('change', '.t_option', function(evt) {
	//alert("Asas");
	//alert("Asas");
	let inputnumber = $(this).data('inputnumber');
	let t_option_val = $(this).find(':selected').data("id");
	$("#top").removeAttr("colspan");
	$("#transfer_zone_td"+inputnumber).css("display","none");
	$("body #transfer_zone"+inputnumber).prop('required',false);
	$("#zonevalprice"+inputnumber).val(0);
	$('#transfer_zone'+inputnumber).prop('selectedIndex',0);
	$("#pvt_traf_val"+inputnumber).val(0);
	$("#adult"+inputnumber).trigger("change");
	if(t_option_val == 2){
		$("#top").attr("colspan",2);
		$("#transfer_zone_td"+inputnumber).css("display","block");
		$("body #transfer_zone"+inputnumber).prop('required',true);
	} else if(t_option_val == 3){
		var activity_id = $("#activity_id").val();
		let adult = $("body #adult"+inputnumber).find(':selected').val();
		let markup_p_pvt_transfer = parseFloat($("body #markup_p_pvt_transfer"+inputnumber).val());
		getPVTtransfer(activity_id,adult,markup_p_pvt_transfer,inputnumber);
		$("#adult"+inputnumber).trigger("change");
	}
});

$(document).on('change', '.zoneselect', function(evt) {
	let inputnumber = $(this).data('inputnumber');
	let zonevalue = $(this).find(':selected').data("zonevalue");
		$("#top").attr("colspan",2);
		$("#zonevalprice"+inputnumber).val(zonevalue);
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



  </script>   
@endsection