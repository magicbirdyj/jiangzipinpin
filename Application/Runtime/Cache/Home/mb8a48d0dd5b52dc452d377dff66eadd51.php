<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
<head>
<meta name="screen-orientation" content="portrait" /> <!-- uc强制竖屏 -->
<meta name="x5-orientation" content="portrait" />  <!-- QQ强制竖屏 -->
<!--<meta name="full-screen" content="yes" /> <!-- UC强制全屏 -->
<meta name="x5-fullscreen" content="true" /> <!-- QQ强制全屏 -->
<!--<meta name="browsermode" content="application" /> <!-- UC应用模式 -->
<meta name="x5-page-mode" content="app" /> <!-- QQ应用模式 -->
<meta name="viewport"  content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"  /> 
<meta property="wb:webmaster" content="2e7567efc888fc1e" /> <!--新浪微博分享必须-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo ($keywords); ?>" />
<meta name="description" content="<?php echo ($description); ?>" />

<link rel="shortcut icon" href="/favicon.ico"/>
<link rel="bookmark" href="/favicon.ico"/>
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/public.css"/>
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/head.css"/>
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/footer.css">
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/iconfont/iconfont_guopin/iconfont.css">

<script src="/Public/Common/Js/jquery.min.js"></script> 
<script src="/Public/Common/Js/function.js"></script>
<script src="/Public/Home/Mobile/Js/UC_jinzhisuofang.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<title><?php echo ($title); ?></title>


 
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/public.css"/>
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/goods.css">
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/buy.css">
</head>

<body>

<div class="fanhui padding"><a href="javascript:history.back()"><span class="iconfont tb_fanhui"id="shangjia_info_fanhui">&#xe603;</span></a>提交参团订单</div>
<table class="buy_table" cellspacing="0">
<tr class="buy_table_head">
    <td colspan="2">
        <img src="<?php echo ($goods['goods_img']); ?>"  />
        <div class="goods_name">
            <div class="name"><?php echo ($goods['goods_name']); ?></div>
            <div class="name_price"><span class="price_red"><?php echo ($goods['tuan_number']); ?></span>人团： &yen <span class="price_red"><?php echo (floatval($goods['tuan_price'])); ?> </span> /<?php echo ($goods['units']); ?> </div>
        </div>
    </td>
</tr>
<tr class="buy_table_content">
    <td colspan="2" style='position: relative;'>
        <span class="iconfont tb_address">&#xe621;</span>
        <div class="address">
            <div><?php echo ($default_Address['name']); ?>   <?php echo ($default_Address['mobile']); ?></div>
            <div><?php echo ($default_Address['location']); ?>   <?php echo ($default_Address['address']); ?></div>
        </div>
        <span class="iconfont tb_right">&#xe604;</span>
    </td>
</tr>
<?php if(($goods['1yuangou'] != '1') and ($goods['choujiang'] != '1')): ?><tr class="buy_table_content">
    <td class="td_l">数量：</td>
    <td class="td_r" style='padding: 7px 10px'>
        <span class="number_kongzhi" id='jian'>-</span>
        <input type="text" id='buy_number' value='1' />
        <span class="number_kongzhi" id='jia'>+</span>
    </td>
</tr><?php endif; ?>
<tr class="buy_table_content">
    <td class="td_l">商家：</td>
    <td class="td_r"><?php echo ($goods['user_name']); ?></td>
</tr>

<?php if($youxiao_daijinquan != null): ?><tr class="buy_table_content" id='xz_daijinquan'>
    <td class="td_l">可用代金卷：</td>
    <td class="td_r" style='position: relative;'>
        <span style="margin-right: 30px;" id='ky_daijinquan'></span>
        <span class="iconfont tb_right" style="top:2px;">&#xe604;</span>
    </td> 
</tr><?php endif; ?>
<tr class="buy_table_content">
    <td class="td_l">应付金额：</td>
    <td class="td_r yingfu">&yen <span id="dues"><?php echo (floatval($goods['tuan_price']-$goods['ky_daijinquan'])); ?></span></td>
</tr>


</table>
   
    <form name="dingdan" method="post" action="<?php echo U('Goods/cantuan_success');?>">
        <input type="hidden" name="tuan_no" value="<?php echo ($goods['tuan_no']); ?>" />
        <?php if($zx_shuxing != NULL): ?><input type="hidden" name="zx_shuxing" value='<?php echo ($zx_shuxing); ?>' /><?php endif; ?>
        <input type="hidden" name="buy_number" value="1" />
        <input type="hidden" name="ky_daijinquan" value="0" />
        <input type="hidden" name="dues" value="" />
    </form>
    <a href="javascript:void(0)" class="a_tjdd button_a_lvse" >提交订单</a>
    
    
    <script>
        var ky_daijinquan=0;
        var price=parseInt(<?php echo (floatval($goods['tuan_price'])); ?>);
        var totle_price=price;
    </script>
<?php if($youxiao_daijinquan != null): ?><link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/daijinquan.css">





