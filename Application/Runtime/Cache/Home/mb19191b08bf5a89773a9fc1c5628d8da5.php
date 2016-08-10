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


<div class="fanhui padding"><a href="javascript:history.back()"><span class="iconfont tb_fanhui"id="shangjia_info_fanhui">&#xe603;</span></a>微信支付</div>

    <form name="qufukuang" method="get" action="<?php echo U('Goods/alipay');?>">
<table class="buy_table" cellspacing="0">
<tr class="buy_table_head">
    <td colspan="2"><?php echo ($goods['goods_name']); ?></td>
</tr>
<tr class="buy_table_content">
    <td class="td_l">商家：</td>
    <td class="td_r"><?php echo ($goods['shop_name']); ?></td>
</tr>
<tr class="buy_table_content">
    <td class="td_l">价格：</td>
    <td class="td_r">&yen <?php echo (floatval($goods['price'])); ?></td>
</tr>

<tr class="buy_table_content">
    <td class="td_l">代金卷：</td>
    <td class="td_r">&yen <?php echo (floatval($goods['daijinquan'])); ?></td>
</tr>
<tr class="buy_table_content">
    <td class="td_l">应付金额：</td>
    <td class="td_r yingfu">&yen <?php echo (floatval($goods['dues'])); ?></td>
</tr>




</table>
        <input type="hidden" name="order_id" value="<?php echo ($order_id); ?>" />
    </form>
    
    
    <div class="wxzhifu_div">
        <div class="wxzhifu_left">
            <div class="left_content">
                <div class="qrcode-header">
                    <div class="ft-center">扫一扫付款（元）</div>
                    <div class="ft-center qrcode-header-money"><?php echo ($goods['dues']); ?></div>
                </div>
                <div class="qrguide-area" id="J_qrguideArea" seed="NewQr_animationClick">
                    <img style="display: block;" smartracker="on" seed="J_qrguideArea-qrguideAreaImgT1" src="/Public/Home/Images/public/saoyisao_big.jpg" class="qrguide-area-img active">
                </div>
                <div class="qrcode-img-wrapper">
                    <div class="qrcode-img-area">
                        <div style="position: relative;display: inline-block;">
                            <img height="190" width="190" src="<?php echo U('Buy/getQRPHP');?>?data=<?php echo ($payurl); ?>" style="position: relative;left:-10px;" />
                        </div>
                    </div>
                    <div class="qrcode-img-explain fn-clear">
                        <img smartracker="on" seed="qrcodeImgExplain-tImagesT1bdtfXfdiXXXXXXXX" class="fn-left" src="/Public/Home/Images/public/saoyisao.png" alt="扫一扫标识">
                        <div class="fn-left">打开手机微信<br>扫一扫继续付款</div>
                    </div>
                </div>
                <div class="botton_zhifu"><a class="button_a_lvse" href='<?php echo U("Goods/gmcg_wx","order_id=$order_id");?>'>支付成功，如未跳转请点击</a></div>
            </div>
        </div>
        <div class="wxzhifu_right">
            <div class="right_content">
                 <p>支付方法：</p>请用手机打开微信，点击发现，点击扫一扫对准二维码即可。
            </div>
        </div>
    </div>
    
    
    
    


<iframe height="1" frameborder="0" width="1" style="position:absolute;top:0;left:-9999px;" src="<?php echo U('index/menu');?>"></iframe>
<script type="text/javascript">
    var order_id_get="<?php echo ($order_id); ?>";
    var setIn_id=setInterval("jiance_pay()",3000);//1000为1秒钟
    function jiance_pay(){
        var pay_status;
        var url='/Home/Goods/jiance_pay.html';
        var data={
            order_id:order_id_get,
            check:"wx_zhifu"
            };
        $.ajax({
            type:'post',
            async : false,
            url:url,
            data:data,
            datatype:'json',
            success:function(msg){
                pay_status=msg;
            }
        });
        if(pay_status==='1'){
            clearInterval(setIn_id);
            window.location.href='<?php echo U("Goods/gmcg_wx","order_id=$order_id");?>';
        }
    }
</script>
  <div class="footer">
      <div class="ui-footer">
                  <a href="<?php echo U('Index/index');?>"><span class=" iconfont foot_home foot_tb">&#xe60f;</span><span>首页</span></a>
                  <a href="<?php echo U('Member/hunlirenshangjiaxinxi');?>"><span class=" iconfont foot_shoucang foot_tb">&#xe620;</span><span>我的收藏</span></a>
                  <a href="<?php echo U('Member/cart');?>"><span class="iconfont foot_pintuan foot_tb">&#xe61d;</span><span>我的拼团</span></a>
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