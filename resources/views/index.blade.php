@extends('layout.master')

@section('title')
    index
@stop

@section('file')
    @parent
	
@endsection

@section('content')

<div style="height: 300px;font-size: 25px; text-align: center;">
<a href="{{url('login').'?location='.url($_SERVER['REQUEST_URI'])}}">登 录</a><br>
<a href="{{url('signup').'?location='.url($_SERVER['REQUEST_URI'])}}">注 册</a>
</div>

<script type="text/javascript" src="{{ asset('assets/js/controllers/loginController.js') }}"></script>
@stop