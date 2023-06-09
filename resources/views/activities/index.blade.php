@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Activities</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Activities</li>
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
                <h3 class="card-title">Activities</h3>
				<div class="card-tools">
				 <a href="{{ route('activities.create') }}" class="btn btn-sm btn-info">
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
                    <th>Title</th>
					<th>Code</th>
					 <th>Type of Activity</th>
                    <th>Status</th>
					<th>Is Price</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th width="17%"></th>
                  </tr>
				  <tr>
                    <form id="filterForm" method="get" action="{{route('activities.index')}}" >
                    <th><input type="text" name="name" value="{{request('name')}}" class="form-control"  placeholder="Title" /></th>
                  <th></th>
				  <th></th>
					 <th><select name="status" id="status" class="form-control">
                    <option value="" @if(request('status') =='') {{'selected="selected"'}} @endif>Select</option>
                    <option value="1" @if(request('status') ==1) {{'selected="selected"'}} @endif>Active</option>
					          <option value="2" @if(request('status') ==2) {{'selected="selected"'}} @endif >Inactive</option>
                 </select></th>
				  <th><select name="is_price" id="is_price" class="form-control">
                    <option value="" @if(request('is_price') =='') {{'selected="selected"'}} @endif>Select</option>
                    <option value="1" @if(request('is_price') ==1) {{'selected="selected"'}} @endif>Yes</option>
					          <option value="2" @if(request('is_price') ==2) {{'selected="selected"'}} @endif >No</option>
                 </select></th>
					<th></th>
                    <th></th>
                   
                    <th><button class="btn btn-info btn-sm" type="submit">Filter</button>
                    <a class="btn btn-default btn-sm" href="{{route('activities.index')}}">Clear</a></th>
                    
                  </form>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($records as $record)
				  
                  <tr>
					
                    <td>{{ $record->title}}</td>
					<td>{{ $record->code}}</td>
					<td>{{ ($record->type_activity)?$typeActivities[$record->type_activity]:''}}</td>
                    <td>{!! SiteHelpers::statusColor($record->status) !!}</td>
					<td>{!! SiteHelpers::statusColorYesNo($record->is_price) !!}</td>
                    <td>{{ $record->created_at ? date(config('app.date_format'),strtotime($record->created_at)) : null }}</td>
                    <td>{{ $record->updated_at ? date(config('app.date_format'),strtotime($record->updated_at)) : null }}</td>
                     <td>
					 @if($record->prices->count() > 0)
					 <a class="btn btn-info btn-sm" href="{{route('activity.prices.edit',$record->id)}}">
                             Pricing
                              
                          </a>
					@else
						<a class="btn btn-info btn-sm" href="{{route('activity.prices.create',$record->id)}}">
                             Pricing
                              
                          </a>
					@endif
					  <a class="btn btn-info btn-sm" href="{{route('activities.show',$record->id)}}">
                              <i class="fas fa-eye">
                              </i>
                              
                          </a>
					 <a class="btn btn-info btn-sm " href="{{route('activities.edit',$record->id)}}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              
                          </a>
                          <form id="delete-form-{{$record->id}}" method="post" action="{{route('activities.destroy',$record->id)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <a class="btn btn-danger btn-sm hide" href="javascript:void(0)" onclick="
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
				<div class="pagination pull-right mt-3"> 
				{!! $records->appends(request()->query())->links() !!}
				</div> 
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

@section('scripts')
 @include('inc.citystatecountryjs')
@endsection