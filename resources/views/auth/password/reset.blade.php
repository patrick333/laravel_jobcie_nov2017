@extends('layout.master')

@section('title')
    password reset
@stop

@section('file')
    @parent
	
@endsection

@section('content')


<div ng-controller="loginController" ng-init="init()" class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                  
                  	<ng-form ng-cloak ng-if='!ctrl.send_email' name="resetForm" class="form-horizontal">
                  		<input type="hidden" name="location" value="{{Request::input('location')}}" ng-model="ctrl.location" ng-init="ctrl.location='{{Request::input('location')}}'">
	                  	<div class="form-group">
						    <label class="col-sm-4 control-label hidden-xs">E-Mail Address</label>
						    <div class="col-md-6">
						        <input name="email" ng-model="formFindPassword.email" type="email" class="form-control" autocomplete="off" autocompletetype="None" placeholder="Email" validator="required,email" required-error-message="Required" required-success-message=".">
						    </div>
						</div>

						<div class="form-group">
						    <label class="col-sm-4 control-label hidden-xs">New Password</label>
						    <div class="col-md-6">
						        <input name="password" ng-model="formFindPassword.password" type="password" class="form-control" placeholder="Password" validator="required" required-error-message="Required" required-success-message=".">
						    </div>
						</div>

	                    <div class="form-group">
	                        <div class="col-md-8 col-md-offset-4">
	                        	<a class="btn btn-primary pull-center" validation-submit="resetForm" ng-click="resetPassword()"> Send Password Reset  </a>
	                        </div>
	                    </div>
					</ng-form>

					<ng-form ng-cloak ng-if='ctrl.send_email' name="codeForm" class="form-horizontal">
                  		<input type="hidden" name="token" ng-model="formFindPassword.token">

						<div class="col-xs-12 m-top-20 m-bottom-30 text-center">
                            <p style="font-size: 13px;"><b>A verification was just sent to  <span style="color: #5286a5;font-size: 13px; display: inline-block;" class="ng-binding">@{{ formFindPassword.email }}</span></b></p>
                            <p style="font-size: 13px;">
                            Please verify your account via the verification code
                            </p>
                        </div>

	                  	<div class="form-group">
						    <label class="col-sm-4 control-label hidden-xs">Verification code</label>
						    <div class="col-md-6">
						        <input name="code" ng-model="formFindPassword.code" type="code" class="form-control" placeholder="Enter verification code" validator="required" required-error-message="Required" required-success-message=".">
						    </div>
						</div>

	                    <div class="form-group">
	                        <div class="col-md-8 col-md-offset-4">
	                        	<a class="btn btn-primary pull-center" validation-submit="codeForm" ng-click="verifyPassword()"> Save Changes  </a>
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