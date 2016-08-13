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


 
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/lunbo.css">
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/index.css">
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/shop_1.css">
</head>
<body>

    
  


<div  id="logo_header">
<div class="logo"><!--logo-->
    <a href="<?php echo U('Index/index');?>" class="logol"><img src="/Public/Home/Mobile/Images/public/jzpp_logo.jpg" /></a>
<div class="search">
    <form name="searchform" action="<?php echo U('Index/search');?>" method="get" id="searchform">
        <div class="search_div">
            <span class="iconfont tb_search">&#xe60d;</span>
            <input class="inputsr" type="text" name="sp" value="<?php echo ($get['sp']); ?>" placeholder="猫山王 榴莲" maxlength="100" data-role="none"  />
        </div>
    </form>
</div>

</div><!--//logo-->
</div>
<script  type="text/javascript">
    $('.inputsr').bind('click',function(){
        window.location.href="<?php echo U('Index/search_m');?>"; 
    });
    
</script>



  <div class="ui-content">

      <div class="lunbo_div" id="lunbo_div" style="margin-left: -300%;">
          <?php if(is_array($lunbo)): $i = 0; $__LIST__ = $lunbo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U($vo['url']);?>"><img class="lunbo_img" src="<?php echo ($vo['img_url']); ?>" /></a><?php endforeach; endif; else: echo "" ;endif; ?> 
          <?php if(is_array($lunbo)): $i = 0; $__LIST__ = $lunbo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U($vo['url']);?>"><img  class="lunbo_img" src="<?php echo ($vo['img_url']); ?>" /></a><?php endforeach; endif; else: echo "" ;endif; ?>
      </div>
      <div class="choose">
          <div class="choose_div">
              <?php if(is_array($lunbo)): $i = 0; $__LIST__ = $lunbo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><span></span><?php endforeach; endif; else: echo "" ;endif; ?> 
          </div>
      </div>
      <div style="margin-top: -10px;"></div>
      
 <!--分类导航-->
      <div class="ui-grid-c">
          <div><a href="<?php echo U('Index/index');?>"><span class="menu_yuan iconfont tb_home">&#xe60f;</span><span>首页</span></a></div>
          <div><a href="<?php echo U('Category/index',array('cid'=>1));?>"><span class="menu_yuan iconfont tb_miaosha">&#xe612;</span><span>秒杀</span></a></div>
          <div><a href="<?php echo U('Category/index',array('cid'=>2));?>"><span class="menu_yuan iconfont tb_chaozhi">&#xe615;</span><span>超值特卖</span></a></div>
          <div><a href="<?php echo U('Category/index',array('cid'=>3));?>"><span class="menu_yuan iconfont tb_1yuangou">&#xe614;</span><span>1元购</span></a></div>
          <div><a href="<?php echo U('Category/index',array('cid'=>1));?>"><span class="menu_yuan iconfont tb_shuiguo">&#xe617;</span><span>水果</span></a></div>
          <div><a href="<?php echo U('Category/index',array('cid'=>3));?>"><span class="menu_yuan iconfont tb_tianpin">&#xe618;</span><span>甜品</span></a></div>
          <div ><a href="<?php echo U('Category/index',array('cid'=>2));?>"><span class="menu_yuan iconfont tb_guozhi">&#xe613;</span><span>鲜榨果汁</span></a></div>
          <div ><a href="<?php echo U('Category/index',array('cid'=>4));?>"><span class="menu_yuan iconfont tb_zhishi">&#xe61b;</span><span>水果知识</span></a></div>
      </div>
      <!--分类导航结束-->
 
      
      <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="shopping">
                <a  href="<?php echo U('Goods/index',array('goods_id'=>$vo['goods_id']));?>" class="goods_a">
                    <img src="<?php echo ($vo['goods_img_qita_0']); ?>" class="goods_img"/>
                    <div class="goods_infor">
                    <div class="goods_title shenglue border-bottom"><?php echo ($vo['goods_name']); ?></div>
                    <div class="goods_bottom">
                        <div class="goods_infor_left">
                            <span class="iconfont">&#xe61d;</span>
                            <span><?php echo ($vo['tuan_number']); ?>人团</span>
                            <span class="price_red price"><?php echo ($vo['tuan_price']); ?></span>
                            <span class="price_red">元</span>
                            <del style="margin-left: 5px;">单买价：<?php echo ($vo['price']); ?>元</del>
                        </div>
                        <div class="goods_infor_right">
                            <span>已团：<?php echo ($vo['buy_number']); ?></span>
                        </div>
                    </div>
                    </div>
                </a>
            </div><!--商品1--><?php endforeach; endif; else: echo "" ;endif; ?>

    

      
      
      
  </div>    

  

  
  

  

    <!--<script src="/Public/Home/Mobile/Js/index.js" type="text/javascript"></script>-->
    <script src="/Public/Home/Mobile/Js/lunbo.js" type="text/javascript"></script>
    <script src="/Public/Home/Mobile/Js/new_order.js" type="text/javascript"></script>

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