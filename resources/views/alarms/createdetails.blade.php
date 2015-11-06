<form id="new-alarm-details" class="form-horizontal" method="POST" action="{{ url('/alarms') }}">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">

	@if($type->type == 'date')
	<div class="form-group">
		<label class="col-sm-2 control-label">Data</label>
		<div class="col-md-10">
			<input class="form-control date" name="date1" type="text">
		</div>
	</div>
	@else
	<div class="form-group">
		<label class="col-sm-3 control-label">Da</label>
		<div class="col-md-3">
			<input class="form-control date" name="date1" type="text">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">A</label>
		<div class="col-md-3">
			<input class="form-control date" name="date2" type="text">
		</div>
	</div>
	@endif

	@include('commons.user-select', ['label' => 'Referente', 'name' => 'owner_id', 'selected' => $current_user_id])

	<div class="form-group">
		<label class="col-sm-2 control-label">Note</label>
		<div class="col-md-10">
			<textarea class="form-control" name="notes"></textarea>
		</div>
	</div>

	@include('commons.savebutton')
</form>
