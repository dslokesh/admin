@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Booking Details</h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

  

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <style type="text/css">
    /* Multistep */
/* See below for SASS (allows you easily set dot radius and progress bar thickness and adjusts everything else! */
.multistep .multistep-step {
    padding: 0;
    position: relative;
    margin-bottom: 10px;
}

    .multistep .multistep-step .multistep-stepname {
        margin-bottom: 16px;
        color: #595959;
        font-size: 1.6rem;
        white-space: nowrap;
    }

    .multistep .multistep-step .multistep-dot {
        position: absolute;
        right: 50%;
        left: 50%;
        width: 32px;
        height: 32px;
        display: block;
        margin-top: -16px;
        margin-left: -15.5px;
        border-radius: 50%;
        background: #f5f5f5;
        /* Inner Dot */
    }

        .multistep .multistep-step .multistep-dot:after {
            content: ' ';
            border-radius: 50px;
            position: absolute;
            top: 8px;
            bottom: 8px;
            left: 8px;
            right: 8px;
            background: #e0e0e0;
        }

    .multistep .multistep-step .progress {
        position: absolute;
        width: 100%;
        height: 10.56px;
        margin-top: -5.28px;
        box-shadow: none;
        border-radius: 0;
    }

        .multistep .multistep-step .progress .progress-bar {
            width: 0px;
            box-shadow: none;
            background: #808080;
        }

    .multistep .multistep-step:first-child > .progress {
        left: 50%;
        width: 50%;
    }

    .multistep .multistep-step:last-child > .progress {
        width: 50%;
    }

    .multistep .multistep-step.complete .multistep-dot {
        background: #808080;
    }

        .multistep .multistep-step.complete .multistep-dot:after {
            /*  /* background: #fbbd19; */ */
        }

    .multistep .multistep-step.complete .progress > .progress-bar {
        width: 100%;
    }

    .multistep .multistep-step.next:hover .multistep-dot {
        background: #808080;
    }

        .multistep .multistep-step.next:hover .multistep-dot:after {
             /* background: #fbbd19; */
        }

    .multistep .multistep-step.current .multistep-dot {
        background: #808080;
    }

        .multistep .multistep-step.current .multistep-dot:after {
             /* background: #fbbd19; */
        }

    .multistep .multistep-step.current .progress > .progress-bar {
        width: 50%;
    }

    .multistep .multistep-step.current:first-child > .progress > .progress-bar {
        width: 0%;
    }

    .multistep .multistep-step.current:last-child > .progress > .progress-bar {
        width: 100%;
    }

    .multistep .multistep-step a.multistep-dot {
        pointer-events: none;
    }

    .multistep .multistep-step.next a.multistep-dot {
        pointer-events: all;
    }
    
    
