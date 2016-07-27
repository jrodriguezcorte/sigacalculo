<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laravel</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('/js/jquery.min.js') }}"></script>
        <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
        <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
        <link href="{{ asset('/css/jquery-ui.css') }}" rel="stylesheet">
        <script src="{{ asset('/js/jquery-ui.js') }}"></script>
        
        <link href="{{ asset('/css/ui.jqgrid-bootstrap.css') }}" rel="stylesheet">
        <script src="{{ asset('/js/grid.locale-es.js') }}"></script>
        <script src="{{ asset('/js/jquery.jqGrid.min.js') }}"></script>
        
        

	<!-- Fonts -->
	<link href="{{ asset('/css/css.css') }}" rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				{!! HTML::image('logo_avn.jpg', 'AVN', array( 'width' => 150)) !!}
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li style="margin-top: 5%"><h3>
                                                Registro de variaciones detectadas en el SIGA
                                            </h3>
                                        </li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">Login</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/auth/logout') }}">Cerrar Sesión</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')
</body>
</html>
