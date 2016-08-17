
//已经过去过资格的1元购或者抽奖会员 无法再开团
if(is_get=="yijing_get"){
        $('#fixed_tishi').html('您已经购买成功过该活动商品');
        $('#kaituan_buy').css('background-color','#ccc');
    }
$('#kaituan_buy').bind('click',function(){
    if(guanzhu==='weiguanzhu'){
        tanchuguanzhu();
        delete_wei_huiyuan();
        return false;
    }
    //已经过去过资格的1元购或者抽奖会员 无法再开团
    if(is_get=="yijing_get"){
        $('#fixed_tishi').css('display','block');
        setTimeout("$('#fixed_tishi').css('display','none')",3000);
        return false;
    }
    var zx_length=$('.zx_shuxing_ul').length;
    var yixuan_length=$('.zx_shuxing_ul>.yixuan').length;
    if(zx_length===yixuan_length){
        $('form[name=kaituan_buy]').submit();
    }else{
        $('#div_xuanze').css('display','block');
        showOverlay('div_xuanze');
        $('#div_xuanze').animate({'bottom':'0px'},'normal');
    }
});
$('#dandu_buy').bind('click',function(){
    if(guanzhu==='weiguanzhu'){
        tanchuguanzhu();
        delete_wei_huiyuan()
        return false;
    }
    var zx_length=$('.zx_shuxing_ul').length;
    var yixuan_length=$('.zx_shuxing_ul>.yixuan').length;
    if(zx_length===yixuan_length){
        $('form[name=dandu_buy]').submit();
    }else{
        $('#div_xuanze').css('display','block');
        showOverlay('div_xuanze');
        $('#div_xuanze').animate({'bottom':'0px'},'normal');
    }
});



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
    
    
    //点击客服
$('#kefu').bind('click',function(){
   
    });
    
//ajax删除$_session
function delete_wei_huiyuan(){
        $.ajax({
            type:'post',
            url:'/Home/Login/delete_wei_huiyuan',
            data:0,
            dataType:'json'
        });
    } 
    
    
   