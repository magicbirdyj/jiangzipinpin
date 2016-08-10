// JavaScript Document

    $('.datouxiang_div>.datouxiang').each(function(i,item){
        if($(item).height()<300){
            $(item).css('height','300px');
            $(item).css('width','auto');
        }
    });
    $('.xiaotouxiang img').each(function(i,item){
        if($(item).height()<68){
            $(item).css('height','68px');
            $(item).css('width','auto');
        }
    });
    
    //网页一开始就需要获取其它商品ajax信息
    var url_y=window.location.href;
    var url=url_y.replace('index','page');
    //if(url.lastIndexOf('/p/')!==-1){
        //url=url.substring(0,url.indexOf('/p/'))+'.html';
    //}
    $.ajax({
            type:'post',
            async : true,
            url:url,
            datatype:'json',
            success:function(msg){
                var str="";
                $(msg.li).each(function(i,item){
                    str+='<li class="other_goods"> ';
                    str+='<a href="/Home/Goods/index/goods_id/'+item.goods_id+'.html" class="other_a">';
                    str+='<span class="span1">['+item.cat_name+']'+item.goods_name+'</span>';
                    str+='<span class="span2 hlljg">&yen; '+item.price+'</span><span class="span2 mdj">&yen; '+item.yuan_price+'</span><span class="span2 ys">'+item.buy_number+'</span>';
                    str+='</a></li>';
                });
                
                
                
                $('#div_li').html(str);
                $('#page_foot_1').html(msg.page_foot);
            }
        });
    
    //动态生成的必须用$('body').on('click','.num',function()｛｝）添加事件
$('body').on('click','.other .page_foot a',function(event){
    event.preventDefault();
    var url=$(this).attr('href');
    $.ajax({
            type:'post',
            async : true,
            url:url,
            datatype:'json',
            success:function(msg){
                var str='';
                $(msg.li).each(function(i,item){
                    str+='<li class="other_goods"> ';
                    str+='<a href="/Home/Goods/index/goods_id/'+item.goods_id+'.html" class="other_a">';
                    str+='<span class="span1">['+item.cat_name+']'+item.goods_name+'</span>';
                    str+='<span class="span2 hlljg">&yen; '+item.price+'</span><span class="span2 mdj">&yen; '+item.yuan_price+'</span><span class="span2 ys">'+item.buy_number+'</span>';
                    str+='</a></li>';
                });
                
                
                $('#div_li').html(str);
                $('#page_foot_1').html(msg.page_foot);
            }
        });
    });

//鼠标放到小头像，大头像变化
$('.xiaotouxiang img').bind('mouseover',function(){
    var img_src=$(this).attr('src');
    $('.datouxiang').attr('src',img_src);
});

//鼠标放到大头像，再放大图片
$('.datouxiang_div').bind('mouseover',function(){
    var img_src=$('.datouxiang').attr('src');
    $('.datouxiang_fangda').css('background-image','url('+img_src+')');
    var image=new Image();
    image.src=img_src;
    image.onload=function(){
        var w_bi_h=image.width/image.height;
        if(w_bi_h>1.5){
            $('.datouxiang_fangda').css('background-size','auto 600px');
        }else{
            $('.datouxiang_fangda').css('background-size','900px auto');
        }
    };
    
});
$('.datouxiang_div').bind('mousemove',function(e){
    $('.huise_gezi').css('display','block');
    var X = $('.datouxiang_div').offset().left;
    var Y = $('.datouxiang_div').offset().top;
    var xx=e.pageX;
    var yy=e.pageY;
    var xd_x=xx-X;
    var xd_y=yy-Y;
    var pos_x,pos_y;
    if(xd_x<113){
        $('.huise_gezi').css('left','0px');
        pos_x='0px';
    }else if(xd_x>337){
        $('.huise_gezi').css('left','225px');
        pos_x='-450px';
    }else{
        $('.huise_gezi').css('left',xd_x-112);
        pos_x=(-(xd_x-112)*2)+'px';
    }
    if(xd_y<75){
        $('.huise_gezi').css('top','0px');
        pos_y='0px';
    }else if(xd_y>225){
        $('.huise_gezi').css('top','150px');
        pos_y='-300px';
    }else{
        $('.huise_gezi').css('top',xd_y-75);
        pos_y=(-(xd_y-75)*2)+'px';
    }

    $('.datouxiang_fangda').css('display','block');
    $('.datouxiang_fangda').css('background-position',pos_x+' '+pos_y);
});
$('.datouxiang_div').bind('mouseout',function(){
    $('.datouxiang_fangda').css('display','none');
    $('.huise_gezi').css('display','none');
    });


