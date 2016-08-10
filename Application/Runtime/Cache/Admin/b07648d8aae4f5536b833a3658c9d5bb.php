<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!--
<META HTTP-EQUIV="pragma" CONTENT="no-cache" /> 
<META HTTP-EQUIV="Cache-Control" CONTENT="no-store, must-revalidate" /> 
<META HTTP-EQUIV="expires" CONTENT="Wed, 26 Feb 1997 08:21:57 GMT" /> 
<META HTTP-EQUIV="expires" CONTENT="0" /> 
-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo ($keywords); ?>" />
<meta name="description" content="<?php echo ($description); ?>" />
<link rel="stylesheet" type="text/css" href="/Public/Home/Css/public.css"/>
<script src="/Public/Common/Js/jquery.min.js"></script> 
<script src="/Public/Common/Js/function.js"></script> 
<title><?php echo ($title); ?></title>


 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="/Public/Home/Css/public.css"/>
<link type="text/css" rel="stylesheet" href="/Public/Admin/Css/infor.css" />
<script src="/Public/Common/Js/jquery.min.js"></script> 
<script src="/Public/Common/Js/function.js"></script> 
</head>
<body>
    <div class="inof_div">
        <form name="webinfor"  method="post" action="<?php echo U('Webinfor/xiugai');?>" id="form1">
        <div class="title">网站基本信息</div>
        <div class="hang">
            <div class="lie_1">网站名称</div>
            <input type="text" value='<?php echo ($date["web_name"]); ?>' class="lie_2" name="web_name" />
        </div>
        <div class="hang">
            <div class="lie_1">网站关键字</div>
            <input type="text" value='<?php echo ($date["key_word"]); ?>' class="lie_2" name="key_word" />
        </div>
        <div class="hang">
            <div class="lie_1">网站描述</div>
            <input type="text" value='<?php echo ($date["description"]); ?>' class="lie_2" name="description" />
        </div>
        <div class="hang">
            <div class="lie_1">网站备案号</div>
            <input type="text" value='<?php echo ($date["copy"]); ?>' class="lie_2" name="copy" />
        </div>
        <input type="submit" value="确认修改" class="qrxg" id="qrxg"  />
        </form>
  </div>

    <script type="text/javascript">
        $('#qrxg').bind('click',function(event){
            if(!window.confirm('确定要修改网站信息吗？')){
                event.preventDefault();
            };
        });
    </script> 
</body>
</html>