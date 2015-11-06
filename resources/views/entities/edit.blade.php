@extends('app')

@section('content')

<div class="page-header">
	<h2 class="ui header">Modifica Elemento in {{ $entity->type->name }}</h2>
</div>

<form class="form-horizontal" method="POST" action="{{ url('entity/' . $entity->id) }}">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">

	<div class="form-group">
		<label class="col-sm-2 control-label">Nome</label>
		<div class="col-sm-10">
			<input class="form-control" name="name" type="text" value="{{ $entity->name }}">
		</div>
	</div>

	@foreach($entity->type->attributes as $attribute)
	<div class="form-group">
		<label class="col-sm-2 control-label">{{ $attribute->name }}</label>
		<div class="col-sm-10">
			{!! $entity->attribute($attribute)->editMarkup() !!}
		</div>
	</div>
	@endforeach

	@include('commons.savebutton')
</form>

@endsection
