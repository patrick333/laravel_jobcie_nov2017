'use strict';

var app = angular.module('happyApp', [
    'angular-loading-bar',
    'ngTip',
    'nya.bootstrap.select',
    'validation',
    'validation.rule',
]);

var AJAXAPI = "/api/";

app.factory('http', function($http) {
    this.ajax = function(url, method, params, callback_done, callback_fail) {
        if (url == '') {
            return; 
        }

        if(url.indexOf("/") != 0)
        {
            url = AJAXAPI + url;
        }

        var config = $.extend({
            url: url,
            method: method,
            headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
        }, params);

        $http(config)
        .success(function(response) {
            if (typeof callback_done === 'function') {
                return callback_done(response);
            }
        })
        .error(function(data, status, headers, config) {
            if (status == 401) {
                alert_info();
                //alert(data.error.message);
                return;
                location.reload();
            }
            if (status == 400) {
                alert_info();
                //alert(data.error.message);
                return;
            }
            if (status == 500) {
                alert_info('500','请刷新重试');
                //alert('500');
                return;
                //location.reload();
            }
            if (typeof callback_fail === 'function') {
                return callback_fail(response);
            }
        });
    };

    return this;
});

//jquery ajax 没有loadding效果
app.factory('ajaxReq', function() {
    this.ajax = function(url, type, params, callback_done, callback_fail) {
        if (url == '') {
            return; 
        }

        url = AJAXAPI + url;

        var config = $.extend({
            url: url,
            type: type,
            headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
        }, params);

        //config.crossDomain = true;

        $.ajax(config)
        .done(function(response) {
            if (typeof callback_done === 'function') {
                return callback_done(response);
            }
        })
        .fail(function(response) {
            if (response.status == 401) {
                alert(response.responseJSON.error.message);
                location.reload();
            }
            if (response.status == 400) {
                alert(response.responseJSON.error.message);
            }
            if (response.status == 500) {
                location.reload();
            }
            if (typeof callback_fail === 'function') {
                return callback_fail(response);
            }
        });
    };

    return this;
});

app.filter("trustHtml",function($sce){
   return function (input){
       return $sce.trustAsHtml(input); 
   } 
});

app.filter("convertToInt",function(){
   return function (input){
       return parseInt(input); 
   } 
});

app.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs, ngModel) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;
            element.bind('change', function(event){
                scope.$apply(function(){
                    modelSetter(scope, element[0].files[0]);
                });
                //附件预览
                    scope.file = (event.srcElement || event.target).files[0];
                    scope.getFile();
            });
        }
    };
}]);

app.factory('fileReader', ["$q", "$log", function($q, $log){
    var onLoad = function(reader, deferred, scope) {
        return function () {
            scope.$apply(function () {
                deferred.resolve(reader.result);
            });
        };
    };

    var onError = function (reader, deferred, scope) {
        return function () {
            scope.$apply(function () {
                deferred.reject(reader.result);
            });
        };
    };

    var getReader = function(deferred, scope) {
        var reader = new FileReader();
        reader.onload = onLoad(reader, deferred, scope);
        reader.onerror = onError(reader, deferred, scope);
        return reader;
    };

    var readAsDataURL = function (file, scope) {
        var deferred = $q.defer();
        var reader = getReader(deferred, scope);         
        reader.readAsDataURL(file);
        return deferred.promise;
    };

    return {
        readAsDataUrl: readAsDataURL  
    };
}]);

app.config(['$validationProvider', function ($validationProvider) {
    
    /**
    * Add your Msg Element
    * @param {DOMElement} element - Your input element
    * @return void
    */
    $validationProvider.addMsgElement = function(element) {
        // Insert my own Msg Element
        $(element).parent().append('<span style="margin:0px;"></span>');
    };

    $validationProvider.setErrorHTML(function (msg) {
        return  "<label class=\"control-label has-error error\">" + msg + "</label>";
    });

}]);


//正则分析法 获取URL参数
var getQueryString = function(name)
{
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");  
    var r = window.location.search.substr(1).match(reg);  
    if (r != null) return unescape(r[2]);  
    return null;  
}

var request = function(paras)
{   
    var url = location.href; 
    var paraString = url.substring(url.indexOf("?")+1,url.length).split("&"); 
    var paraObj = {} 
    for (i=0; j=paraString[i]; i++)
    { 
        paraObj[j.substring(0,j.indexOf("=")).toLowerCase()] = j.substring(j.indexOf 
        ("=")+1,j.length); 
    } 
    var returnValue = paraObj[paras.toLowerCase()]; 
    if(typeof(returnValue)=="undefined")
    { 
        return ""; 
    }
    else
    { 
        return returnValue; 
    }
}

//获取URL参数数组
var getRequest = function()
{
    var url = location.search; //获取url中"?"符后的字串   
    var theRequest = new Object();   
    if (url.indexOf("?") != -1) {   
      var str = url.substr(1);   
      var strs = str.split("&");   
      for(var i = 0; i < strs.length; i ++) {   
         theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]);   
      }   
    }
    console.log(theRequest);
    return theRequest;  
}