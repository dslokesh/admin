@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Booking Confirmation( {{$voucher->code}})</h1>
          </div>
		 
						  <div class="col-sm-3 text-right">
						  </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

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
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div class="row">
       
		
       <!-- left column -->
       <div class="offset-md-2 col-md-8">
              <div class="row multistep">
                <div class="col-md-3 multistep-step complete">
                    <div class="text-center multistep-stepname" style="font-size: 16px;">Add to Cart</div>
                    <div class="progress"><div class="progress-bar"></div></div>
                    <a href="#" class="multistep-dot"></a>
                </div>

                <div class="col-md-3 multistep-step complete">
                    <div class="text-center multistep-stepname" style="font-size: 16px;">Payment</div>
                    <div class="progress"><div class="progress-bar"></div></div>
                    <a href="#" class="multistep-dot"></a>
                </div>

                <div class="col-md-3 multistep-step current">
                    <div class="text-center multistep-stepname" style="font-size: 16px;">Confimation</div>
                    <div class="progress"><div class="progress-bar"></div></div>
                    <a href="#" class="multistep-dot"></a>
                </div>

                
            </div>
</div>
</div>

        <div class="row" style="margin-top: 30px;">
       
		
          <!-- left column -->
          <div class="offset-md-2 col-md-8">
		   <form id="cusDetails" method="post" action="{{route('agent.vouchers.status.change',$voucher->id)}}" >
			 {{ csrf_field() }}
            <!-- general form elements -->
            <div class="card card-default">
              <div class="card-header">
                 <h3 class="card-title"><i class="nav-icon fas fa-user" style="color:black"></i> Passenger Details</h3>
				 <h3 class="card-title" style="float:right">
          <a class="btn btn-info btn-sm" href="{{route('voucherInvoicePdf',$voucher->id)}}" >
                              Download Invoice <i class="fas fa-download">
                              </i>
                             
                          </a>
						  </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
                <div class="card-body">
                  <div class="row" style="margin-bottom: 15px;">
                    
                    <div class="col-6">
					<label for="inputName">Guest Name:</label>
                     {{$voucher->guest_name}}
                    </div>
                   
                
                    <div class="col-6">
					<label for="inputName">Email:</label>
                     {{$voucher->agent->email}}
                    </div>
                   
                    <div class="col-6">
					  <label for="inputName">Mobile No.:</label>
                     {{$voucher->agent->mobile}}
                    </div>
                    <div class="col-6">
                      
					   <label for="inputName">Agent Reference No.:</label>
                     {{$voucher->agent_ref_no}}
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: 5px;">
                    <div class="col-12">
					 <label for="inputName">Remark.:</label>
                     {{$voucher->remark}}
                     
                    </div>
                   
                  </div>
                </div>
                <!-- /.card-body -->
				
               
            </div>
            <!-- /.card -->
            @if(!empty($voucherActivity) && $voucher->is_activity == 1)
            @php
                    $ii = 0;
                    @endphp
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
                    <div class="col-12"><p><strong>{{$c}}. {{$ap->variant_name}} : {{$ap->transfer_option}}</strong></p></div>
					@if($activity->entry_type=='Arrival')
                    <div class="col-6">
					<label for="inputName">Dropoff Location:</label>
					{{$ap->dropoff_location}}
                     
                    </div>
                    <div class="col-6">
					<label for="inputName">Remark:</label>
					{{$ap->remark}}
                    </div>
					<div class="row">
					
					  <div class="col-12 pt-3 pb-1"><h3 class="card-title"><i class="nav-icon fas fa-plane" style="color:black"></i> Arrival Airline Details</h3></div>
					<div class="form-group col-md-4 ">
                <label for="inputName">Arrival Airline:</label>
				{{$ap->airlines_name}}
				
              </div>
			  <div class="form-group col-md-4 ">
                <label for="inputName">Arrival Date:</label>
				{{$ap->arrival_depature_date}}
                 
				 
              </div>
			   <div class="form-group col-md-4 ">
                <label for="inputName">Arrival Time:</label>
                {{$ap->arrival_depature_time}}
				 
              </div>
			   <div class="form-group col-md-4 ">
                <label for="inputName">Arrival Airport:</label>
				{{$ap->airport}}
                 
              </div>
			   <div class="form-group col-md-4 ">
                <label for="inputName">Arrival Terminal:</label>
				{{$ap->airport_terminal}}
				
                
				
              </div>
			  <div class="form-group col-md-4 ">
                <label for="inputName">Arrival Flight No:</label>
				{{$ap->flight_no}}
                
              </div>
                    </div>
					
					@elseif($activity->entry_type=='Interhotel')
					<div class="col-6">
					<label for="inputName">Pickup Location:</label>
					{{$ap->pickup_location}}
                     
                    </div>
					 <div class="col-6">
					<label for="inputName">Dropoff Location:</label>
					{{$ap->dropoff_location}}
                     
                    </div>
                    <div class="col-12 pt-3">
					<label for="inputName">Remark:</label>
					{{$ap->remark}}
                    </div>
					@else
					<div class="col-6">
					<label for="inputName">Pickup Location:</label>
					{{$ap->pickup_location}}
                     
                    </div>
                    <div class="col-6">
					<label for="inputName">Remark:</label>
					{{$ap->remark}}
                    </div>
					
					 @if($activity->entry_type=='Departure')
					<div class="row">
					
					  <div class="col-12 pt-3 pb-1"><h3 class="card-title"><i class="nav-icon fas fa-plane" style="color:black"></i> Depature Airline Details</h3></div>
					<div class="form-group col-md-4 ">
                <label for="inputName">Depature Airline:</label>
				{{$ap->airlines_name}}
				
              </div>
			  <div class="form-group col-md-4 ">
                <label for="inputName">Depature Date:</label>
				{{$ap->arrival_depature_date}}
                 
				 
              </div>
			   <div class="form-group col-md-4 ">
                <label for="inputName">Depature Time:</label>
                {{$ap->arrival_depature_time}}
				 
              </div>
			   <div class="form-group col-md-4 ">
                <label for="inputName">Depature Airport:</label>
				{{$ap->airport}}
                 
              </div>
			   <div class="form-group col-md-4 ">
                <label for="inputName">Depature Terminal:</label>
				{{$ap->airport_terminal}}
				
                
				
              </div>
			  <div class="form-group col-md-4 ">
                <label for="inputName">Depature Flight No:</label>
				{{$ap->flight_no}}
                
              </div>
                    </div>
					@endif
					
					@endif
					
                  </div>
				   @endif
				  @endforeach
                 @endif
				 
                </div>
                <!-- /.card-body -->

               
            </div>
            @endif

            @if(!empty($voucherHotel) && $voucher->is_hotel == 1)
        
              <div class="card card-default ">
                <div class="card-header">
                  <h3 class="card-title"><i class="nav-icon fas fa-book" style="color:black"></i> Additional Information Hotel</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
              
                  <div class="card-body">
            @if(!empty($voucherHotel))
              @foreach($voucherHotel as $vah)
           
                    <div class="row" style="margin-bottom: 15px;">
                      <div class="col-12"><p>{{$vah->hotel->name}} - {{$vah->hotel->hotelcategory->name}}</p></div>
                      <div class="col-12">
                        <label for="inputName">Confirmation Number:</label>
					{{$vah->confirmation_number}}

                       
                      </div>
                     
                    </div>
            
            @endforeach
                   @endif
            
                  </div>
         
                  <!-- /.card-body -->
  
                 
              </div>
              @endif

            <!-- /.card -->

           
            <!-- /.card -->
 <!-- general form elements -->
 