/* SASS
$inactiveColor: #f5f5f5;
$inactiveDotColor: #e0e0e0;
$activeColor: #808080;
$activeDotColor: #fbbd19;
$stepNameColor: #595959;
$dotRadius: 16px;
$barThickness: $dotRadius * .66;
$stepNameSize: 1.6rem;

.multistep {
    .multistep-step {
        padding: 0;
        position: relative;
        margin-bottom: 10px;

        .multistep-stepname {
            margin-bottom: $dotRadius;
            color: $stepNameColor;
            font-size: $stepNameSize;
            white-space: nowrap;
        }

        .multistep-dot {
            position: absolute;
            right: 50%;
            left: 50%;
            width: $dotRadius * 2;
            height: $dotRadius * 2;
            display: block;
            margin-top: -$dotRadius;
            margin-left: -$dotRadius + .5;
            border-radius: 50%;
            background: $inactiveColor;
            &:after {
                content: ' ';
                border-radius: 50px;
                position: absolute;
                top: $dotRadius / 2;
                bottom: $dotRadius / 2;
                left: $dotRadius / 2;
                right: $dotRadius / 2;
                background: $inactiveDotColor;
            }
        }

        .progress {
            position: absolute;
            width: 100%;
            height: $barThickness;
            margin-top: -$barThickness / 2;
            box-shadow: none;
            border-radius: 0;

            .progress-bar {
                width: 0px;
                box-shadow: none;
                background: $activeColor;
            }
        }

        &:first-child > .progress {
            left: 50%;
            width: 50%;
        }

        &:last-child > .progress {
            width: 50%;
        }

        &.complete {
            .multistep-dot {
                background: $activeColor;

                &:after {
                    background: $activeDotColor;
                }
            }

            .progress > .progress-bar {
                width: 100%;
            }
        }

        &.next:hover {
            .multistep-dot {
                background: $activeColor;
            }

            .multistep-dot:after {
                background: $activeDotColor;
            }
        }

        &.current {
            .multistep-dot {
                background: $activeColor;

                &:after {
                    background: $activeDotColor;
                }
            }

            .progress > .progress-bar {
                width: 50%;
            }

            &:first-child > .progress > .progress-bar {
                width: 0%;
            }

            &:last-child > .progress > .progress-bar {
                width: 100%;
            }
        }

        a.multistep-dot {
            pointer-events: none;
        }

        &.next a.multistep-dot {
            pointer-events: all;
        }
    }
}
*/    </style>
<div class="row multistep">
        <div class="col-md-3 multistep-step complete">
            <div class="text-center multistep-stepname" style="font-size: 16px;">Add to Cart</div>
            <div class="progress"><div class="progress-bar"></div></div>
            <a href="#" class="multistep-dot"></a>
        </div>

        <div class="col-md-3 multistep-step current">
            <div class="text-center multistep-stepname" style="font-size: 16px;">Payment</div>
            <div class="progress"><div class="progress-bar"></div></div>
            <a href="#" class="multistep-dot"></a>
        </div>

        <div class="col-md-3 multistep-step next">
            <div class="text-center multistep-stepname" style="font-size: 16px;">Voucher</div>
            <div class="progress"><div class="progress-bar"></div></div>
            <a href="#" class="multistep-dot"></a>
        </div>

        
    </div>
        <div class="row" style="margin-top: 30px;">
		
          <!-- left column -->
          <div class="offset-md-1 col-md-6">
		   <form id="cusDetails" method="post" action="{{route('agent.vouchers.status.change',$voucher->id)}}" >
			 {{ csrf_field() }}
            <!-- general form elements -->
            <div class="card card-default">
              <div class="card-header">
                 <h3 class="card-title"><i class="nav-icon fas fa-user" style="color:black"></i> Passenger Details</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
                <div class="card-body">
                  <div class="row" style="margin-bottom: 15px;">
                    <div class="col-2">
                      <select class="form-control">
                        <option>Mr.</option>
                        <option>Mrs.</option>
                        <option>Miss</option>
                      </select>
                    </div>
                    <div class="col-5">
                      <input type="text" name="fname" value="{{$fname}}"  class="form-control" placeholder="First Name" required>
                    </div>
                    <div class="col-5">
                      <input type="text" name="lname" value="{{$lname}}" class="form-control" placeholder="Last Name" required>
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: 15px;">
                    <div class="col-4">
                     <input type="text" name="customer_email" value="{{(!empty($voucher->guest_email))?$voucher->guest_email:$voucher->agent->email}}" class="form-control" placeholder="Email ID">
                    </div>
                    <div class="col-4">
                      <input type="text" name="customer_mobile" value="{{(!empty($voucher->guest_phone))?$voucher->guest_phone:$voucher->agent->email}}" class="form-control" placeholder="Mobile No.">
                    </div>
                    <div class="col-4">
                      <input type="text" name="agent_ref_no"  value="{{$voucher->agent_ref_no}}" class="form-control" placeholder="Agent Reference No.">
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: 5px;">
                    <div class="col-12">
                      <textarea type="text" class="form-control" style="resize:none;" name="remark" placeholder="Remark" rows="2">{{$voucher->remark}}</textarea>
                    </div>
                   
                  </div>
                </div>
                <!-- /.card-body -->
				
               
            </div>
            <!-- /.card -->
			@php
					$ii = 0;
					@endphp
			@if(!empty($voucherActivity) && $voucher->is_activity == 1)
				@foreach($voucherActivity as $ap)
				  @if(($ap->transfer_option == 'Shared Transfer') || ($ap->transfer_option == 'Pvt Transfer'))
				  @php
					$ii = 1;
					@endphp
				@endif
					@endforeach
			
            <div class="card card-default {{($ii=='0')?'hide':''}}">
              <div class="card-header">
                <h3 class="card-title"><i class="nav-icon fas fa-book" style="color:black"></i> Additional Information</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
                <div class="card-body">
					@if(!empty($voucherActivity))
						 @php
					$c=0;
					@endphp
					  @foreach($voucherActivity as $ap)
				  @if(($ap->transfer_option == 'Shared Transfer') || ($ap->transfer_option == 'Pvt Transfer'))
				  @php
					$c++;
					$activity = SiteHelpers::getActivity($ap->activity_id);
          
					@endphp
					
                  <div class="row" style="margin-bottom: 15px;">
                    <div class="col-12"><p><strong>{{$c}}. {{$ap->variant_name}} : {{$ap->transfer_option}}
					@if($ap->transfer_option == 'Shared Transfer')
					@php
					$zone = SiteHelpers::getZoneName($ap->transfer_zone);
					@endphp
					- Zone :{{$zone->name}}
					@endif</strong></p></div>
					@if($activity->entry_type=='Arrival')
						<div class="form-group col-md-6">
						 
						<input type="text" class="form-control inputsave autodropoff_location" id="dropoff_location{{$ap->id}}" data-name="dropoff_location"  data-id="{{$ap->id}}" value="{{$ap->dropoff_location}}" required data-zone="{{$ap->transfer_zone}}"  placeholder="Dropoff Location*" />
						<label for="inputName" style="width: 100%;"> <span class="float-left"><input type="checkbox" data-idinput="dropoff_location{{$ap->id}}" class="chk_other " data-name="dropoff_other"  data-id="{{$ap->id}}" value="1"  /> Other<span></label>
						</div>
					
					
					<div class="form-group col-md-6 ">
				<input type="text" class="form-control inputsave" id="passenger_name{{$ap->id}}" data-name="passenger_name"  data-id="{{$ap->id}}" required value="{{$ap->passenger_name}}"  placeholder="Passenger Name*" />
				
              </div>
			 
			   <div class="form-group col-md-6 ">
                 <input type="text" id="actual_pickup_time{{$ap->id}}" value="{{$ap->actual_pickup_time}}" class="form-control inputsave" required placeholder="Arrival Time*" data-id="{{$ap->id}}" data-name="actual_pickup_time" />
				 
              </div>
			 
			  
			  <div class="form-group col-md-6 ">
                 <input type="text" id="flight_no{{$ap->id}}" value="{{$ap->flight_no}}" class="form-control inputsave"  placeholder="Arrival Flight Details*" required data-id="{{$ap->id}}" data-name="flight_no" />
				
              </div>
                    
					<div class="form-group col-md-12">
					<input type="text" class="form-control inputsave" id="remark{{$ap->id}}" data-name="remark"  data-id="{{$ap->id}}" value="{{$ap->remark}}"  placeholder="Remark" />
                    </div>
					
					@elseif($activity->entry_type=='Interhotel')
		  
                    <div class="form-group col-md-6">
						
					<input type="text" class="form-control inputsave autocom" id="pickup_location{{$ap->id}}" data-name="pickup_location"  data-id="{{$ap->id}}" value="{{$ap->pickup_location}}" data-zone="{{$ap->transfer_zone}}"  placeholder="Pickup Location*" required />
										 <label for="inputName" style="width: 100%;"><span class="float-left"><input type="checkbox" data-idinput="pickup_location{{$ap->id}}" class="chk_other " data-name="pickup_other"  data-id="{{$ap->id}}" value="1"  /> Other<span></label>

                     
                    </div>
					 <div class="form-group col-md-6">
					
					 
					
					<input type="text" class="form-control inputsave autodropoff_location" id="dropoff_location{{$ap->id}}" data-name="dropoff_location"  data-id="{{$ap->id}}" value="{{$ap->dropoff_location}}" data-zone="{{$ap->transfer_zone}}"  required placeholder="Dropoff Location*" />
					 <label for="inputName" style="width: 100%;"><span class="float-left"><input type="checkbox" data-idinput="dropoff_location{{$ap->id}}" class="chk_other " data-name="dropoff_other"  data-id="{{$ap->id}}" value="1"  /> Other<span></label>
                    </div>
					 <div class="form-group col-md-6 ">
               
                 <input type="text" id="actual_pickup_time{{$ap->id}}" value="{{$ap->actual_pickup_time}}" class="form-control inputsave"  placeholder="Pickup Time*" required data-id="{{$ap->id}}" data-name="actual_pickup_time" />
				 
              </div>
                    <div class="form-group col-md-6">
					
					<input type="text" class="form-control inputsave" id="remark{{$ap->id}}" data-name="remark"  data-id="{{$ap->id}}" value="{{$ap->remark}}" required placeholder="Remark" />
                    </div>
					@elseif($activity->entry_type=='Departure')
		  
                    <div class="form-group col-md-6">
					
					
					<input type="text" class="form-control inputsave autocom" id="pickup_location{{$ap->id}}"  data-name="pickup_location"  data-id="{{$ap->id}}" value="{{$ap->pickup_location}}" data-zone="{{$ap->transfer_zone}}" placeholder="Pickup Location*" required />
					 <label for="inputName" style="width: 100%;"><span class="float-left"><input type="checkbox" data-idinput="pickup_location{{$ap->id}}" class="chk_other " data-name="pickup_other"  data-id="{{$ap->id}}" value="1"  /> Other<span></label>
                     
                    </div>
					
					 <div class="form-group col-md-6 ">
                
                 <input type="text" id="actual_pickup_time{{$ap->id}}" value="{{$ap->actual_pickup_time}}" class="form-control inputsave"  placeholder="Pickup Time*" required data-id="{{$ap->id}}" data-name="actual_pickup_time" />
				 
              </div>
			  <div class="form-group col-md-6 ">
               
                 <input type="text" id="flight_no{{$ap->id}}" value="{{$ap->flight_no}}" class="form-control inputsave"  placeholder="Departure Flight Details*" required data-id="{{$ap->id}}" data-name="flight_no" />
				
              </div>
                    <div class="form-group col-md-6">
					
					<input type="text" class="form-control inputsave" id="remark{{$ap->id}}" data-name="remark"  data-id="{{$ap->id}}" value="{{$ap->remark}}"  placeholder="Remark" />
                    </div>
					@else
						<div class="form-group col-md-6">
					
					 
						
					<input type="text" class="form-control inputsave autocom" id="pickup_location{{$ap->id}}"  data-name="pickup_location"  data-id="{{$ap->id}}" value="{{$ap->pickup_location}}" data-zone="{{$ap->transfer_zone}}" required placeholder="Pickup Location*" required />
					 <label for="inputName" style="width: 100%;"><span class="float-left"><input type="checkbox" data-idinput="pickup_location{{$ap->id}}" class="chk_other " data-name="pickup_other"  data-id="{{$ap->id}}" value="1"   /> Other<span></label>
					  </div>
					
                     @if(($activity->pvt_TFRS=='1') && ($activity->pick_up_required=='1'))
					<div class="form-group col-md-6 ">
                <label for="inputName"></label>
                 <input type="text" id="actual_pickup_time{{$ap->id}}" value="{{$ap->actual_pickup_time}}" class="form-control inputsave" required placeholder="Pickup Time*" data-id="{{$ap->id}}" data-name="actual_pickup_time" />
				 
              </div>
                    @endif
					<div class="form-group col-md-6">
					
					<input type="text" class="form-control inputsave" id="remark{{$ap->id}}" data-name="remark"  data-id="{{$ap->id}}" value="{{$ap->remark}}"  placeholder="Remark" />
                    </div>
					
					@endif
                  </div>
				   @endif
				  @endforeach
                 @endif
				  
                </div>
				@endif
                <!-- /.card-body -->

               
            </div>
			
            <!-- /.card -->

            <div class="card card-default">
              <div class="card-header">
               <h3 class="card-title"><i class="nav-icon fas fa-credit-card" style="color:black"></i>  Payment Options</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
                <div class="card-body">
                  <div class="row" style="margin-bottom: 5px;">
                    <div class="col-12">
                      <input type="radio" checked name="payment"  /> Credit Limit (Wallet Balance AED {{($voucher->agent->agent_amount_balance)?$voucher->agent->agent_amount_balance:0}})
                    </div>
                   
                  </div>
                  <div class="row" style="margin-bottom: 15px;">
                    <div class="col-12">
                      <input type="radio" disabled name="payment"  /> Credit Card / Debit Card
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

               
            </div>
            <!-- /.card -->
 <!-- general form elements -->
 <div class="card card-default">
  
   

    <div class="card-footer">
      <div class="row" style="margin-bottom: 5px;">
        <div class="col-md-8 text-left">
          <input type="checkbox" name="tearmcsk" required id="tearmcsk" /> By clicking Pay Now you agree that you have read ad understood our Terms and Conditions
		  <br><label id="tearmcsk_message" for="tearmcsk" class="error hide" >This field is required.</label>
        </div>
        <div class="col-4 text-right">
			 @if($voucher->status_main < 4)
            <button type="submit" name="btn_hold" class="btn btn-primary">Hold</button>
            @endif
            @if($voucher->status_main < 5 )
            <button type="submit" name="btn_paynow" class="btn btn-success">Pay Now</button>
            @endif
        </div>
      </div>
    </div>

