@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Slot Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('slots.index') }}">Slots</a></li>
              <li class="breadcrumb-item active">Slot Add</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('slots.store') }}" method="post" class="form">
    {{ csrf_field() }}
				<div class="row">
					<div class="col-md-12">
					  <div class="card card-primary">
						<div class="card-header">
						  <h3 class="card-title">Add Slot</h3>
						</div>
						<div class="card-body">
				
						  <div class="form-group">
				<label for="inputName">Slot Type: <span class="red">*</span></label>
				<select name="slot_type" id="slot_type" class="form-control">
					<option value="" @if(old('slot_type') =='') {{'selected="selected"'}} @endif>Select</option>
					<option value="1" @if(old('slot_type') == 1) {{'selected="selected"'}} @endif>Custom</option>
					<option value="2" @if(old('slot_type') == 2) {{'selected="selected"'}} @endif>Auto</option>
				</select>
				@if ($errors->has('slot_type'))
					<span class="text-danger">{{ $errors->first('slot_type') }}</span>
				@endif
			</div>

			<div class="form-group" id="customSlotInput" style="display: none;">
				<label for="customSlot">Custom Time Slot: <span class="red">*</span></label>
				<input type="text" name="custom_slot" placeholder="Time Separated by commas" id="custom_slot" class="form-control"
					value="{{ old('custom_slot') }}">
				<span class="text-info col-md-12">Time Separated by commas like 08:00,09:00,09:15</span>
				@if ($errors->has('custom_slot'))
					<span class="text-danger"><br/>{{ $errors->first('custom_slot') }}</span>
				@endif
			</div>

			<div class="form-group" id="durationInput" style="display: none;">
				<label for="duration">Duration: <span class="red">*</span></label>
				<input type="text" name="duration" placeholder="Value in minutes" id="duration" class="form-control"
					value="{{ old('duration') }}">
				<span class="text-info">Duration in minutes</span>
				@if ($errors->has('duration'))
					<span class="text-danger"><br/>{{ $errors->first('duration') }}</span>
				@endif
			</div>
			   <div class="form-group">
                <label for="inputName">Status: <span class="red">*</span></label>
                <select name="status" id="status" class="form-control">
                    <option value="1" @if(old('status') ==1) {{'selected="selected"'}} @endif>Active</option>
					          <option value="0" @if(old('status') ==0) {{'selected="selected"'}} @endif >Inactive</option>
                 </select>
              </div>
            </div>
			
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <a href="{{ route('slots.index') }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-success float-right">Create</button>
        </div>
      </div>
    </form>
    </section>
    <!-- /.content -->
@endsection
@section('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var slotTypeSelect = document.getElementById('slot_type');
        var customSlotInput = document.getElementById('customSlotInput');
        var durationInput = document.getElementById('durationInput');

        // Show corresponding input based on the old value of slot_type
        if (slotTypeSelect.value == 1) {
            customSlotInput.style.display = 'block';
        } else if (slotTypeSelect.value == 2) {
            durationInput.style.display = 'block';
        }

        slotTypeSelect.addEventListener('change', function () {
            customSlotInput.style.display = (this.value == 1) ? 'block' : 'none';
            durationInput.style.display = (this.value == 2) ? 'block' : 'none';
        });
    });
</script>
@endsection