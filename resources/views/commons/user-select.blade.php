<div class="form-group">
	<label class="col-sm-2 control-label">{{ $label }}</label>
	<div class="col-md-10">
		<select class="form-control" name="{{ $name }}">
			@foreach($users as $user)
			<option value="{{ $user->id }}"<?php if($selected == $user->id) echo ' selected="selected"' ?>>{{ $user->name }}</option>
			@endforeach
		</select>
	</div>
</div>
