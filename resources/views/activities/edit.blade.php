@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Activity Edit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('activities.index') }}">Activities</a></li>
              <li class="breadcrumb-item active">Activity Edit</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('activities.update', $record->id) }}" method="post" class="form" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="put">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit Activity</h3>
            </div>
            <div class="card-body row">
              <div class="form-group col-md-6">
                <label for="inputName">Title: <span class="red">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title') ?: $record->title }}" class="form-control"  placeholder="Title" />
                @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
              </div>
			 <div class="form-group col-md-6">
                <label for="inputName">Code: <span class="red">*</span></label>
                <input type="text" id="code" name="code" value="{{ old('code') ?: $record->code  }}" class="form-control"  placeholder="Name" />
                @if ($errors->has('code'))
                    <span class="text-danger">{{ $errors->first('code') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">Type of Activity: <span class="red">*</span></label>
                <select name="type_activity" id="type_activity" class="form-control">
				<option value="">--select--</option>
				@foreach($typeActivities as $key => $typeActivityName)
                    <option value="{{$key}}" @if($record->type_activity == $key) {{'selected="selected"'}} @endif>{{$typeActivityName}}</option>
				@endforeach
                 </select>
				 @if ($errors->has('type_activity'))
                    <span class="text-danger">{{ $errors->first('type_activity') }}</span>
                @endif
              </div>
              
			  @if($record->image)
			  <div class="form-group col-md-4">
				@else
				<div class="form-group col-md-6">
				@endif
                <label for="inputName">Image:</label>
                <input type="file" id="image" name="image"  class="form-control"   />
                @if ($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
              </div>
			   @if($record->image)
              <div class="form-group col-md-2">
                <img src="{{ url('/uploads/activities/thumb/'.$record->image) }}" width="50"  alt="airlines-logo" />
              </div>
              @endif
			 
              <div class="form-group col-md-12">
                <label for="inputName">Status: <span class="red">*</span></label>
                <select name="status" id="status" class="form-control">
                    <option value="1" @if($record->status ==1) {{'selected="selected"'}} @endif>Active</option>
					  <option value="0" @if($record->status ==0) {{'selected="selected"'}} @endif >Inactive</option>
                 </select>
              </div>
			  <div class="form-group col-md-12">
                <label for="inputName">Description: <span class="red">*</span></label>
                <textarea placeholder="Description" name="description" cols="50" rows="10" id="content" class="form-control box-size text-editor">{{ $record->description }}</textarea>
                @if ($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
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
          <a href="{{ route('activities.index') }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-success float-right">Update</button>
        </div>
      </div>
    </form>
    </section>
    <!-- /.content -->
@endsection

 @include('inc.citystatecountryjs')