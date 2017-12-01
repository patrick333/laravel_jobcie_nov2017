@extends('layout.master')

@section('title')
    Create Your Account
@stop

@section('file')
    @parent
	
@endsection

@section('content')


<div ng-controller="loginController" class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create Your Account</div>

                <div class="panel-body">
                  
                  	<ng-form name="fromRegister" class="form-horizontal">
                  		<input type="hidden" name="location" value="{{Request::input('location')}}" ng-model="ctrl.location" ng-init="ctrl.location='{{Request::input('location')}}'">
	                  	
						<div class="form-group">
						    <label class="col-sm-4 control-label hidden-xs">Username</label>
						    <div class="col-md-6">
						        <input name="username" ng-model="formRegData.username" type="text" class="form-control" placeholder="Username" validator="required" required-error-message="Required" required-success-message=".">
						    </div>
						</div>

	                  	<div class="form-group">
						    <label class="col-sm-4 control-label hidden-xs">E-Mail Address</label>
						    <div class="col-md-6">
						        <input name="email" ng-model="formRegData.email" type="email" class="form-control" autocomplete="off" autocompletetype="None" placeholder="Email" validator="required,email" required-error-message="Required" required-success-message=".">
						    </div>
						</div>

						<div class="form-group">
						    <label class="col-sm-4 control-label hidden-xs">Password</label>
						    <div class="col-md-6">
						        <input name="password" ng-model="formRegData.password" type="password" class="form-control" placeholder="Password" validator="required" required-error-message="Required" required-success-message=".">
						    </div>
						</div>

						
	                    <div class="form-group">
	                        <div class="col-md-8 col-md-offset-4">
	                        	<a class="btn btn-primary pull-center" validation-submit="fromRegister" ng-click="register()"> Register </a>
	                        </div>
	                    </div>
					</ng-form>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="{{ asset('assets/js/controllers/loginController.js') }}"></script>
@stop