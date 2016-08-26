
//已经过去过资格的1元购或者抽奖会员 无法再开团
if(is_get=="yijing_get"){
        $('#fixed_tishi').html('您已经购买成功过该活动商品');
        $('#kaituan_buy').css('background-color','#ccc');
    }
    
    var zx_length=$('.zx_shuxing_ul').length;
$('#kaituan_buy').bind('click',function(){
    delete_guanzhu();
    if(zx_length==0){
        save_url('/Home/Goods/kaituan_buy/goods_id/'+$('input[name=goods_id]').val());
    }
    if(guanzhu!=='yiguanzhu'){
        tanchuguanzhu();
        return false;
    }
    //已经过去过资格的1元购或者抽奖会员 无法再开团
    if(is_get=="yijing_get"){
        $('#fixed_tishi').css('display','block');
        setTimeout("$('#fixed_tishi').css('display','none')",3000);
        return false;
    }
    
    var yixuan_length=$('.zx_shuxing_ul>.yixuan').length;
    if(zx_length===yixuan_length){
        $('form[name=kaituan_buy]').submit();
    }else{
        $('#div_xuanze').css('display','block');
        $('.footer').css('display','none');
        showOverlay('div_xuanze');
        $('#div_xuanze').animate({'bottom':'0px'},'normal');
        //选择属性弹出框 确定按钮的点击事件
        $('#shuxing_queding').bind('click',function(){
            shuxing_queding_click('kaituan_buy');
        });
    }
});
$('#dandu_buy').bind('click',function(){
    delete_guanzhu();
    
    if(zx_length==0){
        save_url('/Home/Goods/kaituan_buy/goods_id/'+$('input[name=goods_id]').val());
    }
    if(guanzhu!=='yiguanzhu'){
        tanchuguanzhu();
        return false;
    }
    
    var yixuan_length=$('.zx_shuxing_ul>.yixuan').length;
    if(zx_length===yixuan_length){
        $('form[name=dandu_buy]').submit();
    }else{
        $('#div_xuanze').css('display','block');
        $('.footer').css('display','none');
        showOverlay('div_xuanze');
        $('#div_xuanze').animate({'bottom':'0px'},'normal');
    }
    //选择属性弹出框 确定按钮的点击事件
    $('#shuxing_queding').bind('click',function(){
         shuxing_queding_click('dandu_buy');
    });
});


function shuxing_queding_click(buy_fangshi){//buy_fangshi等于dandu_buy 或者kaituan_buy
    var yixuan_length=$('.zx_shuxing_ul>.yixuan').length;
    var tishi;
        if(zx_length===yixuan_length){
            $('form[name='+buy_fangshi+']').submit();
        }else{
            $('.zx_shuxing_ul').each(function(){
                var this_yixuan=$(this).children('.yixuan').length;
                if(this_yixuan==0){
                    tishi=$(this).prev().html();
                    return false;
                }
            });
            $('#fixed_tishi').html('请选择属性'+tishi);
            $('#fixed_tishi').css('display','block');
            $('#fixed_tishi').css('bottom','80px');
            setTimeout("$('#fixed_tishi').css('display','none')",3000);
        }
}



//点击加入收藏
$('#shoucang').bind('click',function(){
    var is_success=false;
    var url='/Home/Goods/sellection_join.html';
    var data={
        goods_id:$('input[name=goods_id]').val(),
        check:"sellection_join"
    };
    $.ajax({
        type:'post',
        async : false,
        url:url,
        data:data, 
        datatype:'json',
        success:function(msg){
            if(msg=='-1'){
                alert('加入收藏失败，请重新加入');                                
            }
            if(msg=='1'){
                alert('成功加入收藏'); 
                is_success=true;                               
            }
        }
    });
   if(is_success){
        $('.foot_shoucang').css('color','#f90');
        $('.foot_shoucang').next('span').html('已收藏');
        $('#shoucang').attr('id','yishoucang');
    }
           
    });
    
    
    
    //ajax删除$_session
    function delete_guanzhu(){
        $.ajax({
            type:'post',
            url:'/Home/Login/delete_guanzhu',
            data:0,
            dataType:'json'
        });
    } 
    
    //ajax保存url进数据库
    function save_url(s_url){
        var data={
        url:s_url
    };
        $.ajax({
            type:'post',
            url:'/Home/Login/save_url_ajax',
            data:data,
            dataType:'json',
            
        });
    } 
    
   