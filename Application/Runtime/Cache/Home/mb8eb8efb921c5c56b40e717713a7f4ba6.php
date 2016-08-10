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


 
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/category.css">
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/index.css">
<link rel="stylesheet" type="text/css" href="/Public/Home/Mobile/Css/search_m.css">
<title>一起网_分类商品</title>
</head>
<body>
    <div class="min_menu shareBtn" id='sousou'>
    <span class="iconfont tb_fenxiang"id="sousou" style='font-size: 22px'>&#xe60d;</span>
    <span class="fenxiang">搜索</span>
    </div>
    <div class="fanhui padding"><a href="<?php echo U('index/index');?>"><span class="iconfont tb_fanhui"id="shangjia_info_fanhui">&#xe603;</span></a>分类</div>
<div class="box">

    <div class="fenlei_menu" id="fenlei_menu">
        <ul id='menu_ul'>
            <li style="border-left: none;" id="fenlei_li"><?php echo ($cat_name); ?><span class="iconfont tb_jiantou_xia" >&#xe602;</span></li>
            <li id="didian_li"><?php echo ($get['tuan_number']?$get['tuan_number']:'全部'); ?><span class="iconfont tb_jiantou_xia" >&#xe602;</span></li>
            <li id='paixu_li'><a1 id='paixu_li_span'>默认排序</a1><span class="iconfont tb_jiantou_xia" >&#xe602;</span></li>
            <li id='shaixuan_li'>筛选<span class="iconfont tb_jiantou_xia" >&#xe602;</span></li>
        </ul>
        
    </div>
    <div class="fenlei_select none" id="fenlei_select">
        <ul>
            <?php if(is_array($cat_allname)): $i = 0; $__LIST__ = $cat_allname;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Category/index',array('cid'=>$vo['cat_id']));?>"><?php echo ($vo['cat_name']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
    <div class="fenlei_select none" id="didian_select">
            <ul>
                <li><a href="<?php echo str_replace('/tuan_number/'.urlencode($get['tuan_number']),'',$url['full']);?>">全部</a></li>
                <li><a href="<?php echo U(change_url_canshu($url['full'],'tuan_number','2'));?>">2人团</a></li>
                <li><a href="<?php echo U(change_url_canshu($url['full'],'tuan_number','5'));?>">5人团</a></li>
                <li><a href="<?php echo U(change_url_canshu($url['full'],'tuan_number','10'));?>">10人团</a></li>
            </ul>
    </div>
    <div class="fenlei_select none" id="paixu_select">
            <ul>
                <li id="moren"><a href="<?php echo U('Category/index',$get_cs['order_moren']);?>">默认排序</a></li>
                <li id="number"><a href="<?php echo U('Category/index', $get_cs['order_xiaoliang']);?>">销量最高</a></li>
                <li id="price"><a href="<?php echo U('Category/index', $get_cs['order_price_asc']);?>">价格最低</a></li>
                <li id="price"><a href="<?php echo U('Category/index', $get_cs['order_price_desc']);?>">价格最高</a></li>
                <li id="pinglun"><a href="<?php echo U('Category/index', $get_cs['order_pinglun']);?>">评价最高</a></li>
                <li id="update"><a href="<?php echo U('Category/index', $get_cs['order_update']);?>">最新发布</a></li>
            </ul>
    </div>
    <div class="fenlei_select none" id="shaixuan_select">
            <div  id="daijinquan">
                <span>代金券</span>
                <span class="icon_check"></span>
            </div>
           
            <?php if(is_array($arr_shuxing0)): $i = 0; $__LIST__ = $arr_shuxing0;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$first): $mod = ($i % 2 );++$i;?><div>
                <span class="name"><?php echo ($key); ?></span><span>：</span>
                <ul class="xuanxiang">
                    <?php if(is_array($first)): foreach($first as $k=>$value): ?><li><?php echo ($value); ?></li><?php endforeach; endif; ?>
                </ul>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
        
        <div class="queding_div">
            <div class="shaixuan_button chongzhi" id="chongzhi">重置</div>
            <div class="shaixuan_button queding" id="queding">确定</div>
        </div>
    </div>
    
    
    
    



    
    
    <?php if(is_array($list_iphone)): $i = 0; $__LIST__ = $list_iphone;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><!--格子显示商品 一行2个
 <div class="shopping">
        <a target="_blank" href="<?php echo U('Goods/index',array('goods_id'=>$vo['goods_id']));?>" style="display: block;">
    <div class="shopping_img"><img src="<?php echo ($vo['goods_img']); ?>"/></div>
    <div class="shopping_title"><?php echo ($vo['goods_name']); ?></div>
    <div class="shopping_pricepj">
    <div class="shopping_price">&yen;<?php echo ($vo['price']); ?><span class="yuan_price">门店价 <del>&yen;<?php echo (floor($vo['yuan_price'])); ?></del></span></div>
    </div>
    <div class="pingjia_div">
        <div class="shopping_sale">已售 <?php echo ($vo['buy_number']); ?></div>
        <div class="shopping_pjrenshu"><?php echo ($vo['comment_number']); ?>人评价</div>
    </div>
    </a>
    </div>--><!--商品1-->
        
        <div class="shopping">
                <a  href="<?php echo U('Goods/index',array('goods_id'=>$vo['goods_id']));?>" class="goods_a">
                    <img src="<?php echo ($vo['goods_img_qita_0']); ?>" class="goods_img"/>
                    <div class="goods_infor">
                    <div class="goods_title shenglue border-bottom"><?php echo ($vo['goods_name']); ?></div>
                    <div class="goods_bottom">
                        <div class="goods_infor_left">
                            <span class="iconfont">&#xe61d;</span>
                            <span><?php echo ($vo['tuan_number']); ?>人团</span>
                            <span class="price_red price"><?php echo (floor($vo['tuan_price'])); ?></span>
                            <span class="price_red">元</span>
                            <del style="margin-left: 5px;">单买价：<?php echo (floor($vo['price'])); ?>元</del>
                        </div>
                        <div class="goods_infor_right">
                            <span>已售：<?php echo ($vo['buy_number']); ?></span>
                        </div>
                    </div>
                    </div>
                </a>
            </div><!--商品1--><?php endforeach; endif; else: echo "" ;endif; ?>
    
