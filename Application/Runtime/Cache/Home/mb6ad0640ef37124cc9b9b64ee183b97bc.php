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
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/hunliren_shangjiaxinxi.css">
</head>

<body>
    <div id='wode17'>
    <div class="fanhui padding"><a href="<?php echo U('index/index');?>"><span class="iconfont tb_fanhui"id="shangjia_info_fanhui">&#xe603;</span></a>我的17</div>
    <div class="right_head" id='wode17_head'>
            <div class="hlr_touxiang">
                <img src="<?php echo ($touxiang_url); ?>" class="img" />
                <img src='/Public/Home/Images/public/circle_f6f6f6.png' class="img_circle" />
            </div>
        <div class="hlr_name">
            <div><?php echo ($userdata['user_name']); ?></div>
            <div><?php echo ($day_time); ?></div>    
        </div>
        <div class="jiantou_r"><span class="iconfont tb_jiantou_r">&#xe604;</span></div>
    </div>
    <div class="dingdan">
        <a href="<?php echo U('Order/index');?>" class='dingdan_1'>
            <div class="dingdan_tb_div"><span class="iconfont tb_dingdan">&#xe625;</span></div>
            <div style="float: left;margin-left: 20px;line-height: 30px;font-size: 14px;">全部订单：</div>
            <div class="jiantou_r_xiao"><span><?php echo ($status_count['all']); ?></span><span class="iconfont tb_jiantou_r_xiao">&#xe604;</span></div>
        </a>
        <div class='dingdan_2'>
            <ul>
                <li>
                    <a href="<?php echo U('Order/index?status=no_pay');?>">
                    <div class='dingdan_fenkai_tb_div'>
                        <span class="iconfont tb_dingdan_li" style='font-size: 28px;'>&#xe628;</span>
                        <span style='margin-left: 2px;' class="right_up_tb"><?php echo ($status_count['no_pay']); ?></span>
                    </div>
                    <div><span>待付款</span></div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo U('Order/index?status=wait_tuan');?>">
                    <div class='dingdan_fenkai_tb_div'>
                        <span class="iconfont tb_dingdan_li">&#xe622;</span>
                        <span style='margin-left: 2px;' class="right_up_tb"><?php echo ($status_count['wait_tuan']); ?></span>
                    </div>
                    <div><span>待成团</span></div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo U('Order/index?status=daifahuo');?>">
                    <div class='dingdan_fenkai_tb_div'>
                        <span class="iconfont tb_dingdan_li" style='font-size: 28px;'>&#xe62a;</span>
                        <span style='margin-left: 2px;' class="right_up_tb"><?php echo ($status_count['daifahuo']); ?></span>
                    </div>
                    <div><span>待发货</span></div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo U('Order/index?status=daishouhuo');?>">
                    <div class='dingdan_fenkai_tb_div'>
                        <span class="iconfont tb_dingdan_li">&#xe627;</span>
                        <span style='margin-left: 2px;' class="right_up_tb"><?php echo ($status_count['daishouhuo']); ?></span>
                    </div>
                    <div><span>待收货</span></div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo U('Order/index?status=daipingjia');?>">
                    <div class='dingdan_fenkai_tb_div'>
                        <span class="iconfont tb_dingdan_li">&#xe629;</span>
                        <span style='margin-left: 2px;' class="right_up_tb"><?php echo ($status_count['daipingjia']); ?></span>
                    </div>
                    <div><span>待评价</span></div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    
    
    
        <div class="left">
            <div class="d1">交易管理</div>
            <ul class="left_ul">
                <li><a href="<?php echo U('Member/sellection');?>">我的收藏<div style="float:right"><span><?php echo ($status_count['sellection']); ?></span><span class="iconfont tb_jiantou_r_xiao">&#xe604;</span></div></a></li>
                <li><a href="<?php echo U('Order/appraise_manage');?>">我已评价<div style="float:right"><span><?php echo ($status_count['yipingjia']); ?></span><span class="iconfont tb_jiantou_r_xiao">&#xe604;</span></div></a></li>
                <li><a href="<?php echo U('Order/index?status=shouhou');?>">退款/售后<div style="float:right"><span><?php echo ($status_count['shouhou']); ?></span><span class="iconfont tb_jiantou_r_xiao">&#xe604;</span></div></a></li>
            </ul>
            
            <div class="d1">我的账户</div>
            <ul class="left_ul">
                <li><a href="<?php echo U('Member/daijinquan');?>">代金券<span class="iconfont tb_jiantou_r_xiao">&#xe604;</span></a></li>
                <li><a href='#'>常见问题<span class="iconfont tb_jiantou_r_xiao">&#xe604;</span></a></li>
            </ul>
            
        </div>
</div>
    </div>
    
    
    <div id='wodezhanghu' style='display: none;position: absolute;'>
        <div class="fanhui padding"><a href="javascript:void(0)"><span class="iconfont tb_fanhui" id="wodezhanghu_fanhui">&#xe603;</span></a>我的账户</div>
        <ul class="wodezhanghu_ul">
            <li>
                <a href="<?php echo U('Member/updated_head');?>">
                    <span class="iconfont tb_wodezhanghu">&#xe621;</span>
                    <span style="margin-left: 10px;"><?php echo ($userdata['user_name']); ?></span>
                    <span style="float: right"><span style="font-size: 12px;">编辑收货地址</span><span class="iconfont tb_jiantou_r_xiao">&#xe604;</span></span>
                    
                </a>
            </li>
            <li>
                <a href="<?php echo U('Member/qiehuanzhuanghu');?>">
                    <span class="iconfont tb_wodezhanghu">&#xe60a;</span>
                    <span style="margin-left: 10px;"><?php echo ($userdata['user_name']); ?></span>
                    <span style="float: right"><span style="font-size: 12px;">切换账户</span><span class="iconfont tb_jiantou_r_xiao">&#xe604;</span></span>
                    
                </a>
            </li>
            <li style='padding: 10px 10px;'>
                <a class="tuichu_a" href="<?php echo U('Login/quit');?>">退出登陆</a>
            </li>
        </ul>
    </div>
    
    
    
    <div style='margin-bottom: 50px;'></div>
    
    
    
    
    
    
    
<script src="/Public/Home/Mobile/Js/member.js" type="text/javascript"></script>
</body>
</html>
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