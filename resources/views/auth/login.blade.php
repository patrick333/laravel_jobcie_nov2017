@extends('layout.master')

@section('title')
    login
@stop

@section('file')
    @parent
	
@endsection

@section('content')


<div ng-controller="loginController" class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>

                <div class="panel-body">
                  
                  	<ng-form name="fromLogin" class="form-horizontal">
                  		<input type="hidden" name="location" value="{{Request::input('location')}}" ng-model="ctrl.location" ng-init="ctrl.location='{{Request::input('location')}}'">
	                  	<div class="form-group">
						    <label class="col-sm-4 control-label hidden-xs">E-Mail Address</label>
						    <div class="col-md-6">
						        <input name="email" ng-model="formData.email" type="email" class="form-control" autocomplete="off" autocompletetype="None" placeholder="Email" validator="required,email" required-error-message="Required" required-success-message=".">
						    </div>
						</div>

						<div class="form-group">
						    <label class="col-sm-4 control-label hidden-xs">Password</label>
						    <div class="col-md-6">
						        <input name="password" ng-model="formData.password" type="password" class="form-control" placeholder="Password" validator="required" required-error-message="Required" required-success-message=".">
						    </div>
						</div>

						<div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

	                    <div class="form-group">
	                        <div class="col-md-8 col-md-offset-4">
	                        	<a class="btn btn-primary pull-center" validation-submit="fromLogin" ng-click="login(formData)"> Login </a>

	                            <a class="btn btn-link" href="{{ url('password/reset') }}">
	                                Forgot Your Password?
	                            </a>
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