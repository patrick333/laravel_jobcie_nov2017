'use strict';

app.controller('loginController', function($scope, $http, $timeout, http, ajaxReq, ngTip) {
    $scope.convertToInt = function (id) {
		return parseInt(id);
	};

	/*
    |--------------------------------------------------------------------------
    | DISPLAY OPTIONS 
    |--------------------------------------------------------------------------
    */
	$scope.errors = {};
    $scope.ver = '2018';
  	$scope.options = {};
    $scope.formData = {};

    $scope.formRegData = {};
    $scope.formRegData.username='';
    $scope.formRegData.email='';
    $scope.formRegData.password='';

    $scope.formFindPassword = {};
    $scope.formFindPassword.email='';
    $scope.formFindPassword.newPassword='';
    $scope.formFindPassword.code='';

    $scope.ctrl = {};
    $scope.ctrl.location = '';
    $scope.ctrl.send_email = false;
    

    $scope.init = function() 
    {
        $scope.formFindPassword.token = getQueryString('token')
        if(getQueryString('token') != null)
        {
            http.ajax('password/token?ver='+ $scope.ver +'', 'GET', {}, function(response) {
            if (response.success) {
                    $scope.ctrl.send_email = true;
                    $scope.formFindPassword.email = response.data.email;
                }
            }); 
        }
    }

    $scope.login = function(formData)
    {
        loading('');
        http.ajax('login?ver='+ $scope.ver +'', 'POST', {data:formData}, function(response) {
            if (response.success) 
            {
                if($scope.ctrl.location == '')
                {
                    $scope.ctrl.location = '/home';
                }
                window.location.href = $scope.ctrl.location;
            }
            else
            {
                $scope.errors = [];
                angular.forEach(response.errors, function(data,index,array){
                    $scope.errors.push(data)
                });
                ngTip.tip($scope.errors,'danger');
            }
            hide_loading('');
        });
    }

    $scope.register = function()
    {
        loading('');
        var now = new Date();
        var params = {};
        params.username = $scope.formRegData.username; 
        params.email = $scope.formRegData.email;
        params.password = $scope.formRegData.password;

        http.ajax('register?ver='+ $scope.ver +'', 'POST', {data:params}, function(response) {
            if (response.success) 
            {
                if($scope.ctrl.location == '')
                {
                    $scope.ctrl.location = '/home';
                }
                window.location.href = $scope.ctrl.location;
            }
            else
            {
                $scope.errors = [];
                angular.forEach(response.errors, function(data,index,array){
                    $scope.errors.push(data)
                });
                ngTip.tip($scope.errors,'danger');
            }
            hide_loading('');
        });
    }
    
    $scope.resetPassword = function()
    {
        loading('');
        var now = new Date();
        var params = {};
        params.email = $scope.formFindPassword.email; 
        params.password = $scope.formFindPassword.password;

        http.ajax('password/reset?ver='+ $scope.ver +'', 'POST', {data:params}, function(response) {
            if (response.success) 
            {
                window.location.href = window.location.href+'/?token='+response.data.token;
            }
            else
            {
                $scope.errors = [];
                angular.forEach(response.errors, function(data,index,array){
                    $scope.errors.push(data)
                });
                ngTip.tip($scope.errors,'danger');
            }
            hide_loading('');
        });
    }

    $scope.verifyPassword = function()
    {
        loading('');
        var now = new Date();
        var params = {};
        params.token = $scope.formFindPassword.token;
        params.code = $scope.formFindPassword.code; 

        http.ajax('password/verify?ver='+ $scope.ver +'', 'POST', {data:params}, function(response) {
            if (response.success) 
            {
                if($scope.ctrl.location == '')
                {
                    $scope.ctrl.location = '/home';
                }
                window.location.href = $scope.ctrl.location;
            }
            else
            {
                $scope.errors = [];
                angular.forEach(response.errors, function(data,index,array){
                    $scope.errors.push(data)
                });
                ngTip.tip($scope.errors,'danger');
            }
            hide_loading('');
        });
    }

});