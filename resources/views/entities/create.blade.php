@extends('app')

@section('content')

<div class="page-header">
	<h2 class="ui header">Crea Nuovo Elemento in {{ $master->name }}</h2>
</div>

<form class="form-horizontal" method="POST" action="{{ url('entity') }}">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="type" value="{{ $master->id }}">

	<div class="form-group">
		<label class="col-sm-2 control-label">Nome</label>
		<div class="col-sm-10">
			<input class="form-control" name="name" type="text" value="">
		</div>
	</div>

	@foreach($master->attributes as $attribute)
	<div class="form-group">
		<label class="col-sm-2 control-label">{{ $attribute->name }}</label>
		<div class="col-sm-10">
			{!! $attribute->editMarkup() !!}
		</div>
	</div>
	@endforeach

	@include('commons.savebutton')
</form>

@endsection
