// JavaScript Document
//onfocus
//onblur

$('.goods_img').bind('click',function(){
    img_click($(this).attr('src'));
});

function img_click(src){
    $('.img_fangda').attr('src',src);
    $('.div_fangda').css('display','block');
}

$('.img_fangda').bind('click',function(){
    $('.div_fangda').css('display','none');
});

$('#quxiao').bind('click',function(){
    if(confirm("确定要取消售后吗？")){
            var url='/Home/Order/quxiao_shouhou.html';
            var data={
                    order_id:order_id,
                    check:"quxiao_shouhou"
                }
            $.ajax({
                    type:'post',
                    async : false,
                    url:url,
                    data:data,
                    datatype:'json',
                    success:function(msg){
                        if(msg){ 
                            location='/Home/Order/index';                        
                        }else{
                            alert('取消售后失败'); 
                        }
                    }
                });    
        }
});