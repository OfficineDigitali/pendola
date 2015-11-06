<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

		<title>Pendola | Autenticazione</title>
		<link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap.min.css') }}">
	</head>
	<body>
		<div class="container">
			<div class="row mastercontents">
				<div class="col-md-12">
					@include('commons.flashing')
					@yield('content')
				</div>
			</div>
		</div>
	</body>
</html>
