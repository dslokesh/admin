@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User Area Edit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('userareas.index') }}?userid={{ $userarea->user_id }}">User Areas</a></li>
              <li class="breadcrumb-item active">User's Area Edit</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('userareas.update', $userarea->id) }}" method="post" class="form">
    <input type="hidden" name="_method" value="put">
    {{ csrf_field() }}
    <input type="hidden" name="user_id" id="user_id" value="{{$userarea->user_id}}" />
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit User Area</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Area: <span class="red">*</span></label>
                <select name="area_id" id="area_id" class="form-control">
                      <option value = "">-Select Area-</option>
                      @foreach($areas as $area)
                        <option value="{{ $area->id }}" @if(($area->id == old('area_id')) OR ($area->id == $userarea->area_id)) selected="selected" @endif >{{ $area->title.'-'. $area->zip_code }}</option>
                      @endforeach
                  </select>
                @if ($errors->has('area_id'))
                    <span class="text-danger">{{ $errors->first('area_id') }}</span>
                @endif
              </div>
            
            
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <a href="{{ route('userareas.index') }}?userid={{ $userarea->user_id }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-success float-right">Update</button>
        </div>
      </div>
    </form>
    </section>
    <!-- /.content -->
@endsection