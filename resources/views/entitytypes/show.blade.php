@extends('app')

@section('content')

@include('commons.toolbar', ['creation_url' => 'entity/create/?t=' . $master->id])

@if(count($master->entities) == 0)
	<div class="alert alert-info">
		Non sono ancora stati creati elementi di questa categoria.
	</div>
@else
	<div class="row">
		@foreach($master->entities as $ent)
		@include('entities.box', ['type' => $master, 'entity' => $ent])
		@endforeach
	</div>
@endif

@endsection
