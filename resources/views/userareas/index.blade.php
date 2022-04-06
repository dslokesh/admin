@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User Areas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
              <li class="breadcrumb-item active">User Areas</li>
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
                <h3 class="card-title" style="float:none;">{{$user->name}} > Areas <a href="{{ route('userareas.create') }}?userid={{$user->id}}"><span class="float-sm-right btn btn-info btn-sm">Add Area</span></a></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Area Title</th>
                    <th>Zip Code</th>
                    <th>Created On</th>
                    <th>Updated On</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($userareas as $userarea)
                  <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $userarea->area->title}}</td>
                    <td>{{ $userarea->area->zip_code}}</td>
                    <td>{{ $userarea->created_at ? date(config('app.date_format'),strtotime($userarea->created_at)) : null }}</td>
                    <td>{{ $userarea->updated_at ? date(config('app.date_format'),strtotime($userarea->updated_at)) : null }}</td>
                    <td><a class="btn btn-info btn-sm" href="{{route('userareas.edit',$userarea->id)}}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Edit
                          </a>
                          <form id="delete-form-{{$userarea->id}}" method="post" action="{{route('userareas.destroy',$userarea->id)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$userarea->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            "><i class="fas fa-trash"></i>Delete</a></td>
                  </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Area Title</th>
                    <th>Zip Code</th>
                    <th>Created On</th>
                    <th>Updated On</th>
                    <th></th>
                  </tr>
                  </tfoot>
                </table>
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