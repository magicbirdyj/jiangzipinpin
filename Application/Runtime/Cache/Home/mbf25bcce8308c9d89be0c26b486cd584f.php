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
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/order_appraise.css">
<script src="/Public/Common/Js/jquery.form.js"></script> 

</head>

<body>
    <div class="view">
        <div class="fanhui padding"><a href="javascript:history.back();"><span class="iconfont tb_fanhui"id="shangjia_info_fanhui">&#xe603;</span></a>请您评价</div>


        <div class="d2">
            <div class="d2_title">请您评价</div>
            <div class="d2_content">
                <div>买家小伙伴们都很关注你的点评，帮助他们购买噢</div>
                <div>亲，交易成功后，如果商品出现问题，您可以继续享受相应的售后服务哦。 </div>
            </div>
            <div class="d2_title">商品信息</div>
            <div class="order_row">
                <div class='td_l'>
                    <div class="picture"><img src="<?php echo ($order['goods_img']); ?>"></div>
                </div>
                <div class="td_r">
                    <div class="info_name shenglue"><?php echo ($order['goods_name']); ?></div>
                    <div class="info_name shenglue">订单状态：<?php echo order_status($order['pay_status'],$order['status'],$order['order_id'],$order['server_day'])['status'];?></div>
                    <div class='info_name'>价格：&yen;<?php echo ($order['price']); ?></div>
                    <div class='info_name'>支付金额：&yen;<?php echo ($order['dues']); ?></div>
                
                </div>
                </div>
        </div>
        <div class='pingjia_title'>评价服务</div>
        <form name="m_appraiseform_appraise" method="post" action="<?php echo U('Order/appraise_success',array('order_id'=>$order_id));?>" enctype="multipart/form-data" >
        <input name="goods_img" value="" type="hidden"/> 
            <div class="pingjia">
            <div class="pingjia_top">
                <div class="pingjia_box">
                    <textarea class="pingjia_textarea" name="pingjia_text" placeholder="我们真诚的期待您的评价" ></textarea>
                    <div class="pingjia_box_szp">
                        <div class="file_tr">
                        <div class="tr_td1" style="height: 35px;line-height: 35px;">晒照片<i style="margin-left: 3px;">(<i id="img_count">0</i>/4)</i></div>
                        <div class="file_jia" id="file_jia">+</div>
                        <span class="file_info" id="file_img_info"></span>
                        <span class="file_tishi"></span>
                        </div>    
                        
                    </div>
                </div>
            </div>
            <div class="hr"></div>
            <div style="position: relative;">
                <h2 class='des_title'>商品评分</h2>
                <div class="des_ul">
                    <ul>
                        <li>
                            <span class="pingjia_text">商品与描述相符</span>
                            <div class="yingcang yc_1"></div>
                            <span class="pingjia_xingxing">
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="1_1" />
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="1_2"  />
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="1_3"  />
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="1_4"  />
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="1_5"  />
                            </span>
                            <span class="pingjia_last" id="1_des">
                                请点击星星评分后再发表评论
                            </span>
                        </li>
                        <li>
                            <span class="pingjia_text">商家的服务态度</span>
                            <span class="pingjia_xingxing">
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="2_1"  />
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="2_2" />
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="2_3" />
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="2_4" />
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="2_5" />
                            </span>
                            <span class="pingjia_last yingcang" id="2_des">
                                请点击星星评分后再发表评论
                            </span>
                        </li>
                        <li>
                            <span class="pingjia_text">商家的发货速度</span>
                            <div class="yingcang yc_3"></div>
                            <span class="pingjia_xingxing">
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="3_1" />
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="3_2" />
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="3_3" />
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="3_4" />
                                <img src="/Public/Home/Images/public/pingjia_xingxing_kong.png" id="3_5" />
                            </span>
                            <span class="pingjia_last yingcang" id="3_des">
                               请点击星星评分后再发表评论
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
            <input type="hidden" name="pingfen_1" />
            <input type="hidden" name="pingfen_2" />
            <input type="hidden" name="pingfen_3" />
        </form>
        <a href="javascript:void(0)" class="button_a_lvse" id="fabiao">发表评论</a>
    </div>

    <form id = "form_file_jia" enctype="multipart/form-data" action="<?php echo U('Order/file_jia');?>" method="post">   
        <input name="file_img" type="file"  style="visibility:hidden; width:0px; height: 0px;"/>
    </form>   


<script src="/Public/Home/Mobile/Js/order_appraise.js" type="text/javascript"></script>
<script type="text/javascript">
    var src="/Public/Home/Images/public/pingjia_xingxing_kong.png";
    var src1=src,src2=src,src3=src,i1=1,i2=1,i3=1;
    $('.pingjia_xingxing>img').bind('click',function(){
    if($(this).index()<2){
        $(this).parent().children(":lt("+($(this).index()+1)+")").attr('src',"/Public/Home/Images/public/pingjia_xingxing_hui.png");
        $(this).parent().children(":gt("+$(this).index()+")").attr('src',"/Public/Home/Images/public/pingjia_xingxing_kong.png");
    }else{
        $(this).parent().children(":lt("+($(this).index()+1)+")").attr('src',"/Public/Home/Images/public/pingjia_xingxing.png");
        $(this).parent().children(":gt("+$(this).index()+")").attr('src',"/Public/Home/Images/public/pingjia_xingxing_kong.png");
    }
});


