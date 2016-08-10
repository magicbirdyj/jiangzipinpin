// JavaScript Document
//onfocus
//onblur

$('.tijiao').bind('click',function(){
    var cause=$('.tuikuang_select>option:selected').val();
    var url='/Home/Order/tuikuang_check.html';
    var data={
        check:'tuikuang_befor_hunli',
        cause:cause,
        order_id:$('#order_id').val()
    };
    $.ajax({
        type:'post',
        async : false,
        url:url,
        data:data,
        datatype:'json',
        success:function(msg){
            //var lo_url="/Admin/Advert/tuikuang.html";
            //window.location.href=lo_url;
            if(msg==='success'){
                alert('退款成功');
                 window.location.reload();
            }else if(msg==='shenqing'){
                alert('申请退款成功');
                window.location.reload();
            }
        }
    });
});