<div class="page_foot"><?php echo ($page_foot_iphone); ?></div>


</div><!--主内容盒子-->

<div id="overlay"></div><!--遮罩层div-->



<script src="/Public/Home/Mobile/Js/category.js" type="text/javascript"></script>




<script  type="text/javascript">
    var url=decodeURI("<?php echo ($url['url']); ?>");
//选中的分类 背景更暗
$('#fenlei_select a:contains("<?php echo ($cat_name); ?>")').parent().css('background-color','#f6f4f0');
var location_1="<?php echo ($get['tuan']?$get['tuan']:'全部'); ?>";
$('#didian_select a:contains('+location_1+')').parent().css('background-color','#f6f4f0');
//选中的排序 背景更暗
    var order = "<?php echo ($get['order']); ?>";
    var order_name;
    if(order===''){
        order_name='默认排序';
        $('#paixu_select a:contains("默认排序")').parent().css('background-color','#f6f4f0');
    }else if(order==='number_desc'){
        order_name='销量最高';
        $('#paixu_select a:contains("销量最高")').parent().css('background-color','#f6f4f0');
    }else if(order==='price_desc'){
        order_name='价格最高';
        $('#paixu_select a:contains("价格最高")').parent().css('background-color','#f6f4f0');
    }else if(order==='price_asc'){
        order_name='价格最低';
        $('#paixu_select a:contains("价格最低")').parent().css('background-color','#f6f4f0');
    }else if(order==='pinglun_desc'){
        order_name='评价最高';
        $('#paixu_select a:contains("评价最高")').parent().css('background-color','#f6f4f0');
    }else if(order==='update_desc'){
        order_name='最新发布';
        $('#paixu_select a:contains("最新发布")').parent().css('background-color','#f6f4f0');
    };
    $('#paixu_li_span').html(order_name);

