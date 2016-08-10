

//点击#xuanze隐藏#shop 显示#div_xuanze
$('#xuanze').bind('click',function(){
    $('#div_xuanze').css('display','block');
    window.scrollTo(0,0);
    $('#div_xuanze').animate({'left':'0%'},'normal',function(){
        $('#shop').css('display','none');
    });
  
});
//点击#xuanze_fanhui返回商品页面
$('#xuanze_fanhui').bind('click',function(){
    $('#shop').css('display','block');
    $('#div_xuanze').animate({'left':'100%'},'normal',function(){
        $('#div_xuanze').css('display','none');
    });

});










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



$('#wyct').bind('click',function(event){
    var zx_length=$('.zx_shuxing_ul').length;
    var yixuan_length=$('.zx_shuxing_ul>.yixuan').length;
    if(zx_length!==yixuan_length){
        $('#div_xuanze').css('display','block');
        window.scrollTo(0,0);
        $('#div_xuanze').animate({'left':'0%'},'normal',function(){
            $('#shop').css('display','none');
        });
    }else{
        $('form[name=cantuan_buy]').submit();
    }
});