// JavaScript Document
//var backurl=document.referrer;

$('.view_li').bind('click',function(){
    var is_active=$(this).attr('class').indexOf('active');
    if(is_active>=0){
        return false;
    }
    $(this).addClass('active').siblings('.view_li').removeClass('active');
    var index=$(this).index();
    $('.view').eq(index).css('display','block').siblings('.view').css('display','none');
});


//鼠标点击图片放大  再点击 收回  同样必须用 动态生成的元素绑定
$('.div_goods_img').bind('click',function(){
    if( $(this).css('position')=='relative'){
        $(this).css('margin','0px');
        $(this).css('position','fixed');
        $(this).css('z-index','101');
        $(this).css('width',$(window).width());
        $(this).css('height',window.screen.height);
        $(this).children('.goods_img').css('max-width',$(window).width());
        $(this).children('.goods_img').css('max-height',window.screen.height);
        $(this).children('.goods_img').css('width','auto');
        $(this).css('background-color', '#fff');
        $(this).css('top','0px');
        $(this).css('left','0px');
    }else{
        $(this).css('position','relative');
        $(this).css('margin','5px');
        $(this).css('z-index','1');
        $(this).css('width','43px');
        $(this).css('height','43px');
        $(this).children('.goods_img').css('max-width','43px');
        $(this).children('.goods_img').css('max-height','43px');
        $(this).children('.goods_img').css('width','auto');
    }
});