//筛选JS
//根据url 把筛选匹配
//匹配打勾的选项
var daijinquan="<?php echo ($get['daijinquan']); ?>";

if(daijinquan==='1'){
    $('#daijinquan').children('.icon_check').css('background-position','-435px -151px');
}


//匹配属性
<?php if(is_array($shuxing)): $i = 0; $__LIST__ = $shuxing;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>var shuxing_name="<?php echo ($vo); ?>";
    var arr_shuxing_name=shuxing_name.split('-');
    $('.xuanxiang>li').filter(function(){return $(this).parent('.xuanxiang').prev().prev().text()===arr_shuxing_name[0]&&$(this).text()===arr_shuxing_name[1]}).css('background-color','#06c1ae');
    $('.xuanxiang>li').filter(function(){return $(this).parent('.xuanxiang').prev().prev().text()===arr_shuxing_name[0]&&$(this).text()===arr_shuxing_name[1]}).css('color','#FFF');<?php endforeach; endif; else: echo "" ;endif; ?>








//打勾的选项 
$('#daijinquan').bind('click',function(){
    dagou($(this),'daijinquan');
});

 

//
$('.xuanxiang>li').bind('click',function(){
    xuanzhong_shuxing($(this));
});






$('#chongzhi').bind('click',function(){
    url=clear_url_canshu(url,'daijinquan');
    url=clear_url_canshu(url,'shuxing');
    $('#daijinquan').children('.icon_check').css('background-position','-435px -128px');
    $('.xuanxiang_r>li').css('background-color','#f2f2f2');
    $('.xuanxiang_r>li').css('color','#999');
    $('.xuanxiang>li').css('background-color','#f2f2f2');
    $('.xuanxiang>li').css('color','#999');
});
$('#queding').bind('click',function(){
    var url_full=url+'.html';
    window.location.href=url_full; 
});





function xuanzhong_shuxing(obj){
    var name=obj.parent('.xuanxiang').prev().prev().text();
    var value=obj.text();
    if(rgb2hex(obj.css('background-color'))==='#f2f2f2'){
        url=change_url_shuxing(url,name,value);
        obj.siblings().css('background-color','#f2f2f2');
        obj.siblings().css('color','#999');
        obj.css('background-color','#06c1ae');
        obj.css('color','#FFF');
    }else{
        url=clear_url_shuxing(url,name,value);
        obj.css('background-color','#f2f2f2');
        obj.css('color','#999');
    }
}
function dagou(obj,canshu){
    if(obj.children('.icon_check').css('background-position')==='-435px -128px'){
        url=change_url_canshu(url,canshu,'1');
        obj.children('.icon_check').css('background-position','-435px -151px');
    }else{
        url=clear_url_canshu(url,canshu);
        obj.children('.icon_check').css('background-position','-435px -128px');
    }
}
function rgb2hex(rgb) {
rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
function hex(x) {
return ("0" + parseInt(x).toString(16)).slice(-2);
}
return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}




//搜索按钮
$('#sousou').bind('click',function(){
    window.location.href="<?php echo U('Index/search_m');?>"; 
});
</script>
  <div class="footer">
      <div class="ui-footer">
                  <a href="<?php echo U('Index/index');?>"><span class=" iconfont foot_home foot_tb">&#xe60f;</span><span>首页</span></a>
                  <a href="<?php echo U('Member/hunlirenshangjiaxinxi');?>"><span class=" iconfont foot_shoucang foot_tb">&#xe620;</span><span>我的收藏</span></a>
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