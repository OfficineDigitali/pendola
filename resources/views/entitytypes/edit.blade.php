@extends('app')

@section('content')

<div class="page-header">
	<h2 class="ui header">Modifica Tipo di Elemento</h2>
</div>

<form class="form-horizontal" method="POST" action="{{ url('entities/' . $entity->id) }}">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">

	<div class="form-group">
		<label class="col-sm-2 control-label">Nome</label>
		<div class="col-sm-10">
			<input class="form-control" name="name" type="text" value="{{ $entity->name }}">
		</div>
	</div>

	<p>
		Crea qui gli attributi addizionali assegnati al tipo di elemento. Ogni attributo ha un nome ed una tipologia di dato.
	</p>

	<div class="many-rows">
		@if(count($entity->attributes))
			@foreach($entity->attributes as $attribute)
			<div class="row">
				<div class="col-md-2">
					<input class="form-control" name="attribute_id[]" type="hidden" value="{{ $attribute->id }}">
					<input class="form-control" name="attribute_name[]" type="text" value="{{ $attribute->name }}">
				</div>
				<div class="col-md-8">
					<select class="form-control" name="attribute_type[]">
						<option value="string"<?php if ($attribute->datatype == 'string') echo ' selected="selected"' ?>>Testo</option>
						<option value="mail"<?php if ($attribute->datatype == 'mail') echo ' selected="selected"' ?>>Mail</option>
						<option value="date"<?php if ($attribute->datatype == 'date') echo ' selected="selected"' ?>>Data</option>
						<option value="address"<?php if ($attribute->datatype == 'address') echo ' selected="selected"' ?>>Indirizzo</option>
					</select>
				</div>
			</div>
			@endforeach
		@else
			<div class="row">
				<div class="col-md-2">
					<input class="form-control" name="attribute_id[]" type="hidden" value="-1">
					<input class="form-control" name="attribute_name[]" type="text">
				</div>
				<div class="col-md-8">
					<select class="form-control" name="attribute_type[]">
						<option value="string">Testo</option>
						<option value="mail">Mail</option>
						<option value="date">Data</option>
						<option value="address">Indirizzo</option>
					</select>
				</div>
			</div>
		@endif

		<button class="btn btn-default add-many-rows">Aggiungi Nuovo</button>
	</div>

	@include('commons.savebutton')
</form>

@endsection
