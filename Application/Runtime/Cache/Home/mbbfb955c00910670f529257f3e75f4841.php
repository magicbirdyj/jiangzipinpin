<?php if (!defined('THINK_PATH')) exit();?>
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

<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/public.css"/>
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/head.css"/>
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/footer_buy.css">

<script src="/Public/Common/Js/jquery.min.js"></script> 
<script src="/Public/Common/Js/function.js"></script>
<script src="/Public/Home/Mobile/Js/UC_jinzhisuofang.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<title><?php echo ($title); ?></title>


<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/iconfont/iconfont_guopin/iconfont.css">
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/lunbo.css">
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/goods.css">
</head>
<body>
    <div class="big_div">
    <div style="width:100%;background-color: #f0efed;" id="shop">
        <a href="javascript:history.back()" class="goods_fanhui iconfont tb_fanhui">&#xe61e;</a>
    <div class="lunbo_div" id="lunbo_div" >
          <?php if(is_array($img_qita)): $i = 0; $__LIST__ = $img_qita;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="javascript:void(0)"><img class="lunbo_img" src="<?php echo ($vo); ?>" /></a><?php endforeach; endif; else: echo "" ;endif; ?> 
          <?php if(is_array($img_qita)): $i = 0; $__LIST__ = $img_qita;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="javascript:void(0)"><img class="lunbo_img" src="<?php echo ($vo); ?>" /></a><?php endforeach; endif; else: echo "" ;endif; ?> 


      </div>
    
      <div class="choose">
          <div class="choose_div">
          </div>
      </div>
    <div class="titile"><?php echo ($goods['goods_name']); ?></div>
    <div class="title1_1"><?php echo ($goods['goods_jianjie']); ?></div>
    <div class="price">
        <div class="price_l">
            <strong class="sprice_strong strong_color"><?php echo ($goods['tuan_price']); ?></strong>
            <span class="strong_color" style="margin-left: -6px;">元</span>
            <del style="letter-spacing: -1px;">原价:<?php echo ($goods['yuan_price']); ?>元</del>
        </div>
        <div class="price_r">
            <?php if($goods['1yuangou'] == '1'): ?><span class="daijinquan" style="margin-left: 5px;">1元购</span><?php endif; ?>
                <?php if($goods['choujiang'] == '1'): ?><span class="daijinquan">抽奖</span><?php endif; ?>
        </div>
    </div>
    
    <div class="about">
        <div>已售：<span><?php echo ($goods['buy_number']); ?></span></div>
        <div><a class="maodian_pingjia" href="<?php echo U('Goods/index',array('goods_id'=>$goods['goods_id'])).'#maodian_pingjia';?>"><span><?php echo ($goods['score']); ?></span>分</a></div>
        <div id="pingjia"><a class="maodian_pingjia" href="<?php echo U('Goods/index',array('goods_id'=>$goods['goods_id'])).'#maodian_pingjia';?>"><span><?php echo ($goods['comment_number']); ?></span>人评价</a></div>
    </div>
    <div class="jianjie" >
        <div class="sjcn">果果承诺</div>
         <div class="chengnuo_content">
             <a href="<?php echo U('Company/index','name=shuangbeipeifu');?>">
             <i class="peifu"></i>
             坏果包赔
             </a>
             <a href="<?php echo U('Company/index','name=suishitui');?>">
             <i class="tui"></i>
             不满意退
             </a>
             <a href="<?php echo U('Company/index','name=baozhengjin');?>" style="margin-right: 0px;">
                 <i class="baozhengjin">
                     保
                 </i>
                 保证新鲜
             </a>
         </div>
    </div>
    
    <?php if($zx_shuxing != null): ?><div class="padding" id="xuanze" style="margin-bottom: 10px;">
        <span style="line-height: 23px;" id="zx_shuxing">选择<?php if(is_array($zx_shuxing)): $i = 0; $__LIST__ = $zx_shuxing;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; echo ($key); ?>&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>： </span>
        <span class="jiantou_r iconfont">&#xe604;</span>
    </div><?php endif; ?>
    
    <div style="padding: 7px 10px;font-size: 14px; margin-bottom: 10px;">支付开团并邀请 <?php echo ($goods['tuan_number']-1); ?> 人开团，人数不足自动退款</div>
    <?php if($goods_tuan != NULL): ?><div style="padding: 10px 10px;font-size: 14px;background-color: #f0f0f0;">以下小伙伴正在发起团购，您可以直接参与</div>
    <div class="all_pintuan">
        <ul>
            <?php if(is_array($goods_tuan)): $i = 0; $__LIST__ = $goods_tuan;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                <a href='<?php echo U("Goods/pintuan_info",array("tuan_no"=>$vo["tuan_no"]));?>'>
                <div class="div_0">
                <img src="<?php echo ($vo['head_url']); ?>" />
                <div class="div0_1">
                    <div style="margin-bottom: 5px;" class="shenglue"><?php echo ($vo['user_name']); ?></div>
                    <div class="shenglue"><?php echo get_address_city(get_order_address($vo['address'],$vo['order_address'])['location']);?></div>
                </div>
                <div class="div0_2">
                    <div style="margin-bottom: 5px;" class='price_red'>还差<?php echo ($vo['count']); ?>人成团</div>
                    <div>剩余<span id='hours_<?php echo ($i); ?>'>24</span>:<span id='minutes_<?php echo ($i); ?>'>60</span>:<span id='seconds_<?php echo ($i); ?>'>60</span>结束</div>
                </div>
                </div>
                <div class="div1">
                    去参团
                </div>
                </a>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div><?php endif; ?>
    <div class="padding" style="margin-bottom: 1px;">
        <span class="float_l" style="line-height: 33px;">评分：</span>
        <ul class="dianpujieshao_pingfen float_r">
             <li>
                 <div>描述</div>
                 <div class="pingfen_jt"><?php echo ($pingfen_fl[0]); ?></div>
             </li>
             <li>
                 <div>服务</div>
                 <div class="pingfen_jt"><?php echo ($pingfen_fl[1]); ?></div>
             </li>
             <li style="border-right: none;">
                 <div>专业</div>
                 <div  class="pingfen_jt"><?php echo ($pingfen_fl[2]); ?></div>
             </li>
         </ul>
    </div>
    
    
    <a name="shop_a" id="shop_a" style="height: 0px;position:absolute;">&nbsp;</a>
    <div class="shop_div">
    <div class="content_title"><ul>
            <li class="spxq">服务详情</li>
            <li class="ljpj">累计评价</li>
        </ul></div>
    <div id="spxq">
    <div class="goods_shuxing">
        <div>商家：<?php echo ($goods['user_name']); ?></div>
        <div class="shuxing_title">产品属性：</div>
        <div>
        <ul>
            <?php if(is_array($shuxing)): $i = 0; $__LIST__ = $shuxing;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><?php echo ($key); ?> ：<?php echo ($vo); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        </div>
    </div>
    <div class="goodscontent"><?php echo ($goods['goods_desc']); ?></div>
    </div>
    <div class="pinglun">
        <div class="zhengtifenshu">
            <div>
            <span class="zhengtipingjia">整体评价:</span>
            <span class="score"><?php echo ($goods['score']); ?></span><span class="fen">分</span>
            </div>
            <div style="margin-top: 10px;">
            <span class="shopping_pingjia"><span class="pingjia_limian" style="width: <?php echo (xingxing_baifenbi($goods['score'])); ?>;"></span></span>共<strong><?php echo ($goods['comment_number']); ?></strong>人评价
            </div>
        </div>
        <div class="leijipinglun">
            <ul id='leijipinglun'>
            </ul>

            <div class="page_foot" id='page_foot_pinglun'></div>
        </div>
    </div>
    </div>
     
    </div>
       
        
        
  
        </div>
        <form name="kaituan_buy" action="<?php echo U('Goods/kaituan_buy');?>" method="get">
            <input name="goods_id" type="hidden" value="<?php echo ($goods_id); ?>" />
            <?php if($zx_shuxing != false): ?><input name="zx_shuxing" type="hidden" value="" /><?php endif; ?>
        </form>
        <form name="dandu_buy" action="<?php echo U('Goods/dandu_buy');?>" method="get" data-ajax="false">
            <input name="goods_id" type="hidden" value="<?php echo ($goods_id); ?>" />
            <?php if($zx_shuxing != false): ?><input name="zx_shuxing" type="hidden" value="" /><?php endif; ?>
        </form>

        
        
       
    
    <?php if($zx_shuxing != null): ?><div id="overlay"></div><!--遮罩层div-->
    <div id="div_xuanze">
        <div class="fanhui padding"><span class="iconfont tb_fanhui" id="xuanze_fanhui">&#xe62d;</span>选择属性</div>
        <div class="order_row">
                <div class='td_l'>
                    <div class="picture"><img src="<?php echo ($goods['goods_img']); ?>"></div>
                </div>
                <div class="td_r">
                    <div class="info_name shenglue"><?php echo ($goods['goods_name']); ?></div>
                    <div class="info_name shenglue" id="yixuan">已选：</div>
                </div>
        </div>
        <?php if(is_array($zx_shuxing)): $i = 0; $__LIST__ = $zx_shuxing;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="zx_shuxing border-bottom">
            <div class="zx_shuxing_title"><?php echo ($key); ?></div>
            <ul class="zx_shuxing_ul">
                <?php if(is_array($vo)): $i = 0; $__LIST__ = $vo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$shuxingzhi): $mod = ($i % 2 );++$i;?><li><?php echo ($shuxingzhi); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div><?php endif; ?>