//日历增加自己的JS功能
//让选择div移动到鼠标位置
$('body').on('click','#dateSelectionRili',function(e){
    var xx=e.pageX+10;
    var yy=e.pageY+10;
    $('#dateSelectionDiv').css({top: yy, left: xx});
});
//获取选择的日期
//$('body').unon('click','#tt td');
//$('body').on('click','#tt td'.bin,function(){
    //var year=$('#nian').html();
    //var month=$('#yue').html();
    //var day=$(this).children('font').html();
//});

//显示遮罩层
function showOverlay(id) {
    $("#overlay").height(pageHeight());
    $("#overlay").width(pageWidth());

    // fadeTo第一个参数为速度，第二个为透明度
    // 多重方式控制透明度，保证兼容性，但也带来修改麻烦的问题
    $("#overlay").fadeTo(200, 0.3);
    $("#"+id).css('display','block');
    adjust("#"+id);
}

/* 隐藏覆盖层 */
function hideOverlay(id) {
    $("#overlay").fadeOut(200);
    $('#'+id).css('display','none');
}

/* 当前页面高度 */
function pageHeight() {
    return document.body.scrollHeight;
}

/* 当前页面宽度 */
function pageWidth() {
    return document.body.scrollWidth;
}

/* 关闭登录页面 */
$('#mini_close').bind('click',function(){
    var url=window.location.href;
    $.ajax({
        type:'post',
        url:url,
        datatype:'json'
    });
    hideOverlay('mini_login');
});
/* 关闭购物车页面 */
$('#gouwuche_guanbi').bind('click',function(){
    hideOverlay('gouwuche_join');
});
/*点击加入购物车成功后的继续浏览*/
$('#gouwuche_jxll').bind('click',function(){
    hideOverlay('gouwuche_join');
});
/* 关闭收藏页面 */
$('#shoucang_guanbi').bind('click',function(){
    hideOverlay('shoucang_join');
});
/*点击加入收藏成功后的继续浏览*/
$('#shoucang_jxll').bind('click',function(){
    hideOverlay('shoucang_join');
});

/* 定位到页面中心 */
function adjust(id) {
    var w = $(id).width();
    var h = $(id).height();
    
    var t = scrollY() + (windowHeight()/2) - (h/2);
    if(t < 0) t = 0;
    
    var l = scrollX() + (windowWidth()/2) - (w/2);
    if(l < 0) l = 0;
    
    $(id).css({left: l+'px', top: t+'px'});
}

//浏览器视口的高度
function windowHeight() {
    var de = document.documentElement;

    return self.innerHeight || (de && de.clientHeight) || document.body.clientHeight;
}

//浏览器视口的宽度
function windowWidth() {
    var de = document.documentElement;

    return self.innerWidth || (de && de.clientWidth) || document.body.clientWidth
}

/* 浏览器垂直滚动位置 */
function scrollY() {
    var de = document.documentElement;

    return self.pageYOffset || (de && de.scrollTop) || document.body.scrollTop;
}

/* 浏览器水平滚动位置 */
function scrollX() {
    var de = document.documentElement;

    return self.pageXOffset || (de && de.scrollLeft) || document.body.scrollLeft;
}

//滚动条滚动事件绑定
$(window).bind('scroll',function(){
    if($("#mini_login").css('display')!='none'){
        adjust("#mini_login");
    }
    if($("#gouwuche_join").css('display')!='none'){
        adjust("#gouwuche_join");
    }
    if($("#fenxiang_qq_div").css('display')!='none'){
        adjust("#fenxiang_qq_div");
    }
});
/* 关闭提示选择日期div */
$('#tishi_close').bind('click',function(){
    $('#buy').css('display','block');
    $('#buy_clone').css('display','none');
});

//选择日期 关闭提示选择日期
$('body').on('click','#tt>td',function(){
    $('#buy').css('display','block');
    $('#buy_clone').css('display','none');
});
//鼠标移动到日期 变手形，边框变红
$('body').on('mouseover','#tt>td',function(){
    $(this).children('font').css('color','red');
});
$('body').on('mouseout','#tt>td',function(){
    $(this).children('font').css('color','#666');
});

//评论区的图片 宽度高度适应100*100 等比例。
$('.pinglun_img img').each(function(i,item){
        if($(item).height()<100){
            $(item).css('height','100px');
            $(item).css('width','auto');
        }
    });

//商品详情和累计评论变换
$('.spxq').bind('click',function(){
    $('.pinglun').css('display','none');
    $('#spxq').css('display','block');
    $('.spxq').css('background-color','#FFF');
    $('.ljpj').css('background-color','#F6F6F6');
});
$('.ljpj').bind('click',function(){
    $('#spxq').css('display','none');
    $('.pinglun').css('display','block');
    $('.ljpj').css('background-color','#FFF');
    $('.spxq').css('background-color','#F6F6F6');
});

    
//如果url存在maodian_pingjia那么显示评价
var url_dangqian=window.location.href;
if(url_dangqian.lastIndexOf('#maodian_pingjia')!='-1'||url_dangqian.lastIndexOf('/p/')!='-1'){
    $('#spxq').css('display','none');
    $('.pinglun').css('display','block');
    $('.ljpj').css('background-color','#FFF');
    $('.spxq').css('background-color','#F6F6F6');
}

