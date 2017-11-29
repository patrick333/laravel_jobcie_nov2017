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

    $scope.ctrl = {};
    $scope.ctrl.location = '';
    

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

    //test
    $scope.refresh = function()
    {
        loading('');
        var now = new Date();
        var params = {};
        http.ajax('refresh?time='+ now.getFullYear() +'', 'POST', {data:params}, function(response) {
            if (response.success) 
            {
                
            }
            else
            {
                
            }
            hide_loading('');
        });
    }
    

});