<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

		<title>Pendola | HomePage</title>
		<link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap-datepicker3.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap-multiselect.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap-iconpicker.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ url('css/pendola.css') }}">

		<meta name="csrf-token" content="{{ csrf_token() }}"/>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<div class="panel panel-default">
						<div class="panel-body">
							<div id="logo">
								<div class="pendulum-container">
									<img src="{{ url('img/logo-parent.png') }}" class="pendulum-head" />
									<!--
									<svg id="clock" viewBox="0 0 100 100">
										<circle id="face" cx="50" cy="50" r="45"/>
										<g id="hands">
											<rect id="hour" x="48.5" y="12.5" width="3" height="40" rx="0" ry="0" />
											<rect id="min" x="48" y="12.5" width="3" height="30" rx="0" ry="0"/>
										</g>
									</svg>
									-->

									<div style="transform: rotate(0deg) scale(1, 1); display: block;" class="pendulum-parent">
										<img src="{{ url('img/logo-child.png') }}" class="pendulum-child" />
									</div>
								</div>
							</div>

							<p>
								Oggi è {{ strftime('%A %d %B %G', time()) }}
							</p>
						</div>
						<div class="panel-heading">
							<h3 class="panel-title">Azioni</h3>
						</div>
						<ul class="list-group">
							<li class="list-group-item"><a class="item" href="{{ url('alarms') }}">Scadenze</a></li>
						</ul>
						<div class="panel-heading">
							<h3 class="panel-title">Elementi</h3>
						</div>
						<ul class="list-group">
							@foreach($menu_dynamic_entities as $menu_dynamic_entity)
							<li class="list-group-item"><a class="item" href="{{ url('entities/' . $menu_dynamic_entity->id) }}">{{ $menu_dynamic_entity->name }}</a></li>
							@endforeach
						</ul>
						<div class="panel-heading">
							<h3 class="panel-title">Amministrazione</h3>
						</div>
						<ul class="list-group">
							<li class="list-group-item"><a class="item" href="{{ url('config') }}">Configurazioni</a></li>
						</ul>
					</div>
				</div>

				<div class="col-md-9">
					@include('commons.flashing')
					@yield('content')
				</div>
			</div>
		</div>

		<script type="application/javascript" src="{{ url('js/jquery-2.1.1.min.js') }}"></script>
		<script type="application/javascript" src="{{ url('js/jquery-css-transform.js') }}"></script>
		<script type="application/javascript" src="{{ url('js/jquery-animate-css-rotate-scale.js') }}"></script>
		<script type="application/javascript" src="{{ url('js/bootstrap.js') }}"></script>
		<script type="application/javascript" src="{{ url('js/bootstrap-datepicker.min.js') }}"></script>
		<script type="application/javascript" src="{{ url('js/bootstrap-datepicker.it.min.js') }}"></script>
		<script type="application/javascript" src="{{ url('js/bootstrap-multiselect.js') }}"></script>
		<script type="application/javascript" src="{{ url('js/iconset-glyphicon.min.js') }}"></script>
		<script type="application/javascript" src="{{ url('js/bootstrap-iconpicker.min.js') }}"></script>
		<script type="application/javascript" src="{{ url('js/pendola.js') }}"></script>
	</body>
</html>