//商品页面内的maodian_pingjia点击显示评价
$('.maodian_pingjia').bind('click',function(){
    $('#spxq').css('display','none');
    $('.pinglun').css('display','block');
    $('.ljpj').css('background-color','#FFF');
    $('.spxq').css('background-color','#F6F6F6');
});

//网页一开始就需要获取累计评论ajax信息
    var url_pinglun=url_y.replace('index','pinglun');
    $.ajax({
            type:'post',
            async : true,
            url:url_pinglun,
            datatype:'json',
            success:function(msg){
                var str="";
                $(msg.li).each(function(i,item){
                    var newtime=new Date(item.updated*1000);  
                    str+='<li><div class="pinglun_left"><img src="'+item.head_url+'" class="img"><p class="user_name">'+item.user_name+'</p></div>';
                    str+='<div class="pinglun_right"><div class="xingxing_div"><span class="pingjia_xiao"><span class="pingjia_xiao_limian" style="width:'+xingxing_baifenbi(item.score)+';"></span></span>';
                    str+='<span>'+newtime.getFullYear()+'-'+newtime.getMonth()+'-'+newtime.getDate()+'&nbsp;&nbsp;&nbsp;&nbsp;'+newtime.toLocaleTimeString()+'</span></div><div class="pinglun_text">'+item.appraise+'</div><div class="pinglun_img">';
                    $(item.appraise_img).each(function(i1,item1){
                        str+='<a><img src="'+item1+'" /></a>';
                    });
                    str+='</div></div></li>';
                });
                
                
                
                $('#leijipinglun').html(str);
                    $('#page_foot_pinglun').html(msg.page_foot);
            }
        });
        
//动态生成的必须用$('body').on('click','.num',function()｛｝）添加事件
$('body').on('click','#page_foot_pinglun a',function(event){
    event.preventDefault();
    var url=$(this).attr('href');
    $.ajax({
            type:'post',
            async : true,
            url:url,
            datatype:'json',
            success:function(msg){
                var str='';
                $(msg.li).each(function(i,item){
                    var newtime=new Date(item.updated*1000); 
                    str+='<li><div class="pinglun_left"><img src="'+item.head_url+'" class="img"><p class="user_name">'+item.user_name+'</p></div>';
                    str+='<div class="pinglun_right"><div class="xingxing_div"><span class="pingjia_xiao"><span class="pingjia_xiao_limian" style="width:'+xingxing_baifenbi(item.score)+';"></span></span>';
                    str+='<span>'+newtime.getFullYear()+'-'+newtime.getMonth()+'-'+newtime.getDate()+'&nbsp;&nbsp;&nbsp;&nbsp;'+newtime.toLocaleTimeString()+'</span></div><div class="pinglun_text">'+item.appraise+'</div><div class="pinglun_img">';
                    $(item.appraise_img).each(function(i1,item1){
                        str+='<a><img src="'+item1+'" /></a>';
                    });
                    str+='</div></div></li>';
                });
                
                
                
                $('#leijipinglun').html(str);
                $('#page_foot_pinglun').html(msg.page_foot);
                }
        });
    });
    
//鼠标点击评论区的图片放大  再点击 收回  同样必须用 动态生成的元素绑定
$('body').on('mouseover','.pinglun_img img',function(){
    var img_src=$(this).attr('src');
    //var img_eq=$('.pinglin_img img').index($(this));
    //var img_id="#pinglun_fangda_"+img_eq;
    var img_fangda='<img class="pinglun_fangda" id="pinglun_fangda" />';
    $(this).parent().parent().after(img_fangda);
    $("#pinglun_fangda").attr('src',img_src);
});
$('body').on('mouseout','.pinglun_img img',function(){
    $('#pinglun_fangda').remove();
    });
    
$('.box_r_shopping:last').css('border','none');//广告商品最后一个取消边框
$('.goodscontent img').css('max-width','970px;');//设置商品描述里面图片的最大宽度


//点击分享到QQ
$('#fenxiang_qq_a').bind('click',function(){
    $('#fenxiang_qq_url').attr('value',window.location.href);
    showOverlay('fenxiang_qq_div');  
});
//关闭分享到QQ
$('#fenxiang_qq_close').bind('click',function(){
    hideOverlay('fenxiang_qq_div');
});