<script src="/Public/Home/Mobile/Js/goods_lunbo.js" type="text/javascript"></script>
<script src="/Public/Home/Mobile/Js/goods.js" type="text/javascript"></script>




  <div class="footer">
      <div class="ui-footer">
          <a href="<?php echo U('Index/index');?>" class="xiao_a"><span class=" iconfont foot_home foot_tb">&#xe60f;</span><span>首页</span></a>
                  <?php if($is_sellect == null): ?><a href="javascript:void(0)" id='shoucang' class="xiao_a"><span class=" iconfont foot_shoucang foot_tb">&#xe620;</span><span>收藏</span></a>
                  <?php else: ?>
                  <a href="javascript:void(0)" id='yishoucang' class="xiao_a"><span class=" iconfont foot_shoucang foot_tb" style="color:#f90">&#xe620;</span><span>已收藏</span></a><?php endif; ?>
                  <a href="<?php echo U('Member/kefu');?>" class="xiao_a" style="border-right: none" id='kefu'><span class=" iconfont foot_home foot_tb">&#xe60b;</span><span>客服</span></a>
                  <a href="javascript:void(0)"  class="back_color_gwc" id='dandu_buy'><span class="foot_buy foot_tb">&yen;<?php echo ($goods['price']); ?></span><span class="color_FFF">单独购买</span></a>
                  <a href="javascript:void(0)" class="back_color_buy" id="kaituan_buy"><span class="foot_buy foot_tb">&yen;<?php echo ($goods['tuan_price']); ?></span><span class="color_FFF"><?php echo ($goods['tuan_number']); ?>人团</span></a>
          </div>
  </div> 


