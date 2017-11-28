<!DOCTYPE html>
<html>
<head>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>@yield('title') {{ Config::get('base.website') }}</title>

<link rel="icon" href="Profile-Icon.jpg" sizes="32x32" />
<link rel="icon" href="Profile-Icon.jpg" sizes="192x192" />
<link rel="apple-touch-icon-precomposed" href="Profile-Icon.jpg" />
<meta name="msapplication-TileImage" content="Profile-Icon.jpg" />

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="keywords" content="">

@section('file')

	<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}" type="text/javascript" ></script>
	<script src="{{ asset('assets/vendor/jquery/jquery-ui.js') }}" type="text/javascript"></script>
	<link  href="{{ asset('assets/vendor/jquery/jquery-ui.css') }}" rel="stylesheet" type="text/css" >

	<script src="{{ asset('assets/vendor/angular/angular.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendor/angular/underscore-min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/vendor/angular/angular-validation.js') }}" type="text/javascript"></script>
  	<script src="{{ asset('assets/vendor/angular/angular-validation-rule.js') }}" type="text/javascript"></script>

	<script src="{{ asset('assets/vendor/bootstrap/bootstrap.min.js') }}" type="text/javascript" ></script>
	<link href="{{ asset('assets/vendor/bootstrap/bootstrap.min.css') }}" rel="stylesheet" >

	<link  href="{{ asset('assets/vendor/nya-select/nya-bs-select.css') }}" type="text/css" rel="stylesheet" />
  	<script src="{{ asset('assets/vendor/nya-select/nya-bs-select.js') }}"></script>

	<script src="{{ asset('assets/vendor/bootstrap/bootstrap-select.js') }}" type="text/javascript"></script>
	<link  href="{{ asset('assets/vendor/bootstrap/bootstrap-select.css') }}" rel="stylesheet" type="text/css" >

	<script src="{{ asset('assets/vendor/loading/loading-bar.js') }}" type="text/javascript"></script>
  	<link  href="{{ asset('assets/vendor/loading/loading-bar-red.css') }}" type="text/css" rel="stylesheet" />

  	<script src="{{ asset('assets/vendor/tip/ngTip.js') }}" type="text/javascript"></script>
  	<link  href="{{ asset('assets/vendor/tip/ngTip.css') }}" type="text/css" rel="stylesheet" />

	<script src="{{ asset('assets/js/app.js') }}" type="text/javascript" ></script>
	<script src="{{ asset('assets/js/index.js') }}" type="text/javascript" ></script>

	<link href="{{ asset('assets/css/normalize.css') }}" rel="stylesheet" >
	<link href="{{ asset('assets/css/simple-line-icons.css') }}" rel="stylesheet" >
	<link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet" >
	<link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" >

@show

<script type="text/javascript">
$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});
</script>

</head>
<body ng-app="happyApp" id="main">
<ng-tip></ng-tip>
<div style="width:80%;margin:auto;"></div>
@include('layout.head')

@yield('content','默认值')

@include('layout.footer')

@section('jsfile')

@show
</body>
</html>