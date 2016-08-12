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
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/order_view.css">
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/order_tuikuang.css">
<script src="/Public/Common/Js/jquery.form.js"></script> 
</head>

<body>
    <div class="fanhui padding"><a href="javascript:history.back()"><span class="iconfont tb_fanhui"id="shangjia_info_fanhui">&#xe603;</span></a>售后退款</div>
    <div class="view">
        <div class="tuikuang_div">
 
                <div class="d2_title">售后类型<span class="xinghao">*</span></div>
                <form name="shouhou" method="post" action="<?php echo U('Order/shouhou_check');?>">
                <input type='hidden' name='order_id' id='order_id' value="<?php echo ($order['order_id']); ?>" />
                <input name="goods_img" value="" type="hidden"/> 
            <div class="select_div">
            <select name="shouhou_leixing" class="tuikuang_select">
                <option value="申请换货">申请换货</option>
                <option value="申请退货">申请退货</option>
            </select>
            </div>

            <div class="d2_title">售后原因<span class="xinghao">*</span></div>
            <div class="select_div">
            <select name="shouhou_cause" class="tuikuang_select">
                <option value="商品有质量问题">商品有质量问题</option>
                <option value="商品少发、漏发、发错">商品少发、漏发、发错</option>
                <option value="商品与描述不一致">商品与描述不一致</option>
                <option value="收到商品时有划痕或破损">收到商品时有划痕或破损</option>
                <option value="质疑假货">质疑假货</option>
                <option value="其它原因">其它原因</option>
            </select>
            </div>
            
            <div class="d2_title">问题描述<span class="xinghao">*</span><span id='miaoshu_tishi' class="tishi">（您还可以输入170个字）</span></div>
            <div class="select_div">
            <div class="pingjia_box">
            <textarea class="pingjia_textarea" placeholder='问题描述越详细，可以提高您的申请效率哦。（最多170字)' name='miaoshu'></textarea>
            
            <div class="pingjia_box_szp">
                        <div class="file_tr">
                            <div class="tr_td1" style="height: 35px;line-height: 35px;">上传凭证照片<span class="xinghao">*</span><i style="margin-left: 3px;">(<i id="img_count">0</i>/4)</i> <span id='img_tishi' class="tishi"></span></div>
                        <div class="file_jia" id="file_jia">+</div>
                        <span class="file_info" id="file_img_info"></span>
                        <span class="file_tishi"></span>
                        </div>    
                        
            </div>
            </div>
            </div>
            
            <div class="d2_title"> 联系方式<span class="xinghao">*</span><span id='lianxi_tishi' class="tishi" style='color:red'></span></div>
            <div class="select_div">
                <input name='shouhou_iphone' type="text" class="lianxi_iphone" />
            </div>
            {__TOKEN__}
            </form>
            <div class="d2_title"> 售后须知</div>
            <div class="select_div">
                <span style='font-size: 12px;'>请按照提示关注维权进度和超时提醒并提供相应凭证</span>
            </div>
           
    </div>
        
        
                <a class="button_a_lvse" href='javascript:void(0)'  id='tijiao'>提交申请</a>
        </div>

   <form id = "form_file_jia" enctype="multipart/form-data" action="<?php echo U('Order/file_jia');?>" method="post">   
        <input name="file_img" type="file"  style="visibility:hidden; width:0px; height: 0px;"/>
    </form>   
    

<script src="/Public/Home/Mobile/Js/order_tuikuang.js" type="text/javascript"></script>



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