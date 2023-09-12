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
	
</style>
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Dashboard</h1>
      </div>
      <!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
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
      
		
		<div class="col-lg-3 col-6">
        <!-- small box -->
			<div class="small-box bg-warning">
				<div class="inner">
				<h3>{{$totalAgentRecords}}</h3>

				<p>Agents</p>
				</div>
				
				<a href="{{ route('agents.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
			</div>
        </div>
		<div class="col-lg-3 col-6">
        <!-- small box -->
			<div class="small-box bg-success">
				<div class="inner">
				<h3>{{$totalSupplierRecords}}</h3>

				<p>Suppliers</p>
				</div>
				
				<a href="{{ route('suppliers.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
			</div>
        </div>
		
		<div class="col-lg-3 col-6">
        <!-- small box -->
			<div class="small-box bg-success">
				<div class="inner">
				<h3>{{$totalActivityRecords}}</h3>

				<p>Activities</p>
				</div>
				
				<a href="{{ route('activities.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
			</div>
        </div>
		<div class="col-lg-3 col-6">
        <!-- small box -->
			<div class="small-box bg-warning">
				<div class="inner">
				<h3>{{$totalHotelRecords}}</h3>

				<p>Hotels</p>
				</div>
				
				<a href="{{ route('hotels.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
			</div>
        </div>
		<div class="col-lg-12 col-6">
		<div class="card">
		<div class="card-body">
		<table id="example1" class="table table-bordered">
                  <thead>
                  <tr>
					<th>Code</th>
                    <th>Agency</th>
                    <th>Status</th>
                    <th>Travel Date</th>
                    <th>Created On</th>
					<th>Created By</th>
                    <th width="4%"></th>
                  </tr>
				  
                  </thead>
                  <tbody>
				 
                  @foreach ($vouchers as $record)
				  
                  <tr>
				  <td>{{ ($record->code)}}</td>
                    <td>{{ ($record->agent)?$record->agent->company_name:''}}</td>
                     <td>{!! SiteHelpers::voucherStatus($record->status_main) !!}</td>
					   <td>{{ $record->travel_from_date ? date("M d Y, H:i:s",strtotime($record->travel_from_date)) : null }} <b>To</b> {{ $record->travel_to_date ? date(config('app.date_format'),strtotime($record->travel_to_date)) : null }}</td>
                    <td>{{ $record->created_at ? date("M d Y, H:i:s",strtotime($record->created_at)) : null }}</td>
					<td>{{ ($record->createdBy)?$record->createdBy->name:''}}</td>
                  
					
						 
                     <td>
					 
					 <a class="btn btn-info btn-sm" href="{{route('voucherView',$record->id)}}">
                              <i class="fas fa-eye">
                              </i>
                              
                          </a>
					
                            
                         </td>
                  </tr>
				 
                  @endforeach
                  </tbody>
                 
                </table>
				
				<div class="pagination pull-right mt-3"> {!! $vouchers->links() !!} </div> 
		</div> </div></div>
      
    </div>
    <!-- /.row --> 
  </div>
  <!-- /.container-fluid --> 
</section>
<!-- /.content --> 

@endsection

@section('scripts') 
<script>
	$(function() {
		var colors = [
			'#249efa',
		]
		var options = {
			series: [{
				data: [21, 22, 10, 28, 16, 21, 13, 30, 16, 21, 13, 30]
			}],
			tooltip: {
				custom: function({
					series,
					seriesIndex,
					dataPointIndex,
					w
				}) {
					return '<div class="arrow_box">' +
						'<span>' + series[seriesIndex][dataPointIndex] + '</span>' +
						'</div>'
				}
			},
			chart: {
				height: 350,
				type: 'bar',
				events: {
					click: function(chart, w, e) {
						// console.log(chart, w, e)
					}
				}
			},
			colors: colors,
			plotOptions: {
				bar: {
					columnWidth: '30%',
					distributed: false,
				}
			},
			dataLabels: {
				enabled: false
			},
			legend: {
				show: false
			},
			xaxis: {
				categories: [
					["Jan"],
					["Feb"],
					["Mar"],
					["Apr"],
					["May"],
					["Jun"],
					["Jul"],
					["Aug"],
					["Sep"],
					["Oct"],
					["Nov"],
					["Dec"],
				],
				labels: {
					style: {
						colors: colors,
						fontSize: '12px'
					}
				}
			}
		};

		var chart = new ApexCharts(document.querySelector("#chart"), options);
		chart.render();

		var options = {
			series: [30],
			chart: {
				height: 350,
				type: 'radialBar',
			},
			plotOptions: {
				radialBar: {
					hollow: {
						size: '30%',
					}
				},
			},
			labels: ['Available'],
		};

		var chart = new ApexCharts(document.querySelector("#chart2"), options);
		chart.render();
	});
</script> 
@endsection