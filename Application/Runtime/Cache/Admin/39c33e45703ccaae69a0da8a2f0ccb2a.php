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
<link type="text/css" rel="stylesheet" href="/Public/Admin/Css/manger.css" />
<script src="/Public/Common/Js/jquery.min.js"></script> 
<script src="/Public/Common/Js/function.js"></script> 
<script src="/Public/Common/Js/jquery.form.js"></script> 
</head>
<body>
    <div class="inof_div">
        <div class="title">分类属性管理</div>
        <form name="sv_cont"  method="post"   action="<?php echo U('Category/manger');?>">
            <div class="tr">
                <div class="tr_td1">服务分类</div>
                <select name="server_content" class="tr_td2 release_select" >
                    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo['cat_name']); ?>" <?php echo ($$vo['cat_name']); ?> ><?php echo ($vo['cat_name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
        </form>
        <form  name="sv_shuxing"  method="post"   action="<?php echo U('Category/check');?>">
            <input type="hidden" name="cat_name" value="<?php echo ($cat_name); ?>"/>
            
            <?php if(is_array($arr_shuxing)): $k1 = 0; $__LIST__ = $arr_shuxing;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k1 % 2 );++$k1;?><div class="tr">
                    <div class="tr_td1 js_div "><input name="shuxing[]" class="tr_td1_input release_select" type="text" value="<?php echo ($key); ?>" /><a class="del_a" title="删除"></a></div>
                    <?php if(is_array($vo)): $k2 = 0; $__LIST__ = $vo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($k2 % 2 );++$k2;?><div class="js_div ">
                            <input name="shuxingzhi[<?php echo ($k1-1); ?>][]" class="tr_td2 release_select" type="text" value="<?php echo ($value); ?>"/>
                            <a class="del_a del_a1" title="删除"></a>
                        </div><?php endforeach; endif; else: echo "" ;endif; ?>
                    <input class="input_button_sxz" type="button" value="增加属性值" />
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
        <div class="tr" style="margin-top: 30px;">
            <input type="button" value='增加属性' class="input_button" id='add_sx' /> 
            <input type="submit" value='确认修改' style="margin-left: 30px;" class="input_button" id='qrxg' />
        </div>
        </form>
    </div>
   
    
    
<script src="/Public/Admin/Js/manger.js" type="text/javascript"></script>
</body>
</html>