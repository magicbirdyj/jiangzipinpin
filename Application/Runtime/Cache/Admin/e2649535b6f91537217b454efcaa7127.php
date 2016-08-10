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


 

<link rel="stylesheet" type="text/css" href="/Public/Home/Css/public.css"/>
<link type="text/css" rel="stylesheet" href="/Public/Admin/Css/ordermange.css" />
<script src="/Public/Common/Js/jquery.min.js"></script> 
<script src="/Public/Common/Js/function.js"></script> 
<script src="/Public/Common/Js/jquery.form.js"></script> 
</head>
<body>
    <div class="inof_div">
        <div class="big_title">订单管理</div>

        <div class="title"><!--标题行-->
            <div class='td2'>团购号</div>
            <div class='td3'>商品名称</div>
            <div class='td4'>商家</div>
            <div class='td5'>订单状态</div>
            <div class='td6'>买家</div>
            <div class='td7'>购买数量</div>
            <div class='td8'>发货地址</div>
            <div class='td9'>支付</div>
            <div class='td10'>几人团</div>
            <div class='td11'>发货天数</div>
            <div class='td12'>代金券</div>
            <div class='td13'>金额</div>
            <div class='td14'>下单时间</div>
            <div class='td15'>操作</div>
        </div>
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="content"><!--内容遍历-->
            <div class='td2'><?php echo ($vo['tuan_no']); ?></div>
            <div class='td3'><?php echo ($vo['goods_name']); ?></div>
            <div class='td4'><?php echo ($vo['shop_name']); ?></div>
            <div class='td5'><?php echo get_status($vo['status'],$vo['pay_status'],$vo['tuan_no']);?></div>
            <div class='td6'><?php echo ($vo['user_name']); ?></div>
            <div class='td7'><?php echo ($vo['buy_number']); ?></div>
            <div class='td8'><?php echo get_admin_order(get_order_address($vo['address'],$vo['order_address']));?></div>
            <div class='td9'><?php echo ($vo['pay_status']=='0'?'未支付':'已支付'); ?></div>
            <div class='td10'><?php echo ($vo['tuan_number']); ?></div>
            <div class='td11'><?php echo ($vo['order_fahuo_day']); ?>天</div>
            <div class='td12'>&yen;<?php echo (intval($vo['daijinquan'])); ?></div>
            <div class='td13'>&yen;<?php echo (intval($vo['dues'])); ?></div>
            <div class='td14'><?php echo (date("Y/m/d",$vo['created'])); ?></div>
            <?php if((($vo['status'] == 1)and ($vo['pay_status'] == 1) and ($vo['tuan_no'] == 0))or (($vo['status'] == 2)and ($vo['pay_status'] == 1) and ($vo['tuan_no'] != 0))): ?><div class='td15'><a style="margin-top:15px; " id="<?php echo ($vo['order_id']); ?>" href='<?php echo U("Ordermanage/fahuo",array("order_id"=>$vo["order_id"]));?>'><input type="button"  value="发货" /></a></div>
            <?php elseif(($vo['status'] == 6) and ($vo['pay_status'] == 1)): ?>
            <div class='td15'><a style="margin-top:15px; " id="<?php echo ($vo['goods_id']); ?>" href='<?php echo U("Goodsmanage/goods_editor",array("goods_id"=>$vo["order_id"]));?>'><input type="button"  value="退款" /></a></div>
            <?php elseif($vo['pay_status'] == 2): ?>
            <div class='td15'><a style="margin-top:15px; " id="<?php echo ($vo['order_id']); ?>" href='<?php echo U("Goodsmanage/goods_editor",array("goods_id"=>$vo["order_id"]));?>'><input type="button"  value="处理退款" /></a></div>
            <?php else: ?>
             <div class='td15'></div><?php endif; ?>
        </div><?php endforeach; endif; else: echo "" ;endif; ?> 
    
        
        
        <div class="page_foot"><?php echo ($page_foot); ?></div>
    </div>
   
    
    

<script type="text/javascript">
    $('select[name=server_content]').bind('change',function(){sc_change();});
    function sc_change(){
        $('form[name=sv_cont]').submit();
    }
    $('.input_button').bind('click',function(){
        var id=$(this).attr('id');
        var name=$(this).attr('name');
        if(window.confirm('确定要把 ['+name+']下架 吗？')){
            var url="/Admin/Goodsmanage/goods_del/goods_id/"+id+".html";
            $.ajax({
                type:'get',
                async : false,
                url:url,
                datatype:'json'
            });
            window.location.href=window.location.href;
        }else{
            return false;
        }   
    });
    
    
    
</script>