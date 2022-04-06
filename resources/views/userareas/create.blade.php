@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User Area Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('userareas.index') }}?userid={{ $user->id }}">User Areas</a></li>
              <li class="breadcrumb-item active">User's Area Add</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('userareas.store') }}" method="post" class="form">
    {{ csrf_field() }}
    <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}" />
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add User Area</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Area: <span class="red">*</span></label>
                <select name="area_id" id="area_id" class="form-control">
                      <option value = "">-Select Area-</option>
                      @foreach($areas as $area)
                        <option value="{{ $area->id }}" @if($area->id == old('area_id')) selected="selected" @endif >{{ $area->title.'-'. $area->zip_code }}</option>
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
          <a href="{{ route('userareas.index') }}?userid={{ $user->id }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-success float-right">Create</button>
        </div>
      </div>
    </form>
    </section>
    <!-- /.content -->
@endsection