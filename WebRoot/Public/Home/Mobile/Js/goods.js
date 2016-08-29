//给视频iframe一个正确的高
var width_iframe=$('iframe').css('width');
if(width_iframe){
    var height_iframe=(parseInt(width_iframe)/650)*380+'px';
    $('iframe').css('height',height_iframe);
}



//商品详情和累计评论变换
$('.spxq').bind('click',function(){
    $('.pinglun').css('display','none');
    $('#spxq').css('display','block');
    $('.spxq').css('background-color','#FFF');
    $('.ljpj').css('background-color','#F6F6F6');
    location.href = "#shop_a";
});
$('.ljpj').bind('click',function(){
    $('#spxq').css('display','none');
    $('.pinglun').css('display','block');
    $('.ljpj').css('background-color','#FFF');
    $('.spxq').css('background-color','#F6F6F6');
    $('.pinglun_img li').css('height',$('.pinglun_img li').width());
    location.href = "#shop_a";
});
   


//点击#xuanze_fanhui 隐藏选择属性
$('#xuanze_fanhui').bind('click',function(){
    $('#div_xuanze').animate({'bottom':'-500px'},'normal',function(){
        $('#div_xuanze').css('display','none');
        $('.footer').css('display','block');
        hideOverlay('div_xuanze');
    });
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



    
//鼠标点击评论区的图片放大  再点击 收回  同样必须用 动态生成的元素绑定
$('.pinglun_img li').bind('click',function(){
    if( $(this).css('position')=='static'){
        $(this).css('position','fixed');
        $(this).css('width',$(window).width());
        $(this).css('height',window.screen.height);
        $(this).css('background-color', '#fff');
        $(this).css('top','0px');
        $(this).css('left','0px');
        $(this).children('img').css('width',$(window).width());
    }else{
        $(this).css('position','static');
        $(this).css('width','20%');
        $(this).css('height',$('.pinglun_img li').width());
        $(this).children('img').css('width','auto');
    }
});

    

//$('.goodscontent img').css('max-width','970px;');//设置商品描述里面图片的最大宽度





//点击商品自选属性
$('.zx_shuxing_ul>li').bind('click',function(){
    $(this).css('background-color','#FF9712');
    $(this).attr('class','yixuan');
    $(this).siblings('li').css('background-color','#DDD');
    $(this).siblings('li').removeAttr("class");
    var text="已选：";
    $('.zx_shuxing_ul>.yixuan').each(function(){
        text+='\"'+$(this).html()+'\" ';
    });
    $('#yixuan').html(text);
    $('#zx_shuxing').html(text);
    $('input[name=zx_shuxing]').val(text.substr(3));
});
