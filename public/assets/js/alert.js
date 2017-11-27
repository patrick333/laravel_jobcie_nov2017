function $import(path, type){
 var i, 
      base, 
      src = "", 
      scripts = document.getElementsByTagName("script");  
 for (i = 0; i < scripts.length; i++) {
      if (scripts[i].src.match(src)) {
          //alert(scripts[i].src.replace(src, ""));
          base = "/";
          break;
      }
  }
  if (type == "css") {
      document.write("<" + "link href=\"" + base + path + "\" rel=\"stylesheet\" type=\"text/css\"></" + "link>");
  } else {
      document.write("<" + "script language=\"JavaScript\" type=\"text/javascript\" src=\"" + base + path + "\"></" + "script>");
  }
}

$import('assets/vendor/easydialog/easydialog.js', 'js');
$import('assets/vendor/easydialog/easydialog.css', 'css');

var btnFn = function () {
	return true; //确定关闭窗口
};
var alert_info_sys = function (str) {
	easyDialog.open({
		container: {
			header: '系统提示', //标题
			content: str, //内容
			yesFn: btnFn, //确定按钮
			noFn: true //取消按钮
		},
		drag: false, //关闭拖动
		blackClose: true //关闭点黑色关闭
	});
};


