@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Suppliers</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Suppliers</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Suppliers</h3>
				<div class="card-tools">
				 <a href="{{ route('suppliers.create') }}" class="btn btn-sm btn-info">
                      <i class="fas fa-plus"></i>
                      Create
                  </a> 
				   </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
					<th>Code</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Company Name</th>
                    <th>City</th>
                    <th>Zip Code</th>
                    <th>Status</th>
                    <th>Created On</th>
                    <th>Updated On</th>
                    <th></th>
                  </tr>
				  <tr>
                    <form id="filterForm" method="get" action="{{route('suppliers.index')}}" >
					 <th></th>
                    <th><input type="text" name="name" value="{{request('name')}}" class="form-control"  placeholder="Name" /></th>
                    <th></th>
                   <th></th>
                    <th></th>
                  
                 <th><select name="city_id" id="city_id" class="form-control">
				<option value="">--select--</option>
				@foreach($cities as $city)
                    <option value="{{$city->id}}" @if(request('city_id') == $city->id) {{'selected="selected"'}} @endif>{{$city->name}}</option>
				@endforeach
                 </select></th>
                 <th></th>
					 <th><select name="status" id="status" class="form-control">
                    <option value="" @if(request('status') =='') {{'selected="selected"'}} @endif>Select</option>
                    <option value="1" @if(request('status') ==1) {{'selected="selected"'}} @endif>Active</option>
					          <option value="2" @if(request('status') ==2) {{'selected="selected"'}} @endif >Inactive</option>
                 </select></th>
					<th></th>
                    <th></th>
                   
                    <th><button class="btn btn-info btn-sm" type="submit">Filter</button>
                    <a class="btn btn-default btn-sm" href="{{route('suppliers.index')}}">Clear</a></th>
                    
                  </form>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($records as $record)
				  
                  <tr>
                    <td>{{ $record->code}}</td>
                    <td>{{ $record->name}}</td>
                    <td>{{ $record->mobile}}</td>
					<td>{{ $record->email}}</td>
                    <td>{{ $record->company_name}}</td>
                    <td>{{ $record->city->name}}</td>
                    <td>{{ $record->zip_code}}</td>
                     <td>{!! SiteHelpers::statusColor($record->status) !!}</td>
                    <td>{{ $record->created_at ? date(config('app.date_format'),strtotime($record->created_at)) : null }}</td>
                    <td>{{ $record->updated_at ? date(config('app.date_format'),strtotime($record->updated_at)) : null }}</td>
                     <td>
					  <a class="btn btn-info btn-sm"  href="{{route('suppliers.markup.activity',$record->id)}}">
                              Markup
                              
                          </a>
					  <a class="btn btn-info btn-sm" href="{{route('suppliers.show',$record->id)}}">
                              <i class="fas fa-eye">
                              </i>
                              
                          </a>
					 <a class="btn btn-info btn-sm" href="{{route('suppliers.edit',$record->id)}}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              
                          </a>
                          <form id="delete-form-{{$record->id}}" method="post" action="{{route('suppliers.destroy',$record->id)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$record->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            "><i class="fas fa-trash"></i></a></td>
                  </tr>
				 
                  @endforeach
                  </tbody>
                 
                </table>
				<div class="pagination pull-right mt-3"> {!! $records->links() !!} </div> 
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

 @include('inc.citystatecountryjs')
