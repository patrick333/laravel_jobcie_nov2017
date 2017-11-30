@extends('layout.master')

@section('title')
    home
@stop

@section('file')
    @parent
	
@endsection

@section('content')


<div style="height: 300px;">
home page {{ url('') }}
</div>


<script type="text/javascript" src="{{ asset('assets/js/controllers/loginController.js') }}"></script>
@stop