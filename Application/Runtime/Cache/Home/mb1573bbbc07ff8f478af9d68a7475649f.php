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


 
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/member.css">
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/appraise_manage.css">
</head>

<body>
    <div class="fanhui padding"><a href="javascript:history.back()"><span class="iconfont tb_fanhui"id="shangjia_info_fanhui">&#xe603;</span></a>评价管理</div>
    <div class="release">
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div style="margin-bottom: 10px;">
            <a  href="<?php echo U('Goods/index',array('goods_id'=>$vo['goods_id']));?>" class="div_a"><!--内容遍历-->
            <div class="order_row">
                <div class='td_l'>
                    <div class="picture"><img src="<?php echo ($vo['goods_img']); ?>"></div>
                </div>
                    <div class="td_r">
                    <div class="info_name shenglue"><?php echo ($vo['goods_name']); ?></div>
                    <div class="info_name shenglue">商家：<?php echo ($vo['shop_name']); ?></div>
                    </div> 
            </div>
                        </a>
                        <div class='des_title'>我已评价：</div>
                <div class="des_ul">
                    <ul>
                        <li>
                            <span class="pingjia_text">服务与描述相符</span>
                            <!--先简单写成几分，以后有需要再改成图片星星显示
                            <span class="pingjia_xingxing">
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="1_1" />
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="1_2"  />
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="1_3"  />
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="1_4"  />
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="1_5"  />
                            </span>
                            -->
                            <span class="pingjia_last" id="1_des"><?php echo (shuzu(unserialize($vo['pingfen']),0)); ?>分</span>
                        </li>
                        <li>
                            <span class="pingjia_text">商家的服务态度</span>
                            <!--先简单写成几分，以后有需要再改成图片星星显示
                            <span class="pingjia_xingxing">
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="2_1"  />
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="2_2" />
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="2_3" />
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="2_4" />
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="2_5" />
                            </span>
                            -->
                            <span class="pingjia_last" id="2_des"><?php echo (shuzu(unserialize($vo['pingfen']),0)); ?>分</span>
                        </li>
                        <li>
                            <span class="pingjia_text">商家的专业水平</span>
                            <!--先简单写成几分，以后有需要再改成图片星星显示
                            <span class="pingjia_xingxing">
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="3_1" />
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="3_2" />
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="3_3" />
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="3_4" />
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="3_5" />
                            </span>
                            -->
                            <span class="pingjia_last" id="3_des"><?php echo (shuzu(unserialize($vo['pingfen']),0)); ?>分</span>
                        </li>
                    </ul>
                </div>
 
                    <div class="jutipingjia">评价内容：<?php echo ($vo['appraise']); ?></div>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
        
    
        
        
        <div class="page_foot"><?php echo ($page_foot); ?></div>
        
    </div>
   

<iframe height="1" frameborder="0" width="1" style="position:absolute;top:0;left:-9999px;" src="<?php echo U('index/menu');?>"></iframe>




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