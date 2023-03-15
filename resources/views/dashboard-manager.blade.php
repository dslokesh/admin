@extends('layouts.app')
@section('content')
<style>
	.smart-box {background-color: #fff; border-radius: 10px; margin-bottom: 30px; box-shadow: 0px 0px 5px #ddd; padding:15px 20px 10px 20px;}
	.small-box {background-color: #fff; border-radius: 10px; margin-bottom: 30px; box-shadow: 0px 0px 5px #ddd; padding:15px 20px 10px 20px;
		position: relative}
	.small-box > h4 { position: absolute;}
	[class*=sidebar-dark-] {    background-color: #1a1c1e;}
	.arrow_box {background-color: #249efa; padding:5px 15px; border-radius: 5px; color: #fff;}
	
	.sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active, .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {background-color: #2ba0a6;}
	.space {    display: flex;}
	
</style>
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Hello {{auth()->user()->full_name}}</h1>
      </div>
      <!-- /.col -->
      <div class="col-sm-6">
       
      </div>
      <!-- /.col --> 
    </div>
    <!-- /.row --> 
  </div>
  <!-- /.container-fluid --> 
</div>
<!-- /.content-header --> 


<!-- Main content -->
<section class="content">
  <div class="container-fluid"> 
    <!-- Small boxes (Stat box) -->
    <div class="row"> 
      
		<div class="col-lg-4 col-6">
        <!-- small box -->
			<div class="small-box space">
			<input type="text" class="knob" value="{{$userPer}}" data-readonly="true" readonly="readonly" data-thickness="0.1" data-width="90" data-height="90" data-fgcolor="{{SiteHelpers::returnGraphColor($userPer)}}" id="inp1-min" style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; background: none; font: bold 18px Arial; text-align: center; color: rgb(60, 141, 188); padding: 0px; appearance: none;">
				<div class="inner" style="padding-left:20px;">
				<h3> {{$totalActiveUserRecords}}</h3>
				
				<p><a href="{{route('technician',['status'=>1])}}">Total Active Users</a></p>
				</div>
				
			</div>
        </div>
		<div class="col-lg-4 col-6">
        <!-- small box -->
			<div class="small-box space">
			<input type="text" class="knob" value="{{$ppePer}}" data-readonly="true" readonly="readonly" data-thickness="0.1" data-width="90" data-height="90" data-fgcolor="{{SiteHelpers::returnGraphColor($ppePer)}}" id="inp2-min" style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; background: none; font: bold 18px Arial; text-align: center; color: rgb(60, 141, 188); padding: 0px; appearance: none;">
				<div class="inner" style="padding-left:20px;">
				<h3>{{$totalAssignedPpes}}</h3>
				<p><a href="{{route('assignedProduct')}}">Total Assigned Products</a></p>
				</div>
				
			</div>
        </div>
		<div class="col-lg-4 col-6">
        <!-- small box -->
			<div class="small-box space">
			<input type="text" class="knob" value="{{$ppePerUnAssi}}" data-readonly="true" readonly="readonly" data-thickness="0.1" data-width="90" data-height="90" data-fgcolor="{{SiteHelpers::returnGraphColor($ppePerUnAssi)}}" id="inp3-min" style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; background: none; font: bold 18px Arial; text-align: center; color: rgb(60, 141, 188); padding: 0px; appearance: none;">
				<div class="inner" style="padding-left:20px;">
				<h3>{{$totalUnAssignedPpes}}</h3>
				<p><a href="{{route('productAssign')}}">Total Un-assigned Products</a></p>
				</div>
				
			</div>
        </div>
		 <!-- small box -->
		 <div class="col-lg-4 col-6">
			<div class="small-box space">
			<input type="text" class="knob" value="{{$validCPer}}" data-readonly="true" readonly="readonly" data-thickness="0.1" data-width="90" data-height="90" data-fgcolor="{{SiteHelpers::returnGraphColor($validCPer)}}" id="inp4-min" style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; background: none; font: bold 18px Arial; text-align: center; color: rgb(60, 141, 188); padding: 0px; appearance: none;">
				<div class="inner" style="padding-left:20px;">
				<h3>{{$validCertificates}}</h3>
				<p><a href="{{route('allCertificates',['status'=>'valid'])}}">Total valid certificates</a></p>
				</div>
				
			</div>
        </div>
		 <div class="col-lg-4 col-6">
			<div class="small-box space">
			<input type="text" class="knob" value="{{$expiringCPer}}" data-readonly="true" readonly="readonly" data-thickness="0.1" data-width="90" data-height="90" data-fgcolor="{{SiteHelpers::returnGraphColor($expiringCPer)}}" id="inp5-min" style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; background: none; font: bold 18px Arial; text-align: center; color: rgb(60, 141, 188); padding: 0px; appearance: none;">
				<div class="inner" style="padding-left:20px;">
				<h3>{{$expiringCertificates}}</h3>
				<p><a href="{{route('allCertificates',['status'=>'expiring'])}}">Expiring Certificates</a></p>
				</div>
				
			</div>
        </div>
		<div class="col-lg-4 col-6">
			<div class="small-box space">
			<input type="text" class="knob" value="{{$expiredCPer}}" data-readonly="true" readonly="readonly" data-thickness="0.1" data-width="90" data-height="90" data-fgcolor="{{SiteHelpers::returnGraphColor($expiredCPer)}}" id="inp6-min" style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; background: none; font: bold 18px Arial; text-align: center; color: rgb(60, 141, 188); padding: 0px; appearance: none;">
				<div class="inner" style="padding-left:20px;">
				<h3>{{$expiredCertificates}}</h3>
				<p><a href="{{route('allCertificates',['status'=>'expired'])}}">Expired Certificates</a></p>
				</div>
				
			</div>
        </div>
	 <div class="col-lg-6 col-6">
		  <div class="smart-box">
        <div class="inner">
          <h4>Current Projects</h4>
        </div>
        <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
          <div class="row">
            <div class="col-sm-12 col-md-6"></div>
            <div class="col-sm-12 col-md-6"></div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <table id="TeamidData" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Project</th>
						<th>Project Id</th>
						<th>Location</th>
                        <th>Status</th>
						<th>Amount of Workers</th>
						<th>Assets on Site</th>
                      </tr>
					  </thead>
                  <tbody>
                      @if (!empty($projects->count()))
                  @foreach ($projects as $record)
                  <tr>
                    <td><a  href="{{route('teamids.show',$record->id)}}" title="view project">
                             {{ $record->name}}</a></td>
                    <td>{{ $record->team_id}}</td>
					 <td>{{ ($record->area)?$record->area->title:''}}</td>
                    <td>{!! SiteHelpers::statusColor($record->status) !!}</td>
					<td>{{ $record->workers_count}}</td>
					<td>{{ SiteHelpers::assetsOnSiteByProjectCount($record->id)}}</td>
					
                  </tr>
                  @endforeach
                  @else
                    <td colspan="10"><center><b>No Record Found</b></center></td>
                    @endif
                  </tbody>
                  <tfoot>
                
                  </tfoot>
                </table>
            </div>
          </div>
        </div>
		</div>
      </div>
		
		<div class="col-lg-6 col-6">
		  <div class="smart-box">
        <div class="inner">
          <h4>Expiring Products</h4>
        </div>
        <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
          <div class="row">
            <div class="col-sm-12 col-md-6"></div>
            <div class="col-sm-12 col-md-6"></div>
          </div>
          <div class="row">
            <div class="col-sm-12">
             <table id="TeamidData" class="table table-bordered table-striped">
                      <thead>
                      <tr>
						<th>Product Name</th>
						<th>Serial Number</th>
						<th>User</th>
						<th>Warranty Expiry Date</th>
                      </tr>
					  </thead>
                  <tbody>
                     @if (count($productsAll))
                  @foreach ($productsAll as $userProduct)
                  @foreach ($userProduct->products as $product)
                  <tr>
					<td>{{ $product->name}}</td>
					<td>{{ $product->serial_number}}</td>
					<td>{{ $userProduct->user->full_name}}</td>
					<td>{!! SiteHelpers::productExp($product->expiry_date) !!}</td>
                    <td> <a class="btn btn-info btn-sm" href="{{route('products.show',$product->id)}}">
                              <i class="fas fa-eye">
                              </i>
                              
                          </a></td>
                  </tr>
                  @endforeach
				  @endforeach
                  @else
                    <td colspan="10"><center><b>No Record Found</b></center></td>
                    @endif
                  </tbody>
                  <tfoot>
                
                  </tfoot>
                </table>
            </div>
          </div>
        </div>
		</div>
      </div>
	  
		<div class="col-lg-6 col-6">
		  <div class="smart-box">
        <div class="inner">
          <h4>Expiring Certificates</h4>
        </div>
        <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
          <div class="row">
            <div class="col-sm-12 col-md-6"></div>
            <div class="col-sm-12 col-md-6"></div>
          </div>
          <div class="row">
            <div class="col-sm-12">
             <table id="TeamidData" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th width="8%">Profile Picture</th>
						<th>Name</th>
						<th>Certificates</th>
						<th></th>
                      </tr>
					  </thead>
                  <tbody>
                      @if (!empty(count($certificates)))
                  @foreach ($certificates as $certificate)
                  <tr>
                    <td>@if(!empty($certificate->user->image))<img src="{{asset('uploads/users/thumb/'.$certificate->user->image)}}" class="profile-image-td" />@endif</td>
					<td>{{ ($certificate->user)?$certificate->user->name:''}} {{ ($certificate->user)?$certificate->user->lname:''}}</td>
					<td>{!! SiteHelpers::certificatStatus($certificate->expiry_date) !!}</td>
                    <td> <a class="btn btn-info btn-sm" href="{{route('users.show',$certificate->user->id)}}">
                              <i class="fas fa-eye">
                              </i>
                              
                          </a></td>
                  </tr>
                  @endforeach
                  @else
                    <td colspan="10"><center><b>No Record Found</b></center></td>
                    @endif
                  </tbody>
                  <tfoot>
                
                  </tfoot>
                </table>
            </div>
          </div>
        </div>
		</div>
      </div>
    
      <!-- ./col -->
      
    </div>
    <!-- /.row --> 
  </div>
  <!-- /.container-fluid --> 
</section>
<!-- /.content --> 

@endsection

@section('scripts') 
<script>
  $(function () {
    /* jQueryKnob */

    $('.knob').knob({
      /*change : function (value) {
       //console.log("change : " + value);
       },
       release : function (value) {
       console.log("release : " + value);
       },
       cancel : function () {
       console.log("cancel : " + this.value);
       },*/
      draw: function () {

        // "tron" case
        if (this.$.data('skin') == 'tron') {

          var a   = this.angle(this.cv)  // Angle
            ,
              sa  = this.startAngle          // Previous start angle
            ,
              sat = this.startAngle         // Start angle
            ,
              ea                            // Previous end angle
            ,
              eat = sat + a                 // End angle
            ,
              r   = true

          this.g.lineWidth = this.lineWidth

          this.o.cursor
          && (sat = eat - 0.3)
          && (eat = eat + 0.3)

          if (this.o.displayPrevious) {
            ea = this.startAngle + this.angle(this.value)
            this.o.cursor
            && (sa = ea - 0.3)
            && (ea = ea + 0.3)
            this.g.beginPath()
            this.g.strokeStyle = this.previousColor
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false)
            this.g.stroke()
          }

          this.g.beginPath()
          this.g.strokeStyle = r ? this.o.fgColor : this.fgColor
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false)
          this.g.stroke()

          this.g.lineWidth = 2
          this.g.beginPath()
          this.g.strokeStyle = this.o.fgColor
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false)
          this.g.stroke()

          return false
        }
      }
    })
    /* END JQUERY KNOB */

	$('#inp1-min').trigger('configure', {
	  'format': function (v) {
		  return v + '%';
	  }
	});
	$('#inp1-min').trigger('change');
	
	$('#inp2-min').trigger('configure', {
	  'format': function (v) {
		  return v + '%';
	  }
	});
	$('#inp2-min').trigger('change');
	
	$('#inp3-min').trigger('configure', {
	  'format': function (v) {
		  return v + '%';
	  }
	});
	$('#inp3-min').trigger('change');
	
	$('#inp4-min').trigger('configure', {
	  'format': function (v) {
		  return v + '%';
	  }
	});
	$('#inp4-min').trigger('change');
	
	$('#inp5-min').trigger('configure', {
	  'format': function (v) {
		  return v + '%';
	  }
	});
	$('#inp5-min').trigger('change');
	
	$('#inp6-min').trigger('configure', {
	  'format': function (v) {
		  return v + '%';
	  }
	});
	$('#inp6-min').trigger('change');

  })

</script>
@endsection