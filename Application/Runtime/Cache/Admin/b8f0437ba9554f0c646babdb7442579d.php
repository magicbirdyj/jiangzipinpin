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


 
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<title></title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link rel="stylesheet" type="text/css" href="/Public/Home/Css/public.css"/>
<link type="text/css" rel="stylesheet" href="/Public/Admin/Css/general.css" />
<link type="text/css" rel="stylesheet" href="/Public/Admin/Css/top.css" />




</head>
<body style="cursor: auto;">
<div id="header-div">
  <div style="bgcolor:#000000;" id="logo-div">唯果果</div>
  <div style="bgcolor:#000000;" id="license-div"></div>
  <div id="submenu-div">
    <div style="padding: 5px 10px 0 0; clear:right;text-align: right; color: #FF9900;width:40%;float: right;" id="send_info">
            <!--<a class="fix-submenu" target="main-frame" href="index.php?act=clear_cache">清除缓存</a>-->
            <a class="fix-submenu" target="_top" href="<?php echo U('Login/quit');?>">退出</a>
    </div>
        <div style="padding: 5px 10px 0pt 0pt; text-align: right; color: rgb(255, 153, 0); display: none; width: 40%; float: right;" id="load-div"><img width="16" height="16" style="vertical-align: middle" alt="正在处理您的请求..." src="/Public/Admin/Images/top_loader.gif"> 正在处理您的请求...</div>
  </div>
</div>
<div id="menu-div">
  <ul>
    <li class="fix-spacel">&nbsp;</li>
        <li class="fix-spacer">你好: <?php echo ($admin_hym['user_name']); ?>， 你上次的登录时间是：<?php echo (date("Y-m-d",$admin_hym['last_login'])); ?></li>
        <li class="fix-spacer">&nbsp;</li>
  </ul>
  <br class="clear">
</div>

</body></html>