</div>
<!-- /.card -->

            <!-- Horizontal Form -->
            
            <!-- /.card -->
</form>
          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-4" >
            <!-- Form Element sizes -->
			@php
				$totalGrand =0; 
			  @endphp
			  @if(!empty($voucherActivity) && $voucher->is_activity == 1)
					@if(!empty($voucherActivity))
					  @foreach($voucherActivity as $ap)
				  @php
					$activity = SiteHelpers::getActivity($ap->activity_id);
					@endphp
            <div class="card card-default">
              <div class="card-header">
                <div class="row">
				<div class="col-md-8 text-left">
                    <h3 class="card-title">
                      <strong> {{$activity->title}}</strong></h3>
                  </div>
				<div class="col-md-4 text-right">
                    <form id="delete-form-{{$ap->id}}" method="post" action="{{route('agent.voucher.activity.delete',$ap->id)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <a class="btn-danger btn-sm" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$ap->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            "><i class="fas fa-trash"></i></a>
                    
                  </div>
				   </div>
              </div>
              <div class="card-body">
			  
			  <div class="">
                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-5 text-left">
                      <strong>Tour Option</strong>
                    </div>
                    <div class="col-md-7 text-right">
                      {{$ap->variant_name}}
                    </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Date</strong>
                  </div>
                  <div class="col-md-7 text-right">
				  {{ $ap->tour_date ? date(config('app.date_format'),strtotime($ap->tour_date)) : null }}
                  
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Transfer Type</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$ap->transfer_option}}
                  </div>
                </div>
               @if($ap->transfer_option == 'Shared Transfer')
					@php
					$pickup_time = SiteHelpers::getPickupTimeByZone($activity->zones,$ap->transfer_zone);
					@endphp
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Pickup Timing</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$pickup_time}}
                  </div>
                </div>
				@endif
				@if(($ap->transfer_option == 'Pvt Transfer') && ($activity->pick_up_required == '1')  && ($activity->pvt_TFRS == '1'))
					@php
					$pickup_time = SiteHelpers::getPickupTimeByZone($activity->zones,$ap->transfer_zone);
					@endphp
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Pickup Timing</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$activity->pvt_TFRS_text}}
                  </div>
                </div>
				@endif
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Pax</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$ap->adult}} Adult {{$ap->child}} Child
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Amount Incl. VAT</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   AED {{$ap->totalprice}}
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Total</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   AED {{$ap->totalprice}}
                  </div>
                </div>
				</div>
				
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
@php
					$totalGrand += $ap->totalprice; 
				  @endphp
				 @endforeach
                 @endif
				  @endif
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title"><strong>Total Payment</strong></h3>
              </div>
              <div class="card-body">
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-6 text-left">
                    <strong>Amount Incl. VAT</strong>
                  </div>
                  <div class="col-md-6 text-right">
                   AED {{$totalGrand}}
                  </div>
                </div>
               <!-- <div class="row" style="margin-bottom: 15px;">
                  <div class="col-md-6 text-left">
                    <strong>Handling charges (2%)</strong>
                  </div>
                  <div class="col-md-6 text-right">
                   AED 2.30
                  </div>
                </div> -->
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-6 text-left">
                    <h5>Final Amount</h5>
                  </div>
                  <div class="col-md-6 text-right">
                   <h5>AED {{$totalGrand}}</h5>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  
    <!-- /.content -->
