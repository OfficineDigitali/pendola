<div class="col-md-6">
	<div class="well">
		<input type="hidden" name="item_id" value="{{ $entity->id }}">
		<input type="hidden" name="item_type" value="entity">

		<h3><span class="glyphicon glyphicon-{{ $master->icon }}" aria-hidden="true"></span> {{ $entity->name }}</h3>

		@if(count($entity->attributes) > 0)
		<p>Attributi</p>
		<ul>
			@foreach($entity->attributes as $attr)
			@if(!empty($attr->value))
			<li>{{ $attr->type->name }} - {{ $attr->displayMarkup() }}</li>
			@endif
			@endforeach
		</ul>
		@endif

		@if(count($entity->alarms) > 0)
		<p>Scadenze Attive:</p>
		<ul>
			@foreach($entity->alarms as $alarm)
			<li><a href="{{ url('alarms/' . $alarm->id) }}">{{ $alarm->printableFullDate() }} - {{ $alarm->type->name }}</a></li>
			@endforeach
		</ul>
		@endif

		<div class="btn-group" role="group">
			<a class="btn btn-danger delete-button">
				<span class="glyphicon glyphicon-delete" aria-hidden="true"></span> Elimina
			</a>
			<a class="btn btn-default" href="{{ url('entity/' . $entity->id . '/edit') }}">
				<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Modifica
			</a>
		</div>
	</div>
</div>
