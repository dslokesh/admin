@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Select Activities</h1>
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
                <h3 class="card-title">Select Activities</h3>
				<div class="card-tools">
				
				   </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			   <form id="filterForm" method="post" action="{{route('suppliers.markup.activity.save')}}" >
				   {{ csrf_field() }}
				   <input type="hidden" name="supplier_id" value="{{ $supplierId}}" />
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Activity Name</th>
					<th></th>
                  </tr>
                  </thead>
                  <tbody>
				  
                  @foreach ($records as $record)
				  
                  <tr>
					
                    <td>{{ $record->title}}</td>
					<td><input type="checkbox"  name="activity_id[]" value="{{ $record->id}}" @if(in_array($record->id,$activity_ids))  checked="checked" @endif /></td>
                  </tr>
				 
                  @endforeach
				  
				  
                  </tbody>
                 
                </table>
				<button type="submit" class="btn btn-success float-right">Next</button>
				   </form>
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

@section('scripts')
 @include('inc.citystatecountryjs')
@endsection