@endsection



@section('scripts')
<script  src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js
"></script>




<script type="text/javascript">
  $(function(){
	   $('.chk_other').each(function() {
        var inputid = $(this).data('idinput');
        var isChecked = $(this).is(':checked');

        // Handle checkbox change
        $(this).on('change', function() {
            if ($(this).is(':checked')) {
                $("#" + inputid).autocomplete("option", "disabled", true);
            } else {
                $("#" + inputid).autocomplete("option", "disabled", false);
            }
        });
    });
	
$('#cusDetails').validate({});

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

 var path = "{{ route('auto.hotel') }}";
	 var inputElement = $(this); // Store reference to the input element
	 
 $(".autocom").each(function() {
    var inputElement = $(this);
    inputElement.autocomplete({
        source: function(request, response) {
            $.ajax({
                url: path,
                type: 'GET',
                dataType: "json",
                data: {
                    search: request.term,
                    zone: inputElement.attr('data-zone')
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {
			
            $(this).val(ui.item.label);
            return false;
        },
        change: function(event, ui) {
            if (ui.item == null) {
                $(this).val('');
            }
        }
    });
});

$(".autodropoff_location").each(function() {
    var inputElement = $(this);
    inputElement.autocomplete({
        source: function(request, response) {
            $.ajax({
                url: path,
                type: 'GET',
                dataType: "json",
                data: {
                    search: request.term,
                    zone: inputElement.attr('data-zone')
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {
            $(this).val(ui.item.label);
            return false;
        },
        change: function(event, ui) {
            if (ui.item == null) {
               $(this).val('');
            }
        }
    });
});
	});
	

</script>
@endsection