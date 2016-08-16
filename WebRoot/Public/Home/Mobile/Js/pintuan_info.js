//考虑到活动商品的各种情况
if(is_ztcg=='ddct'&&choujiang=='0'&&is_ctcg=='0'){
    
}else if(is_ztcg=='ztcg'||is_ztcg=='ztsb'){
    $('#fixed_tishi').html('该团已经成团或者失败，您可自己开团');
    $('#fixed_tishi').css('display','block');
    $('#fixed_tishi').css('bottom','110px');
    setTimeout("$('#fixed_tishi').css('display','none')",5000);
}else if(choujiang!='0'){
    $('#fixed_tishi').html('您已经成功获得过该活动商品，无法重复参加');
    $('#fixed_tishi').css('display','block');
    $('#fixed_tishi').css('bottom','110px');
    setTimeout("$('#fixed_tishi').css('display','none')",5000);
}else if(is_ctcg!='0'){
    $('#fixed_tishi').html('已经参团成功过该活动，无法参团，您可自己开团');
    $('#fixed_tishi').css('display','block');
    $('#fixed_tishi').css('bottom','110px');
    setTimeout("$('#fixed_tishi').css('display','none')",5000);
}


//点击#xuanze_fanhui返回商品页面
$('#xuanze_fanhui').bind('click',function(){
    $('#div_xuanze').animate({'bottom':'-500px'},'normal',function(){
        $('#div_xuanze').css('display','none');
        hideOverlay('div_xuanze');
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



$('.wyct').bind('click',function(event){
    var zx_length=$('.zx_shuxing_ul').length;
    var yixuan_length=$('.zx_shuxing_ul>.yixuan').length;
    if(zx_length!==yixuan_length){
        $('#div_xuanze').css('display','block');
        showOverlay('div_xuanze');
        $('#div_xuanze').animate({'bottom':'0px'},'normal');
        return false;
    }else{
        $('form[name=cantuan_buy]').submit();
        return true;
    }
});