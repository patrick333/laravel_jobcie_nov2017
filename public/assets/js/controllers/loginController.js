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
        
    }

    $scope.login = function(formData)
    {
        loading('');
        var now = new Date();
        http.ajax('login?time='+ now.getFullYear() +'', 'POST', {data:formData}, function(response) {
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
                //showMassage('' , $scope.errors);
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

        http.ajax('register?time='+ now.getFullYear() +'', 'POST', {data:params}, function(response) {
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
                //showMassage('' , $scope.errors);
            }
            hide_loading('');
        });
    }
    
    $scope.resetPassword = function()
    {
        $scope.ctrl.send_email = true;
        alert('');
        return ;

        loading('');
        var now = new Date();
        var params = {};
        params.email = $scope.formFindPassword.email; 
        params.password = $scope.formFindPassword.newPassword;

        http.ajax('register?time='+ now.getFullYear() +'', 'POST', {data:params}, function(response) {
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
                //showMassage('' , $scope.errors);
            }
            hide_loading('');
        });
    }

    $scope.verifyPassword = function(formData)
    {
        alert('');
        return ;
    }

});