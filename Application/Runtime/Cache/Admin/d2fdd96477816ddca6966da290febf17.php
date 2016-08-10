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
<link type="text/css" rel="stylesheet" href="/Public/Admin/Css/advert.css" />
<script src="/Public/Common/Js/jquery.min.js"></script> 
<script src="/Public/Common/Js/function.js"></script> 
<script src="/Public/Common/Js/jquery.form.js"></script> 
</head>
<body>
    <div class="inof_div">
        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><form name="qrsc_<?php echo ($vo['xuhao']); ?>"  method="post" enctype="multipart/form-data"  action="<?php echo U('Advert/sc');?>">
            <input name="text_file_<?php echo ($vo['xuhao']); ?>" value="" type="hidden"/> 
        </form><?php endforeach; endif; else: echo "" ;endif; ?>
        
        
            <div class="title">网站首页广告（<?php echo ($data[0]['position']); ?>）管理</div>
            <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="zhuce1_tr">
            <div class="zhuce4_tr_td1" >轮播图片(<?php echo ($vo['xuhao']); ?>)</div>
            <div class="div_goods_img"><img src="" class="empty_img" /><img class="goods_img" id="file_<?php echo ($vo['xuhao']); ?>"  src="<?php echo ($vo['img_url']); ?>" /></div> 
            <span class="file_tishi">(分辨率735*300)</span>
            <input type="button" value="确认上传" class="qrsc" id="qrsc_<?php echo ($vo['xuhao']); ?>"  />
            <input type="button" value="详情编辑" class="xqbj" id="<?php echo ($vo['xuhao']); ?>"  />
        </div><?php endforeach; endif; else: echo "" ;endif; ?>

     
  </div>
    <img src="/Public/Home/Images/index/sylb/sylbs-1.jpg" class="fangda" />

    
    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><form id = "form_file_<?php echo ($vo['xuhao']); ?>" enctype="multipart/form-data" action="<?php echo U('Advert/file_jia');?>" method="post" name="form_file_<?php echo ($vo['xuhao']); ?>">   
        <input name="file_<?php echo ($vo['xuhao']); ?>" type="file"  style="visibility:hidden; width:0px; height: 0px;"/>
    </form><?php endforeach; endif; else: echo "" ;endif; ?>
    
    <script src="/Public/Admin/Js/advert.js"></script> 
    
    <script>
        $('.xqbj').bind('click',function(){
            var id=$(this).attr('id');
            self.location="/admin/advert/xqbj?xuhao="+id; 
        });
    </script>
    

</body>
</html>