<script src="/Public/Home/Mobile/Js/foot_buy.js" type="text/javascript"></script>
<script src="/Public/Home/Mobile/Js/new_order.js" type="text/javascript"></script>

<?php if($goods_tuan != NULL): ?><script>
    ///倒计时
    var timestamp = (Date.parse(new Date()))/1000;
    <?php if(is_array($goods_tuan)): $i = 0; $__LIST__ = $goods_tuan;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>var created_<?php echo ($i); ?>=<?php echo ($vo['created']); ?>+86400;
    var  maxtime_<?php echo ($i); ?> = created_<?php echo ($i); ?>-timestamp;
    var timer_<?php echo ($i); ?> = setInterval("CountDown(maxtime_<?php echo ($i); ?>,'hours_<?php echo ($i); ?>','minutes_<?php echo ($i); ?>','seconds_<?php echo ($i); ?>')",1000);<?php endforeach; endif; else: echo "" ;endif; ?>
function CountDown(maxtime,id_hours,id_minutes,id_seconds){   
    if(maxtime>=0){
        hours=(Math.floor((maxtime/60)/60)<10?'0'+Math.floor((maxtime/60)/60):Math.floor((maxtime/60)/60));
        minutes =  (Math.floor((maxtime/60)%60)<10?'0'+Math.floor((maxtime/60)%60):Math.floor((maxtime/60)%60));
        seconds = (Math.floor(maxtime%60)<10?'0'+Math.floor(maxtime%60):Math.floor(maxtime%60)); 
        $('#'+id_hours).html(hours);
        $('#'+id_minutes).html(minutes);
        $('#'+id_seconds).html(seconds);
        if(maxtime==maxtime_1){
            maxtime_1--;
        }else{
            maxtime_2--;
        }
    }else{
        if(maxtime==maxtime_1){
            clearInterval(timer_1);
        }else{
            clearInterval(timer_2);
        }
        document.URL=location.href;
    }
};
</script><?php endif; ?>
<script>
    var img=$('#lunbo_div img:first').attr('src');
    var title=$('.titile1').html();
    var price=$('.sprice_strong').html();
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
            title:  '一起网，您的婚礼专家： '+title, // 分享标题
            imgUrl: 'www.17each.com'+img // 分享图标
        });
        wx.onMenuShareAppMessage({
            title:  '一起网，您的婚礼专家： '+title, // 分享标题
            desc:  '要“17”，不要“each”，节省50%费用，拥有梦幻婚礼不再是梦,'+'17价格：￥'+price, // 分享描述
            imgUrl: 'www.17each.com'+img // 分享图标
        });
        wx.onMenuShareQQ({
            title:  '一起网，您的婚礼专家： '+title, // 分享标题
            desc: '要“17”，不要“each”，节省50%费用，拥有梦幻婚礼不再是梦,'+'17价格：￥'+price, // 分享描述
            imgUrl: 'www.17each.com'+img // 分享图标
        });
        wx.onMenuShareQZone({
            title: '一起网，您的婚礼专家： '+title, // 分享标题
            desc: '要“17”，不要“each”，节省50%费用，拥有梦幻婚礼不再是梦,'+'17价格：￥'+price, // 分享描述
            imgUrl:  'www.17each.com'+img // 分享图标
        });
    });
    
    

</script>
</body>
</html>