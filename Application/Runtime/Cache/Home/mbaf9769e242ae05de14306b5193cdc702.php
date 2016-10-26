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
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/order.css">
</head>

<body>
    <div class="fanhui padding"><a href="<?php echo U('Member/index');?>"><span class="iconfont tb_fanhui"id="shangjia_info_fanhui">&#xe603;</span></a>我的订单</div>
    <div class="dingdan">
        <div class='dingdan_4'>
            <ul>
                <li>
                    <a href="<?php echo U('Order/index');?>">
                    <div class='dingdan_fenkai_tb_div'>
                        <span class="iconfont tb_dingdan_li">&#xe625;</span>
                        <span style='margin-left: 2px;' class="right_up_tb"><?php echo ($status_count['all']); ?></span>
                    </div>
                    <div><span>全部</span></div>
                    </a>
                </li>
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
                <li>
                    <a href="<?php echo U('Order/index?status=shouhou');?>">
                    <div class='dingdan_fenkai_tb_div'>
                        <span class="iconfont tb_dingdan_li">&#xe62b;</span>
                        <span style='margin-left: 2px;' class="right_up_tb"><?php echo ($status_count['shouhou']); ?></span>
                    </div>
                    <div><span>售后退款</span></div>
                    </a>
                </li>
            </ul>
        </div>
    </div>


        
        
       
 
        
        
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a  href="<?php echo U('Order/view',array('order_id'=>$vo['order_id']));?>"><!--内容遍历-->
                <div class="order_row">
                <div class='td_l'>
                    <div class="picture"><img src="<?php echo ($vo['goods_img']); ?>"></div>
                </div>
                <div class="td_r">
                    <div class="info_name shenglue"><?php echo ($vo['goods_name']); ?></div>
                    <div class="info_name shenglue">商家：<?php echo ($vo['shop_name']); ?></div>
                    <?php if(($vo['tuan_no'] != 0) and ($vo['status'] == 1) and ($vo['pay_status'] == 1)): ?><div class="info_name shenglue">订单状态：还差 <span class="price_red"><?php echo ($vo['count']); ?></span> 人成团</div>
                    <?php else: ?>
                        <div class="info_name shenglue"> 订单状态：<?php echo order_status($vo['pay_status'],$vo['status'],$vo['order_id'],$vo['tuan_no'])['status'];?></div><?php endif; ?>
                    <div class='info_name'><span>价格：&yen;<?php echo ($vo['price']); ?></span><span style="margin-left: 20px;">应付：&yen;<?php echo ($vo['dues']); ?></span></div>
                </div>
                </div>
            </a>
            <div class='action'>
                    <a  href="<?php echo order_status($vo['pay_status'],$vo['status'],$vo['order_id'],$vo['tuan_no'])['status_url'];?>" class="button_a_order"><?php echo order_status($vo['pay_status'],$vo['status'],$vo['order_id'],$vo['tuan_no'])['status_button'];?></a>
                    <?php if(($vo['status'] >= '3') and ($vo['status'] <= '5') ): ?><a  class="button_a_order"  href="<?php echo U('Order/view_wuliu',array('order_id'=>$vo['order_id']));?>">查看物流</a><?php endif; ?>
                    <?php if(($vo['pay_status'] == '0') and ($vo['status'] < '6')): ?><a  class="button_a_order quxiao_order" name="<?php echo ($vo['order_id']); ?>">取消订单</a><?php endif; ?>
                    <?php if((($vo['pay_status'] == '1') and ($vo['status'] >= '4') and ($vo['status'] < '6'))): ?><a id='shouhou' class="button_a_order" name="<?php echo ($vo['order_id']); ?>" href="<?php echo U('Order/shouhou',array('order_id'=>$vo['order_id']));?>">申请售后</a><?php endif; ?>
                    <?php if(($vo['pay_status'] == '1') and ($vo['fenxiang'] == '0')): ?><a  class="button_a_order"  href="<?php echo U('Goods/fenxiang',array('order_id'=>$vo['order_id']));?>">分享返现</a><?php endif; ?>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
        
   
        
        
<div class="page_foot" style="margin-bottom: 50px;"><?php echo ($page_foot); ?></div>
        

