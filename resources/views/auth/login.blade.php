@extends('auth.app')

@section('content')

@if (count($errors) > 0)
	@foreach ($errors->all() as $error)
		<div class="ui negative message">
			<p>{{ $error }}</p>
		</div>
	@endforeach
@endif

<br />

<form class="form-horizontal" method="POST" action="{{ url('/auth/login') }}">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">

	<div class="form-group">
		<label class="col-sm-2 control-label">Indirizzo E-Mail</label>
		<div class="col-sm-10">
			<input class="form-control" type="email" name="email" value="{{ old('email') }}">
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Password</label>
		<div class="col-sm-10">
			<input class="form-control" type="password" name="password">
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<div class="checkbox">
				<label>
					<input type="checkbox" name="remember"> Ricordami
				</label>
			</div>
		</div>
	</div>

	<br>

	<div class="form-group">
	        <div class="col-sm-offset-2 col-sm-10">
	                <button class="btn btn-success pull-right btn-lg" type="submit">Login</button>
	        </div>
	</div>
</form>

@endsection
