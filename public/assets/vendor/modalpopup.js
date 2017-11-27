/*
* jQuery CascadingSelect AddOption
*
*
* Licensed like jQuery, see http://docs.jquery.com/License
*
*/

//隐藏和显示select下拉框
function reset(t)
{
	var objs = document.getElementsByTagName("select");
	for (var i = 0; i < objs.length; i++) 
	{
		if(t==1)
		{
			//objs[i].style.display="none";
		}
		else
		{
			//objs[i].style.display="";
		}
		//alert(objs.length);
	}
}


//显示ESC关闭所有窗口
var show_id="user";
$(document).keydown(function(e){ 
	//alert(e.which); ////获取您按的是哪个键 
	if(e.which==27)
	{ 
		//BOX_remove(show_id);
	}
	else
	{ 
		//alert( "err") 
	} 
})
//显示
function BOX_show(e) 
{   
	reset('1');
	show_id=e;
    if(document.getElementById(e)==null){return;}
    BOX_layout(e);
    window.onresize = function(){BOX_layout(e);} //改变窗体重新调整位置
    window.onscroll = function(){BOX_layout(e);} //滚动窗体重新调整位置
}

//移除
function BOX_remove(e)
{   
	reset('2');
    document.getElementById('BOX_overlay').style.display="none";
    document.getElementById(e).style.display="none";
    
    window.onscroll = null;
    window.onresize = null;
}

//调整布局
function BOX_layout(e)
{
    var a = document.getElementById(e);
    
    //判断是否新建遮掩层
    if (document.getElementById('BOX_overlay')==null)
    { 
        var overlay = document.createElement("div");
        overlay.setAttribute('id','BOX_overlay');
        a.parentNode.appendChild(overlay);
    }
    //alert(a.style.width + "," + a.style.height);
    //alert("clientWidth:" + window.parent.innerWidth + ",clientHeight:" + window.parent.innerHeight);
    //取客户端左上坐标，宽，高
    var scrollLeft = (document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft);
    var scrollTop = (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop);
    var clientWidth = document.documentElement.clientWidth;
    var clientHeight = document.documentElement.clientHeight;
    var bo = document.getElementById('BOX_overlay');
    bo.style.left = scrollLeft+'px';
    bo.style.top = scrollTop+'px';
    bo.style.width = clientWidth+'px';
    bo.style.height = clientHeight+'px';
    bo.style.display="";
    //Popup窗口定位
	if (Sys.ie == 6) a.style.position = 'absolute';
	if (Sys.ie) a.style.position = 'absolute';
	if (Sys.firefox) a.style.position = 'absolute';
	if (Sys.chrome) a.style.position = 'fixed';
	if (Sys.opera) a.style.position = 'fixed';
	if (Sys.safari) a.style.position = 'fixed';
	
    a.style.zIndex=99999;
    a.style.display="";
    //a.style.left = "40%";
    //a.style.top = "40%";
    //a.style.left = ((document.documentElement.clientWidth - 780) / 2) + "px";
    //a.style.top = "-10px";
    
    document.getElementById('setting').style.display="block";
    a.style.left = ((document.documentElement.clientWidth - a.clientWidth) / 2) + "px";
    var top = (parseInt((document.documentElement.clientHeight - a.clientHeight - 43) / 2));
    top = parseInt((document.documentElement.clientHeight - a.clientHeight - 43) / 2);  
    if(top < 0)
        top = 0;
    top += document.documentElement.scrollTop;
    a.style.top = top + "px";
}

//IE判断
var Sys = {};
var ua = navigator.userAgent.toLowerCase();
var s;
(s = ua.match(/msie ([\d.]+)/)) ? Sys.ie = s[1] :
(s = ua.match(/firefox\/([\d.]+)/)) ? Sys.firefox = s[1] :
(s = ua.match(/chrome\/([\d.]+)/)) ? Sys.chrome = s[1] :
(s = ua.match(/opera.([\d.]+)/)) ? Sys.opera = s[1] :
(s = ua.match(/version\/([\d.]+).*safari/)) ? Sys.safari = s[1] : 0;

//以下进行测试
//if (Sys.ie) alert('IE: ' + Sys.ie + '。请使用 Internet Explorer 6 或更高版本浏览器');
//if (Sys.ie) ChkWin2();

//if (Sys.ie == 6) alert('请使用 Internet Explorer 7 或更高版本浏览器');
//if (Sys.firefox) alert('Firefox: ' + Sys.firefox + '。请使用 Internet Explorer 7 或更高版本浏览器');
//if (Sys.chrome) alert('Chrome: ' + Sys.chrome + '。请使用 Internet Explorer 7 或更高版本浏览器');
//if (Sys.opera) alert('Opera: ' + Sys.opera + '。请使用 Internet Explorer 7 或更高版本浏览器');
//if (Sys.safari) alert('Safari: ' + Sys.safari + '。请使用 Internet Explorer 7 或更高版本浏览器');


//点击黑色关闭
//jQuery(document).ready(function() { 
	//$("#BOX_overlay").click(function() { 
		//alert(show_id);
		//BOX_remove(show_id);
	//});
//});