<!-- /.card -->

            <!-- Horizontal Form -->
            
            <!-- /.card -->
</form>
          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="offset-md-2 col-md-8">
            <!-- Form Element sizes -->
			@php
				$totalGrand =0; 
			  @endphp
			  @if(!empty($voucherActivity) && $voucher->is_activity == 1)
					@if(!empty($voucherActivity))
					  @foreach($voucherActivity as $ap)
				  @php
					$activity = SiteHelpers::getActivity($ap->activity_id);
					$ticketCount = SiteHelpers::getTicketCountByCode($ap->variant_unique_code);
					@endphp
            <div class="card card-default">
              <div class="card-header">
                <div class="row">
				<div class="col-md-8 text-left">
                    <h3 class="card-title">
                      <strong> {{$activity->title}}</strong></h3>
                  </div>
				<div class="col-md-4 text-right pl-5">
				
                    @if(($voucher->status_main == 5) and ($ap->ticket_generated == '0') and ($ticketCount > '0'))
						<form id="tickets-generate-form-{{$ap->id}}" method="post" action="{{route('tickets.generate',$ap->id)}}" style="display:none;">
                                {{csrf_field()}}
								<input type="hidden" id="statusv" value="2" name="statusv"  /> 
								<input type="hidden" id="payment_date" name="payment_date"  /> 
                            </form>
						
							<a class="btn btn-success float-right mr-3 btn-sm" href="javascript:void(0)" onclick="
                                if(confirm('You want to download ticket?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('tickets-generate-form-{{$ap->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            "><i class="fas fa-download"></i> Ticket</a>
							
							@elseif($ap->ticket_generated == '1')
							<a class="btn btn-success float-right  btn-sm" href="{{route('ticket.dwnload',$ap->id)}}" ><i class="fas fa-download"></i> Ticket</a>
							@endif
							
                    
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
                   {{$ap->tour_date}}
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
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Pickup Timing</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$ap->actual_pickup_time}}
                  </div>
                </div>
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
            <!-- /.startteldiv-->
            @if(!empty($voucherHotel) && $voucher->is_hotel == 1)
            @if(!empty($voucherHotel))
              @foreach($voucherHotel as $vh)
              @php
              $room = SiteHelpers::hotelRoomsDetails($vh->hotel_other_details)
              @endphp
              <div class="card card-default">
                <div class="card-header">
                  <div class="row">
          <div class="col-md-8 text-left">
                      <h3 class="card-title">
                        <strong> {{$vh->hotel->name}}</strong></h3>
                    </div>
          
             </div>
                </div>
                <div class="card-body">
          
          <div class="">
            <div class="row" style="margin-bottom: 5px;">
              <div class="col-md-5 text-left">
                <strong>Hotel Category</strong>
              </div>
              <div class="col-md-7 text-right">
                {{$vh->hotel->hotelcategory->name}}
              </div>
          </div>
                  <div class="row" style="margin-bottom: 5px;">
                      <div class="col-md-5 text-left">
                        <strong>Check In</strong>
                      </div>
                      <div class="col-md-7 text-right">
                        {{$vh->check_in_date}}
                      </div>
                  </div>
                  <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-5 text-left">
                      <strong>Check Out</strong>
                    </div>
                    <div class="col-md-7 text-right">
                     {{$vh->check_out_date}}
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-5 text-left">
                      <strong>Room Type</strong>
                    </div>
                    <div class="col-md-7 text-right">
                      {{$room['room_type']}}
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-5 text-left">
                      <strong>Number of Rooms</strong>
                    </div>
                    <div class="col-md-7 text-right">
                      {{$room['number_of_rooms']}}
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-5 text-left">
                      <strong>Occupancy</strong>
                    </div>
                    <div class="col-md-7 text-right">
                      {{$room['occupancy']}}
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-5 text-left">
                      <strong>Meal Plan</strong>
                    </div>
                    <div class="col-md-7 text-right">
                      {{$room['mealplan']}}
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-5 text-left">
                      <strong>Amount Incl. VAT</strong>
                    </div>
                    <div class="col-md-7 text-right">
                     AED {{$room['price']}}
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-5 text-left">
                      <strong>Total</strong>
                    </div>
                    <div class="col-md-7 text-right">
                     AED {{$room['price']}}
                    </div>
                  </div>
          </div>
          
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
  @php
            $totalGrand += $room['price']; 
            @endphp
           @endforeach
                   @endif
            @endif
             <!-- /.endhoteldiv-->
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
                    <h3>Final Amount</h3>
                  </div>
                  <div class="col-md-6 text-right">
                   <h3>AED {{$totalGrand}}</h3>
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

<script type="text/javascript">
 
</script>
@endsection