<script type="text/javascript">
    $('.button_a_order:contains("去付款")').css('background-color','#D00');
    $('.button_a_order:contains("去付款")').css('color','#fff');
    var canshu="<?php echo ($canshu); ?>";
    if(canshu==='no_pay'){
        $('.dingdan_4>ul>li:eq(1)').css('background-color','#f90');
        $('.dingdan_4>ul>li:eq(1)>a>div').css('background-color','#f90');
        $('.dingdan_4>ul>li:eq(1) *').css('color','#fff');
    }else if(canshu==='daifahuo'){
        $('.dingdan_4>ul>li:eq(2)').css('background-color','#f90');
        $('.dingdan_4>ul>li:eq(2)>a>div').css('background-color','#f90');
        $('.dingdan_4>ul>li:eq(2) *').css('color','#fff');
    }else if(canshu==='daishouhuo'){
        $('.dingdan_4>ul>li:eq(3)').css('background-color','#f90');
        $('.dingdan_4>ul>li:eq(3)>a>div').css('background-color','#f90');
        $('.dingdan_4>ul>li:eq(3) *').css('color','#fff');
    }else if(canshu==='daipingjia'){
        $('.dingdan_4>ul>li:eq(4)').css('background-color','#f90');
        $('.dingdan_4>ul>li:eq(4)>a>div').css('background-color','#f90');
        $('.dingdan_4>ul>li:eq(4)').css('color','#fff');
    }else if(canshu==='shouhou'){
        $('.dingdan_4>ul>li:eq(5)').css('background-color','#f90');
        $('.dingdan_4>ul>li:eq(5)>a>div').css('background-color','#f90');
        $('.dingdan_4>ul>li:eq(5)').css('color','#fff');
    }else{
        $('.dingdan_4>ul>li:eq(0)').css('background-color','#f90');
        $('.dingdan_4>ul>li:eq(0)>a>div').css('background-color','#f90');
        $('.dingdan_4>ul>li:eq(0) *').css('color','#fff');
    }
    //确认收货
    $('.action>a:contains("确认收货")').bind('click',function(){
         if(confirm("确定已经收到商品了吗？")){
             return true;
         }else{
             return false;
         }
    });
    
    
    $('.quxiao_order').bind('click',function(){
        if(confirm("确定要取消订单吗？")){
            var url='/Home/Order/quxiao_order.html';
            var data={
                    order_id:$(this).attr('name'),
                    check:"quxiao_order"
                }
            $.ajax({
                    type:'post',
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
                };
            $.ajax({
                    type:'post',
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
    
    //催商家发货
    $('.action>a:contains("催商家发货")').bind('click',function(event){
         event.preventDefault();
         var url='/Home/Order/cuihuo.html';
         var data={
                order_id:$(this).attr('href'),
                check:"cuihuo"
            };
            $.ajax({
                type:'post',
                async : false,
                url:url,
                data:data,
                datatype:'json',
                success:function(msg){
                    if(msg){ 
                        if(msg=='亲，6小时内请勿重复催货'){
                            alert(msg);
                        }else{
                            alert('已催促商家'); 
                        }                      
                    }else{
                        alert('催促商家失败'); 
                    }
                }
            }); 
            
    });
</script>



  <div class="footer">
      <div class="ui-footer">
                  <a href="<?php echo U('Index/index');?>"><span class=" iconfont foot_home foot_tb">&#xe60f;</span><span>首页</span></a>
                  <a href="<?php echo U('Member/sellection');?>"><span class=" iconfont foot_shoucang foot_tb">&#xe620;</span><span>我的收藏</span></a>
                  <a href="<?php echo U('Order/index');?>"><span class="iconfont foot_pintuan foot_tb">&#xe622;</span><span>我的订单</span></a>
                  <a href="<?php echo U('Member/index');?>"><span class=" iconfont foot_wode foot_tb">&#xe60a;</span><span>会员中心</span></a>
          </div>
  </div> 



<script>
    var img="/Public/Home/Mobile/Images/public/jzpp_logo.jpg";
    var title="酱紫拼拼";
    var desc="搜尽娄底的美食美味，比美团更多的优惠，免费快递送货上门，快来一起拼团吧";
    var link='m.jiangzipinpin.com';
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
            title:  title, // 分享标题
            link: link, // 分享链接
            imgUrl: 'http://m.jiangzipinpin.com'+img // 分享图标
        });
        wx.onMenuShareAppMessage({
            title:  title, // 分享标题
            link: link, // 分享链接
            desc:  desc, // 分享描述
            imgUrl: 'http://m.jiangzipinpin.com'+img // 分享图标
        });
        wx.onMenuShareQQ({
            title:  title, // 分享标题
            link: link, // 分享链接
            desc: desc, // 分享描述
            imgUrl: 'http://m.jiangzipinpin.com'+img // 分享图标
        });
        wx.onMenuShareQZone({
            title: title, // 分享标题
            link: link, // 分享链接
            desc:desc, // 分享描述
            imgUrl:  'http://m.jiangzipinpin.com'+img // 分享图标
        });
    });
    
    

</script>
<?php require_once 'cs.php';echo '<img src="'._cnzzTrackPageView(1260248716).'" width="0" height="0"/>';?>
</body>
</html>