<div id="overlay"></div><!--遮罩层div-->
<div id='div_daijinquan'>
<div class="fanhui padding"><a href="javascript:void(0)"><span class="iconfont tb_fanhui"id="daijinquan_fanhui">&#xe62d;</span></a>我的代金券</div>
    
    <ul class="daijinquan_ul">
        <?php if(is_array($youxiao_daijinquan)): $i = 0; $__LIST__ = $youxiao_daijinquan;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
            <div class="daijinquan_left price_red">
                <span class="daijinquan_leixing"><?php echo ($vo['type']); ?></span>
                &yen;<span class='daijinquan_money'><?php echo ($vo['sum']); ?></span>
            </div>
            <div class="daijinquan_right">
                <div class="daijinquan_right_div" style="position: relative">
                    <div class="daijinquan_right_div_1 price_red">满<?php echo ($vo['sum']*10); ?>减<?php echo ($vo['sum']); ?></div>
                    <div>全场通用</div>
                    <div><?php echo ($vo['youxiaoqi']); ?></div>
                    <span class="iconfont tb_no_xuanzhong"></span>
                    <span class="iconfont tb_xuanzhong">&#xe62f;</span>
                </div>
            </div>
        </li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>

</div>

<script src="/Public/Home/Mobile/Js/daijinquan.js" type="text/javascript"></script><?php endif; ?>    

<script type="text/javascript">
    $('.a_tjdd').bind('click',function(){
        $('form[name=dingdan]').submit();
    });
    var value;
    $('#buy_number').val('1');
    $('#dues').text(totle_price-ky_daijinquan);
    $(':hidden[name=dues]').val(totle_price-ky_daijinquan);
    $('#jia').bind('click',function(){
        value=parseInt($('#buy_number').val());
        if((value)>8){
            return false;
        }
        $('#buy_number').val((value+1));
        value=parseInt($('#buy_number').val());
        $(':hidden[name=buy_number]').val(value);
        totle_price=value*price;
        $('#dues').html(totle_price-ky_daijinquan);
        $(':hidden[name=dues]').val(totle_price-ky_daijinquan);
        if((value)>8){
            $('#jia').css('background-color','#C8C8C8');
        }
        if((value)>1){
            $('#jian').css('background-color','#FFF');
        }
        daijinquan_each();
    });
    $('#jian').bind('click',function(){
        value=parseInt($('#buy_number').val());
        if((value)<2){
            return false;
        }
        $('#buy_number').val(value-1);
        value=parseInt($('#buy_number').val());
        $(':hidden[name=buy_number]').val(value);
        totle_price=value*price;
        $('#dues').html(totle_price-ky_daijinquan);
        $(':hidden[name=dues]').val(totle_price-ky_daijinquan);
        if((value)<2){
            $('#jian').css('background-color','#C8C8C8');
        }
        if((value)<9){
            $('#jia').css('background-color','#FFF');
        }
        daijinquan_each();
    });
    $('#jian').css('background-color','#C8C8C8');
    
    
    $('#buy_number').bind('change',function(){
        value=parseInt($('#buy_number').val());
        if(value>=9){
            $('#buy_number').val(9);
            $('#jia').css('background-color','#C8C8C8');
            $('#jian').css('background-color','#FFF');
        }else if(value<=1){
            $('#buy_number').val(1);
            $('#jian').css('background-color','#C8C8C8');
            $('#jia').css('background-color','#FFF');
        }
        value=parseInt($('#buy_number').val());
        totle_price=value*price;
        $('#dues').html(totle_price-ky_daijinquan);
        $(':hidden[name=dues]').val(totle_price-ky_daijinquan);
        $(':hidden[name=buy_number]').val(value);
        daijinquan_each();
        });
    
</script>
  <div class="footer">
      <div class="ui-footer">
                  <a href="<?php echo U('Index/index');?>"><span class=" iconfont foot_home foot_tb">&#xe60f;</span><span>首页</span></a>
                  <a href="<?php echo U('Member/sellection');?>"><span class=" iconfont foot_shoucang foot_tb">&#xe620;</span><span>我的收藏</span></a>
                  <a href="<?php echo U('Member/cart');?>"><span class="iconfont foot_pintuan foot_tb">&#xe622;</span><span>我的拼团</span></a>
                  <a href="<?php echo U('Member/index');?>"><span class=" iconfont foot_wode foot_tb">&#xe60a;</span><span>我的酱紫</span></a>
          </div>
  </div> 





<script>
    wx.config({  
        //debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: "<?php echo ($wx_config['appId']); ?>", // 必填，公众号的唯一标识
        timestamp: "<?php echo ($wx_config['timestamp']); ?>", // 必填，生成签名的时间戳
        nonceStr: "<?php echo ($wx_config['nonceStr']); ?>", // 必填，生成签名的随机串
        signature: "<?php echo ($wx_config['signature']); ?>",// 必填，签名，见附录1
        jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareQZone'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
    });
    wx.ready(function () {
        wx.onMenuShareTimeline({
            title: '17一起网', // 分享标题
            imgUrl: 'http://www.17each.com/Public/Home/Images/menu_and_foot/logo.png' // 分享图标
        });
        wx.onMenuShareAppMessage({
            title: '17一起网', // 分享标题
            desc: "要“17”，不要“each”，节省50%费用，拥有梦幻婚礼不再是梦", // 分享描述
            imgUrl: 'http://www.17each.com/Public/Home/Images/menu_and_foot/logo.png' // 分享图标
        });
        wx.onMenuShareQQ({
            title: '17一起网', // 分享标题
            desc: "要“17”，不要“each”，节省50%费用，拥有梦幻婚礼不再是梦", // 分享描述
            imgUrl: 'http://www.17each.com/Public/Home/Images/menu_and_foot/logo.png' // 分享图标
        });
        wx.onMenuShareQZone({
            title: '17一起网', // 分享标题
            desc: "要“17”，不要“each”，节省50%费用，拥有梦幻婚礼不再是梦", // 分享描述
            imgUrl: 'http://www.17each.com/Public/Home/Images/menu_and_foot/logo.png' // 分享图标
        });
    });
    
</script>

</body>
</html>