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
                ngTip.tip([response.data.message],'success');
                $scope.info = {};
                $scope.info.success = true;
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
    

});