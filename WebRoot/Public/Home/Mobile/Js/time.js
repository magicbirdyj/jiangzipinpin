// JavaScript Document
//var backurl=document.referrer;


//$('.trigger-ico').eq(0).css('display','block');
quick_time();//给当天的时间添加尽快取标签
//点击日期
$('#time_controler li').bind('click',function(){
    //取消所有时间选择
    $('.detail_hour').removeClass('select_hour');
    
    $(this).addClass('selected');
    $(this).children('.trigger-ico').css('display','block');
    $(this).siblings().removeClass('selected');
    $(this).siblings().children('.trigger-ico').css('display','none');
    var index=$(this).index();
    if(index!=0){
        //尽快取不显示
        $('.quickly').css('display','none');
        $('.detail_hour').removeClass('baodan');
    }else{
        quick_time()
    }
})

function quick_time(){
    var myDate = new Date();
    var hours=myDate.getHours();       //获取当前小时数(0-23)
    var minutes=myDate.getMinutes();     //获取当前分钟数(0-59)
    if(hours>21){
        $(".detail_hour").addClass('baodan');
        $('.quickly').css('display','none');
    }else if(hours<10){
        //尽快取不显示
        $('.quickly').css('display','none');
        $('.detail_hour').removeClass('baodan');
    }else{
        $(".detail_hour[date_hour="+hours+"]").after($('.quickly'));
        $('.quickly').css('display','block');
        var n=$(".detail_hour[date_hour="+hours+"]").index()+1;
        $(".detail_hour:lt("+n+")").addClass('baodan');
    }
}



//点击时间
$('body').on('click','.detail_hour:not(.baodan)',function(){
    $(this).addClass('select_hour');
    $(this).siblings().removeClass('select_hour');
});



//点击确认选择
$('#order-btn').bind('click',function(){
    if($('.select_hour').length==0){
        $('#time_tishi').css('display','block');
        $('#time_tishi').html('您还没选择时间');
        setTimeout("$('#time_tishi').css('display','none')",3000);
    }else{
        $('#time').html(get_time());
        fanhui_main($('#bianji_time_div'));
    }
})


//获取选中的日期和时间
function get_time(){
    var riqi=$('.selected').children('p:eq(1)').html()+$('.selected').children('p:eq(0)').html();
    var shijian=$('.select_hour').find('.view_text').html();
    return riqi+' '+shijian;
}