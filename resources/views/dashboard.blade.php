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
			<div class="small-box bg-success">
				<div class="inner">
				<h3>72</h3>

				<p>Amounts of PPE assets</p>
				</div>
				
				<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
			</div>
        </div>
		<div class="col-lg-3 col-6">
        <!-- small box -->
			<div class="small-box bg-warning">
				<div class="inner">
				<h3>32</h3>

				<p>Amounts of Expiring PPE</p>
				</div>
				
				<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
			</div>
        </div>
		<div class="col-lg-3 col-6">
        <!-- small box -->
			<div class="small-box bg-danger">
				<div class="inner">
				<h3>20</h3>

				<p>Amounts of Expired PPE</p>
				</div>
				
				<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
			</div>
        </div>
		<div class="col-lg-3 col-6">
        <!-- small box -->
			<div class="small-box bg-success">
				<div class="inner">
				<h3>50</h3>

				<p>Order Awaiting Assignment</p>
				</div>
				
				<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
			</div>
        </div>
		<div class="col-lg-3 col-6">
        <!-- small box -->
			<div class="small-box bg-success">
				<div class="inner">
				<h3>100</h3>

				<p>Amounts of Technicians</p>
				</div>
				
				<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
			</div>
        </div>
		<div class="col-lg-3 col-6">
        <!-- small box -->
			<div class="small-box bg-warning">
				<div class="inner">
				<h3>23</h3>

				<p>Amounts of Expiring Certificate</p>
				</div>
				
				<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
			</div>
        </div>
		<div class="col-lg-3 col-6">
        <!-- small box -->
			<div class="small-box bg-danger">
				<div class="inner">
				<h3>10</h3>

				<p>Amounts of Expired Certificate</p>
				</div>
				
				<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
			</div>
        </div>
		<div class="col-lg-3 col-6">
        <!-- small box -->
			<div class="small-box bg-info">
				<div class="inner">
				<h3>$35000</h3>

				<p>Remaining PO Value</p>
				</div>
				
				<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
			</div>
        </div>
      <!-- ./col -->
      <div class="col-lg-8 col-6"> 
        <!-- small box -->
        <div class="small-box">       
            <h4>Expiring Product Assets</h4>
     
          <div class="pt-3" id="chart"> </div>
        </div>
      </div>
      <div class="col-lg-4 col-6"> 
        <!-- small box -->
        <div class="small-box">         
            <h4>Remaining PO Value</h4>       
          <div class="pt-3" id="chart2"> </div>
        </div>
      </div>
      <!-- ./col --> 
      
      <!-- ./col -->
      
      <div class="col-lg-12 col-6">
		  <div class="smart-box">
        <div class="inner">
          <h4>Amount of PPE Assets</h4>
        </div>
        <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
          <div class="row">
            <div class="col-sm-12 col-md-6"></div>
            <div class="col-sm-12 col-md-6"></div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <table class="table  table-hover dataTable dtr-inline" aria-describedby="example2_info">
                <thead class="thead-light">
                  <tr>
                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Id</th>
					 <th class="sorting sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Product</th>
                    
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Product Type</th>
					 <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Serial Number</th>
					  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Assigned User</th>
					   <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Assigned To Team ID</th>
					   <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Service Date</th>
					   
					   <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Warranty Status</th>
					   <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Project</th>
					   <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="odd">
                    <td>0001</td>
                    <td>sMRT AU10</td>
                    <td>PLB</td>
					<td>E481403</td>
                    <td>#01</td>
                    <td>#100</td>
					<td>19/05/22</td>
                    <td><span style="color:green; font-weight:bold">Valid</span></td>
                    <td>Hornsea One</td>
					<td>UK</td>
                  </tr>
				  
				   <tr class="odd">
                    <td>0002</td>
                    <td>sMRT AU12</td>
                    <td>PLB</td>
					<td>E481406</td>
                    <td>#01</td>
                    <td>#101</td>
					<td>19/05/22</td>
                    <td><span style="color:#ffc107; font-weight:bold">Expiring</span></td>
                    <td>Hornsea One</td>
					<td>UK</td>
                  </tr>
				   <tr class="even">
                    <td>0003</td>
                    <td>sMRT AU11</td>
                    <td>PLB</td>
					<td>E481402</td>
                    <td>#02</td>
                    <td>#100</td>
					<td>19/05/22</td>
                    <td><span style="color:red ;font-weight:bold">Expired</span></td>
                    <td>Hornsea One</td>
					<td>UK</td>
                  </tr>
				   <tr class="odd">
                    <td>0004</td>
                    <td>sMRT AU10</td>
                    <td>PLB</td>
					<td>E481404</td>
                    <td>#04</td>
                    <td>#103</td>
					<td>19/05/22</td>
                    <td><span style="color:green; font-weight:bold">Valid</span></td>
                    <td>Hornsea One</td>
					<td>UK</td>
                  </tr>
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
		</div>
      </div>
      <div class="col-lg-6 col-6">
		  	  <div class="smart-box">
        <div class="inner">
          <h4>All Locations/Sites/Wind Farms</h4>
        </div>
        <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
          <div class="row">
            <div class="col-sm-12 col-md-6"></div>
            <div class="col-sm-12 col-md-6"></div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <table  class="table table-hover dataTable dtr-inline" aria-describedby="example2_info">
                <thead class="thead-light">
                  <tr>
                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Location</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Member</th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">On Site</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="odd">
                    <td>Jaipur</td>
                    <td>Deepak</td>
                    <td>2</td>
                  </tr>
                  <tr class="even">
                    <td>Jaipur</td>
                    <td>Deepak</td>
                    <td>6</td>
                  </tr>
                  <tr class="odd">
                    <td>Jaipur</td>
                    <td>Deepak</td>
                    <td>5</td>
                  </tr>
                  <tr class="even">
                    <td>Jaipur</td>
                    <td>Deepak</td>
                    <td>5</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
		</div>
      <div class="col-lg-6 col-6">
		<div class="smart-box">
        <div class="inner">
          <h4>Technician Inventory</h4>
        </div>        
          <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <div class="row">
              <div class="col-sm-12 col-md-6"></div>
              <div class="col-sm-12 col-md-6"></div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <table  class="table table-hover dataTable dtr-inline" aria-describedby="example2_info">
                  <thead class="thead-light">
                    <tr>
                      <th class="sorting sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Name</th>
                      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Inventory</th>
                      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Location</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="odd">
                      <td>Deepak</td>
                      <td>2</td>
                      <td>Jaipur</td>
                    </tr>
                    <tr class="even">
                      <td>Deepak</td>
                      <td>2</td>
                      <td>Jaipur</td>
                    </tr>
                    <tr class="odd">
                      <td>Deepak</td>
                      <td>2</td>
                      <td>Jaipur</td>
                    </tr>
                    <tr class="even">
                      <td>Deepak</td>
                      <td>2</td>
                      <td>Jaipur</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        
      </div>
		</div>
      <div class="col-lg-12 col-6">
		  	  <div class="smart-box">
        <div class="inner">
          <h4>New Orders And Stats</h4>
        </div>
        
          <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <div class="row">
              <div class="col-sm-12 col-md-6"></div>
              <div class="col-sm-12 col-md-6"></div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <table  class="table  table-hover dataTable dtr-inline" aria-describedby="example2_info">
                  <thead class="thead-light">
                    <tr>
                      <th class="sorting sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Date</th>
                      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Id</th>
                      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Value</th>
                      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Status</th>
                      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="odd">
                      <td class="dtr-control sorting_1" tabindex="0">Jen 25th 2022</td>
                      <td>#123456</td>
                      <td>$95</td>
                      <td>Available</td>
                      <td>Description</td>
                    </tr>
                    <tr class="even">
                      <td class="dtr-control sorting_1" tabindex="0">Jen 26th 2022</td>
                      <td>#123456</td>
                      <td>$100</td>
                      <td>Available</td>
                      <td>Description</td>
                    </tr>
                    <tr class="odd">
                      <td class="dtr-control sorting_1" tabindex="0">Jen 25th 2022</td>
                      <td>#123456</td>
                      <td>$95</td>
                      <td>Available</td>
                      <td>Description</td>
                    </tr>
                    <tr class="even">
                      <td class="dtr-control sorting_1" tabindex="0">Jen 26th 2022</td>
                      <td>#123456</td>
                      <td>$100</td>
                      <td>Available</td>
                      <td>Description</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
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