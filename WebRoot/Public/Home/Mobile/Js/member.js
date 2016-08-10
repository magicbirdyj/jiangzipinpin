
//
$('#wodezhanghu').css('height',$(window).height());



   
//点击#wode17_head隐藏#wode17 显示#wodezhanghu
$('#wode17_head').bind('click',function(){
    $('#wodezhanghu').css('display','block');
    window.scrollTo(0,0);
    $('#wodezhanghu').animate({'left':'0%'},'normal',function(){
        $('#wode17').css('display','none');
    });
    
    
    
});
//点击#wodezhanghu_fanhui返回商品页面
$('#wodezhanghu_fanhui').bind('click',function(){
    $('#wode17').css('display','block');
    $('#wodezhanghu').animate({'left':'100%'},'normal',function(){
        $('#wodezhanghu').css('display','none');
    });

});








