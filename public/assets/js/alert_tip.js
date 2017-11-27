///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function tip_hide(s) {
	try { parent.easyDialog.close(); } catch (err) { }
	try { $("#" + s + "").fadeOut(); $("#" + s + "").hide(); BOX_remove(s); } catch (err) { }
}
function hide_loading(s) {
	try { parent.easyDialog.close(); } catch (err) { }
	try { $("#" + s + "").fadeOut(); $("#" + s + "").hide(); BOX_remove(s); } catch (err) { }
}

function ShowLoading(name) {
	$("#" + name + "").html("<div style='width:50px;margin:auto;text-align: center'><img src='/img/loading7.gif'/></div>");
}

///////////////////////////////多少秒后消失 不可关闭////////////////////
function loading(obj) {
	jQuery("#info_tip_info").html(obj==""?"<img src='/img/loading13.gif' >":obj);
	loading_tip();
	//Load(1);
}
function loading_(obj, secs) {
	jQuery("#info_tip_info").html(obj==""?"<img src='/img/loading13.gif' >":obj);
	loading_tip();
	Load_1(secs);
}
var loading_tip = function(){
	easyDialog.open({
		container : 'info_tip',
		lock:false,//esc 关闭close 默认是关闭的
		blackClose : true//关闭点击黑色close 默认是关闭的
	});
};

//////////////////////////Alert_多少秒后消失 不可关闭////////////////////////////////////
function alert_(obj, secs) {
	$("#info_tip_info").html(obj);
	alert_tip();
	Load_1(secs);
}
var alert_tip = function(){
	easyDialog.open({
		container : 'info_tip',
		lock:true,//esc 关闭close 默认是关闭的
		blackClose : true//关闭点击黑色close 默认是关闭的
	});
};

/////////////////////////Alert_多少秒后消失  ESC 黑背景点击可以关闭///////////////////////////////////
function alert_esc(obj) {
	jQuery("#info_tip_info").html(obj);
	alert_esc_tip();
}
function alert_esc(obj, secs) {
	jQuery("#info_tip_info").html(obj);
	alert_esc_tip();
	Load_1(secs);
}
var alert_esc_tip = function(){
	easyDialog.open({
		container: 'info_tip',
	});
};

function Load_1(secs) {
	for (var i = secs; i >= 0; i--) {
		window.setTimeout('doUpdate(' + i + ')', (secs - i) * 800);
	}
}
function doUpdate(num) {
	if (num == 0) {
		jQuery("#info_tip").fadeOut();
		jQuery("#overlay").fadeOut();
	 }
}

function hideLoad(secs, obj)
{
	for (var i = secs; i >= 0; i--) {
		window.setTimeout('HidedoUpdate(' + i + ','+obj+')', (secs - i) * 800);
	}
}
function HidedoUpdate(num , obj) {
	if (num == 0) {
		jQuery(obj).hide(1000);
	 }
}

//手机显示 带右上角CLOSE
var alert_mobile = function (str) {
	easyDialog.open({
		container: 'alert_mobile',
		blackClose: false
	});
	jQuery("#alert_mobile_info").html(str);
};

(function ($){
	jQuery('body').append('<style>.radius{-moz-border-radius: 2px;/* Gecko browsers */-webkit-border-radius: 8px;   /* Webkit browsers */border-radius:2px;/* W3C syntax */box-shadow: 0 0 8px #000;padding:15px; background-color:#000; display:none;color:#fff;font-size:18px;}</style>');
	jQuery('body').append('<div id="info_tip" class="font radius"><span style="color:#fff" id="info_tip_info">11</span></div>');
	
	jQuery('body').append('<style>#alert_mobile{font-size:18px;display:none;box-shadow: 0 0 8px #ccc; line-height:25px;width:300px; margin:auto;position:relative;background-color:#fff;}.alert_mobile_close{width:100%;display: inline-block;cursor: pointer;text-align: center; background-color:#000;color:#fff;padding:10px 0px 10px 0px;}</style>');
	jQuery('body').append('<div id="alert_mobile" ><div id="alert_mobile_info" style="color:000;padding:10px;"></div><div class="alert_mobile_close" onclick="easyDialog.close();">关闭</div></div>');
	
})(jQuery);

function Load(secs,obj) {
	for (var i = secs; i >= 0; i--) {
		window.setTimeout('Close(' + i + ' , "' + obj + '")', (secs - i) * 800);
	}
}
function Close(num, obj) {
	if (num == 0) {
		jQuery("#"+obj).hide(1000);
	 }
}
