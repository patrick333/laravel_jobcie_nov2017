@extends('layout.master')

@section('title')
    index
@stop

@section('file')
    @parent
	
@endsection

@section('content')

<div style="height: 300px;">
<a href="{{url('login').'?location='.url($_SERVER['REQUEST_URI'])}}">登 录</a>
</div>

<script type="text/javascript" src="{{ asset('assets/js/controllers/loginController.js') }}"></script>
@stop