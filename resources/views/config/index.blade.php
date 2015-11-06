@extends('app')

@section('content')

<div class="well">
	<div class="page-header">
		<h2>Utenti <a class="btn btn-default" href="{{ url('users/create') }}">Clicca qui per creare un nuovo utente</a></h2>
	</div>

	@foreach($users as $user)
	<div class="row">
		<div class="col-md-3">
			<input type="hidden" name="item_id" value="{{ $user->id }}">
			<input type="hidden" name="item_type" value="users">
			<p>{{ $user->name }}</p>
		</div>

		<div class="col-md-7">
			@if(count($user->alarms) == 0)
				<div class="alert alert-info">
					Non ci sono scadenze attive per questo utente.
				</div>
			@else
				<ul>
					@foreach($user->alarms as $alarm)
					<li><a href="{{ url('alarms/' . $alarm->id) }}">{{ $alarm->printableFullDate() }} - {{ $alarm->entity->name }} - {{ $alarm->type->name }}</a></li>
					@endforeach
				</ul>
			@endif
		</div>

		<div class="col-md-2">
			<div class="btn-group" role="group">
				@if(count($users) > 1)
				<a class="btn btn-danger delete-button">
					<span class="glyphicon glyphicon-delete" aria-hidden="true"></span> Elimina
				</a>
				@endif
				<a class="btn btn-default" href="{{ url('users/' . $user->id . '/edit') }}">
					<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Modifica
				</a>
			</div>
		</div>
	</div>
	@endforeach
</div>

<div class="well">
	<div class="page-header">
		<h2>Tipologie di Elemento <a class="btn btn-default" href="{{ url('entities/create') }}">Clicca qui per creare un nuovo tipo</a></h2>
	</div>

	@foreach($entities as $ent)
	<div class="row">
		<div class="col-md-3">
			<p><span class="glyphicon glyphicon-{{ $ent->icon }}" aria-hidden="true"> {{ $ent->name }}</p>
		</div>

		<div class="col-md-7 hidden-xs">
			<ul>
				@foreach($ent->attributes as $attr)
				<li>{{ $attr->name }}</li>
				@endforeach
			</ul>
		</div>

		<div class="col-md-2">
			<div class="btn-group" role="group">
				<a class="btn btn-default" href="{{ url('entities/' . $ent->id . '/edit') }}">
					<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Modifica
				</a>
			</div>
		</div>
	</div>
	@endforeach
</div>

<div class="well">
	<div class="page-header">
		<h2>Esportazione</h2>
	</div>

	<form class="form-inline">
		<p>
			Importa il seguente URL in un client abilitato al formato iCalendar per visualizzare i contenuti direttamente sul desktop.
		</p>
		<div class="form-group">
			<label>Indirizzo File ICS</label>
			<input class="form-control" type="text" value="{{ url('export/ics') }}" disabled>
		</div>
	</form>
</div>

@endsection
