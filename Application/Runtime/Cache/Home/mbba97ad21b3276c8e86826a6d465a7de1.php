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
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/order.css">
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/iconfont/iconfont_public/iconfont.css">
</head>

<body>
    <div class="fanhui padding"><a href="javascript:history.back()"><span class="iconfont tb_fanhui"id="shangjia_info_fanhui">&#xe603;</span></a>订单详情</div>
    <a   href="<?php echo U('Goods/index',array('goods_id'=>$order['goods_id']));?>"><!--内容遍历-->
                <div class="order_row">
                <div class='td_l'>
                    <div class="picture"><img src="<?php echo ($order['goods_img']); ?>"></div>
                </div>
                <div class="td_r">
                    <div class="info_name shenglue"><?php echo ($order['goods_name']); ?></div>
                    <div class="info_name shenglue">商家：<?php echo ($order['shop_name']); ?></div>
                    <div class="info_name shenglue"><span>价格：&yen;<?php echo ($order['price']); ?> × <?php echo ($order['buy_number']); ?></span></div>
                    <div class='info_name'><span>应付：&yen;<?php echo ($order['dues']); ?></span></div>
                
                </div>
                </div>
    </a>
    <div class="view">
        <div class="d2">
            <div class="d2_title">订单信息</div>
            <div class="d2_content"><span>订单编号：<?php echo ($order['order_no']); ?></span> <span>创建时间：<?php echo (date('Y-m-d H：i',$order['created'])); ?> </span><span>收货地址：<?php echo ($address['location']); ?> <?php echo ($address['address']); ?></span><span>收货人：<?php echo ($address['name']); ?> <?php echo ($address['mobile']); ?></span></div>
            <div class="d2_title">商家信息</div>
            <div class="d2_content"><span>昵称：<?php echo ($order['shop_name']); ?></span> </div>
        </div>
        <div class="d2_title">订单状态</div>
        <div class="view_info">
            <?php if($order['deleted'] == '1'): ?><div>当前订单状态：<span class="red">该订单已被删除</span></div>
             <?php else: ?>   
                <div>当前订单状态：<span class="red"><?php echo order_status($order['pay_status'],$order['status'],$order['order_id'],$order['server_day'],$order['goods_id'])['status'];?></span></div>
                <?php if($order['status'] == '3'): ?><div>请收货后再点确认</div>
                    <div class="d1">
                        <a  href="<?php echo order_status($order['pay_status'],$order['status'],$order['order_id'],$order['tuan_no'])['status_url'];?>" class="button_a_order"><?php echo order_status($order['pay_status'],$order['status'],$order['order_id'],$order['tuan_no'])['status_button'];?></a>
                        <a  class="button_a_order"  href="<?php echo U('Order/view_kuaidi',array('order_id'=>$order['order_id']));?>">查看物流</a>
                    </div>
                <?php elseif(($order['pay_status'] == '0') and ($order['status'] < '6')): ?>
                    <div>请及时付款哦！</div>
                    <div class="d1">
                        <a  href="<?php echo order_status($order['pay_status'],$order['status'],$order['order_id'],$order['tuan_no'])['status_url'];?>" class="button_a_order"><?php echo order_status($order['pay_status'],$order['status'],$order['order_id'],$order['tuan_no'])['status_button'];?></a>
                        <a  class="button_a_order quxiao_order" name="<?php echo ($order['order_id']); ?>">取消订单</a>
                    </div>
                <?php elseif((($order['pay_status'] == '1') and ($order['status'] >= '4'))): ?>
                     <div class="d1">
                        <a  href="<?php echo order_status($order['pay_status'],$order['status'],$order['order_id'],$order['tuan_no'])['status_url'];?>" class="button_a_order"><?php echo order_status($order['pay_status'],$order['status'],$order['order_id'],$order['tuan_no'])['status_button'];?></a>
                        <a id='shouhou' class="button_a_order" name="<?php echo ($order['order_id']); ?>" href="<?php echo U('Order/shouhou');?>">申请售后</a>
                     </div>
                <?php else: ?>
                <div class="d1">
                    <a  href="<?php echo order_status($order['pay_status'],$order['status'],$order['order_id'],$order['tuan_no'])['status_url'];?>" class="button_a_order"><?php echo order_status($order['pay_status'],$order['status'],$order['order_id'],$order['tuan_no'])['status_button'];?></a>
                </div><?php endif; endif; ?>
        </div>
    </div>

   

<script type="text/javascript">
    $('.button_a_order:contains("去付款")').css('background-color','#D00');
    $('.button_a_order:contains("去付款")').css('color','#fff');
    $('.quxiao_order').bind('click',function(){
        if(confirm("确定要取消订单吗？")){
            var url='/Home/Order/quxiao_order.html';
            var data={
                    order_id:$(this).attr('name'),
                    check:"quxiao_order"
                }
            $.ajax({
                    type:'get',
                    async : false,
                    url:url,
                    data:data,
                    datatype:'json',
                    success:function(msg){
                        if(msg){ 
                            location=location;                        
                        }else{
                            alert('取消订单失败'); 
                        }
                    }
                });    
        }
    });
    $('.button_a_order:contains("删除订单")').bind('click',function(event){
        event.preventDefault();
        if(confirm("确定要删除订单吗？")){
            var url='/Home/Order/delete_order.html';
            var data={
                    order_id:$(this).attr('href'),
                    check:"delete_order"
                }
            $.ajax({
                    type:'get',
                    async : false,
                    url:url,
                    data:data,
                    datatype:'json',
                    success:function(msg){
                        if(msg){ 
                            location=location;                        
                        }else{
                            alert('删除订单失败'); 
                        }
                    }
                }); 
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