$('.pingjia_xingxing>img').bind('click',function(){
      switch($(this).attr('id')){
         case '1_1':
             $('#1_des').css('display','block');
             $('#1_des').html('<strong>1 分 很差</strong>- 很差，严重与描述不相符合，非常不满');
             $('#1_des').css('color','#666');
             src1="/Public/Home/Images/public/pingjia_xingxing_hui.png";
             i1=1;
             $('input[name=pingfen_1]').attr('value','1');
             break;
         case '1_2':
             $('#1_des').css('display','block');
             $('#1_des').html('<strong>2 分</strong>- 不满，部分与描述不相符合');
             $('#1_des').css('color','#666');
             src1="/Public/Home/Images/public/pingjia_xingxing_hui.png";
             i1=2;
             $('input[name=pingfen_1]').attr('value','2');
             break;
         case '1_3':
             $('#1_des').css('display','block');
             $('#1_des').html('<strong>3 分</strong>- 一般，没有商品描述的那么好');
             $('#1_des').css('color','#666');
             src1="/Public/Home/Images/public/pingjia_xingxing.png";
             i1=3;
             $('input[name=pingfen_1]').attr('value','3');
             break;
         case '1_4':
             $('#1_des').css('display','block');
             $('#1_des').html('<strong>4 分</strong>- 满意，与描述基本一致，符合自己的预期');
             $('#1_des').css('color','#666');
             src1="/Public/Home/Images/public/pingjia_xingxing.png";
             i1=4;
             $('input[name=pingfen_1]').attr('value','4');
             break;
         case '1_5':
             $('#1_des').css('display','block');
             $('#1_des').html('<strong>5 分</strong>- 非常好，与描述完全一致，非常满意');
             $('#1_des').css('color','#666');
             src1="/Public/Home/Images/public/pingjia_xingxing.png";
             i1=5;
             $('input[name=pingfen_1]').attr('value','5');
             break;
         case '2_1':
             $('#2_des').css('display','block');
             $('#2_des').html('<strong>1 分</strong>- 很差，商家态度很差，简直不把顾客当回事');
             $('#2_des').css('color','#666');
             src2="/Public/Home/Images/public/pingjia_xingxing_hui.png";
             i2=1;
             $('input[name=pingfen_2]').attr('value','1');
             break;
         case '2_2':
             $('#2_des').css('display','block');
             $('#2_des').html('<strong>2 分</strong>- 不满意，商家承诺的服务都兑现不了');
             $('#2_des').css('color','#666');
             src2="/Public/Home/Images/public/pingjia_xingxing_hui.png";
             i2=2;
             $('input[name=pingfen_2]').attr('value','2');
             break;
         case '2_3':
             $('#2_des').css('display','block');
             $('#2_des').html('<strong>3 分</strong>- 一般，商家态度一般、服务不主动');
             $('#2_des').css('color','#666');
             src2="/Public/Home/Images/public/pingjia_xingxing.png";
             i2=3;
             $('input[name=pingfen_2]').attr('value','3');
             break;
         case '2_4':
             $('#2_des').css('display','block');
             $('#2_des').html('<strong>4 分</strong>- 满意，沟通流畅、服务主动');
             $('#2_des').css('color','#666');
             src2="/Public/Home/Images/public/pingjia_xingxing.png";
             i2=4;
             $('input[name=pingfen_2]').attr('value','4');
             break;
         case '2_5':
             $('#2_des').css('display','block');
             $('#2_des').html('<strong>5 分</strong>- 非常满意，商家的服务完全超出期望值');
             $('#2_des').css('color','#666');
             src2="/Public/Home/Images/public/pingjia_xingxing.png";
             i2=5;
             $('input[name=pingfen_2]').attr('value','5');
             break;
         case '3_1':
             $('#3_des').css('display','block');
             $('#3_des').html('<strong>1 分</strong>- 很不满意，商家超过预期发货');
             $('#3_des').css('color','#666');
             src3="/Public/Home/Images/public/pingjia_xingxing_hui.png";
             i3=1;
             $('input[name=pingfen_3]').attr('value','1');
             break;
         case '3_2':
             $('#3_des').css('display','block');
             $('#3_des').html('<strong>2 分</strong>- 不满意，商家发货有点慢，催促几次才发货');
             $('#3_des').css('color','#666');
             src3="/Public/Home/Images/public/pingjia_xingxing_hui.png";
             i3=2;
             $('input[name=pingfen_3]').attr('value','2');
             break;
         case '3_3':
             $('#3_des').css('display','block');
             $('#3_des').html('<strong>3 分</strong>- 一般，商家发货速度一般，提醒后才发货的');
             $('#3_des').css('color','#666');
             src3="/Public/Home/Images/public/pingjia_xingxing.png";
             i3=3;
             $('input[name=pingfen_3]').attr('value','3');
             break;
         case '3_4':
             $('#3_des').css('display','block');
             $('#3_des').html('<strong>4 分</strong>- 满意，商家发货还算及时');
             $('#3_des').css('color','#666');
             src3="/Public/Home/Images/public/pingjia_xingxing.png";
             i3=4;
             $('input[name=pingfen_3]').attr('value','4');
             break;
         case '3_5':
             $('#3_des').css('display','block');
             $('#3_des').html('<strong>5 分</strong>- 非常满意，商家发货速度非常快');
             $('#3_des').css('color','#666');
             src3="/Public/Home/Images/public/pingjia_xingxing.png";
             i3=5;
             $('input[name=pingfen_3]').attr('value','5');
             break;
     }
  });
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