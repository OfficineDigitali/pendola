@extends('app')

@section('content')

<div class="page-header">
	<h2 class="ui header">Crea Nuovo Utente</h2>
</div>

<form class="form-horizontal" method="POST" action="{{ url('users') }}">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">

	<div class="form-group">
		<label class="col-sm-2 control-label">Nome</label>
		<div class="col-sm-10">
			<input class="form-control" name="name" type="text" value="">
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Mail</label>
		<div class="col-sm-10">
			<input class="form-control" name="mail" type="text" value="">
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Password</label>
		<div class="col-sm-10">
			<input class="form-control" name="password" type="password" value="">
		</div>
	</div>

	@include('commons.savebutton')
</form>

@endsection
