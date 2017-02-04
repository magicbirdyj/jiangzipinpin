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
