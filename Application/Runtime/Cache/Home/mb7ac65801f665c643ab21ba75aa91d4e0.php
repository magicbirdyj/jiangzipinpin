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


 

<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/public.css">
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/goods.css">
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/buy.css">

</head>

<body>
    <?php if($is_ztcg != 'ztcg'): ?><a href="javascript:void(0)" class='button_a_lvse fixed_bottom'>还差 <?php echo ($goods['tuan_number']-$goods['count']); ?>人拼团成功</a>
        <link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/zhishifenxiang.css">





<div id="overlay"></div><!--遮罩层div-->
<div id="zhishi_fenxiang">
    <span class="zhishi_text text1">发送给小伙伴参团</span>
    <?php if($order['tuan_no'] == $order['order_id']): ?><span class="zhishi_text text2">您已开团成功，还差<span class="price_red"><?php echo ($goods['tuan_number']-$goods['count']); ?></span>人成团</span>
    <?php else: ?>
    <span class="zhishi_text text2">您已参加此团，还差<span class="price_red"><?php echo ($goods['tuan_number']-$goods['count']); ?></span>人成团</span><?php endif; ?>
    <span class="zhishi_text text3 price_red">成团后立得66元优惠卷</span>
    
</div>


<script src="/Public/Home/Mobile/Js/zhishifenxiang.js" type="text/javascript"></script><?php endif; ?>
<div class="fanhui padding"><a href="javascript:history.back()"><span class="iconfont tb_fanhui"id="shangjia_info_fanhui">&#xe603;</span></a><?php echo ($title); ?></div>
<table class="buy_table" cellspacing="0">
<tr class="buy_table_head">
    <td colspan="2">
        <img src="<?php echo ($goods['goods_img']); ?>"  />
        <div class="goods_name">
            <div class="name"><?php echo ($goods['goods_name']); ?></div>
            <div class="name_price"><span class="price_red"><?php echo ($goods['tuan_number']); ?></span>人团： &yen <span class="price_red"><?php echo (floatval($goods['tuan_price'])); ?></span> /<?php echo ($goods['units']); ?></div>
        </div>
    </td>
</tr>
<tr class="buy_table_content">
    <td class="td_l">购买数量：</td>
    <td class="td_r"><?php echo ($order['buy_number']); ?></td>
</tr>
<tr class="buy_table_content">
    <td class="td_l">实际付款：</td>
    <td class="td_r">&yen <?php echo (floatval($order['dues'])); ?></td>
</tr>
</table>
<div class="tuan_zhanshi">
    <div class="tuan_all_and_muqian">
    <div class="tuan_all">
        <?php $__FOR_START_28298__=0;$__FOR_END_28298__=$goods['tuan_number'];for($i=$__FOR_START_28298__;$i < $__FOR_END_28298__;$i+=1){ ?><span class="iconfont tb_tuan">&#xe623;</span><?php } ?>
    </div>
    <div class="tuan_muqian">
        <span class="head_span"> <img src="<?php echo ($goods['tuanzhang_head_url']); ?>" class='head_img' /></span>
        <?php if(is_array($tuanyuan)): $i = 0; $__LIST__ = $tuanyuan;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><span class="head_span"><img src="<?php echo ($vo['head_url']); ?>" class='head_img'/></span><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    </div>
    <?php if($is_ztcg != 'ztcg'): ?><div style='text-align: center;padding-bottom: 10px;' id='tishi_span'>还差<span class='price_red'><?php echo ($goods['tuan_number']-$goods['count']); ?></span>人,赶紧点右上角分享给朋友吧</div>
    <div class='time'>剩余 <span id='hours' class='time_span'>&nbsp;&nbsp;&nbsp;&nbsp;</span>：<span id='minutes' class='time_span'>&nbsp;&nbsp;&nbsp;&nbsp;</span>：<span id='seconds' class='time_span'>&nbsp;&nbsp;&nbsp;&nbsp;</span> 结束</div>
    <hr class="hr" /><?php endif; ?>
</div>
<div id='button_pintuan_juti' class="price_red">点我收起拼团详情</div>
<div style="text-align: center;" id='pintuan_juti'>
    
<div class='triangle-up'></div>
<div class="pintuan_juti">
    <span class="head_span float_l" style='margin-right: 10px;'> <img src="<?php echo ($goods['tuanzhang_head_url']); ?>" class='head_img' /> </span>
    <span class="float_l">团长： <?php echo ($goods['tuanzhang_user_name']); ?></span>
    <span class="float_r"><?php echo (date('Y-m-d H:i:s',$goods['tuanzhang_created'])); ?> 开团</span>
</div>
<?php if(is_array($tuanyuan)): $i = 0; $__LIST__ = $tuanyuan;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class='triangle-up triangle-up_tuanyuan'></div>
    <div class="pintuan_juti pintuan_juti_tuanyuan">
        <span class="head_span float_l" style='margin-right: 10px;'> <img src="<?php echo ($vo['head_url']); ?>" class='head_img' /> </span>
        <span class="float_l"><?php echo ($vo['user_name']); ?></span>
        <span class="float_r"><?php echo (date('Y-m-d H:i:s',$vo['created'])); ?> 参团</span>
    </div><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
<div style='margin-bottom: 105px;'></div>
<script>
    var created=<?php echo ($goods['tuanzhang_created']); ?>+86400;
</script>
<script src="/Public/Home/Mobile/Js/daojishi.js" type="text/javascript"></script>
<script>
   $('#button_pintuan_juti').bind('click',function(){
       $('#pintuan_juti').slideToggle(500);
   })
    var is_ztcg="<?php echo ($is_ztcg); ?>";
    if(is_ztcg=='ztcg'){
        clearInterval(timer);
    }
</script>

  <div class="footer">
      <div class="ui-footer">
                  <a href="<?php echo U('Index/index');?>"><span class=" iconfont foot_home foot_tb">&#xe60f;</span><span>首页</span></a>
                  <a href="<?php echo U('Member/sellection');?>"><span class=" iconfont foot_shoucang foot_tb">&#xe620;</span><span>我的收藏</span></a>
                  <a href="<?php echo U('Member/cart');?>"><span class="iconfont foot_pintuan foot_tb">&#xe622;</span><span>我的拼团</span></a>
                  <a href="<?php echo U('Member/index');?>"><span class=" iconfont foot_wode foot_tb">&#xe60a;</span><span>我的果果</span></a>
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