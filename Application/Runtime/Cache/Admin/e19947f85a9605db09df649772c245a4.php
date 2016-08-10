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


 
<link rel="stylesheet" type="text/css" href="/Public/Home/Css/member.css">
<link rel="stylesheet" type="text/css" href="/Public/Home/Css/release_goods.css">
<script src="/Public/Common/Js/jquery.min.js"></script> 
<script src="/Public/Common/Js/jquery.form.js"></script> 
<script src="/Public/Common/Js/function.js"></script>
</head>
<body>
    <div class="release">
        <div class="div1">
            快递单号填写：
        </div>
        <form name="fahuo" method="post" enctype="multipart/form-data" action="<?php echo U('Ordermanage/fahuo_check');?>" >
            <input name="order_id" value="<?php echo ($order_id); ?>" type="hidden"/> 
            <div class="tr">
                <div class="tr_td1">快递公司</div>
                <input name="kuaidi_company" type="text" class="text"  />
                <span id="info_company"></span>
            </div>
            <div class="tr">
                <div class="tr_td1">单号</div>
                <input name="kuaidi_no" type="text" class="text"  />
                <span id="info_no"></span>
            </div>
        </form>
        <a href="javascript:void(0)" id="xiayibu" class="xyb">立刻发布</a>
    </div>

    
    
    
    <script>
        $(':text[name=kuaidi_company]').bind('focus',function(){text_focus($('#info_company'),'填写发货的快递公司名称, 同城填写同城送达');});
        $(':text[name=kuaidi_company]').bind('blur',function(){text_blue($(this),$('#info_company'),'快递公司名称');});
        $(':text[name=kuaidi_no]').bind('focus',function(){text_focus($('#info_no'),'填写发货的快递单号,同城送达填写0');});
        $(':text[name=kuaidi_no]').bind('blur',function(){text_blue($(this),$('#info_no'),'快递单号');});
        $('#xiayibu').bind('click',function(){fabu();});
        
        function fabu(){
    
   
        var a=text_blue($('input[name=kuaidi_company]'),$('#info_company'),'快递公司名称');
        var b=text_blue($('input[name=kuaidi_no]'),$('#info_no'),'快递单号');
        if(a&&b){
            $('form[name=fahuo]').submit();
        }
        return false;
    }
    </script>