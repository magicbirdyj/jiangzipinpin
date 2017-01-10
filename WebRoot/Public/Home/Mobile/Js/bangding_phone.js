// JavaScript Document
//var backurl=document.referrer;

var send_message='';
var bangding_phone,name,card_id;
$('input[name="phone"]').bind('blur',function(){
    phone_blur();
});


function phone_blur(){
    var phone=$('input[name="phone"]').val();
    if(phone==''){
        $('#infor').css('display','block');
        $('#infor').html('手机号码为空，请输入!');
        return false;
    }else if(!is_shoujihao(phone)){
        $('#infor').css('display','block');
        $('#infor').html('手机号码有误，请重新输入!');
        return false;
    }else{
        infor_none();
        return true;
    }
}


$('input[name="btn_sjyz"]').bind('click',function(){
    if(!phone_blur()){
        return false;
    }
    btn_sjyz_click();
});
function btn_sjyz_click(){
    i=30;
    var phone=$('input[name="phone"]').val();
    setit=setInterval("yanshi()",1000);
    var url='/Home/Ajaxnologin/send_message.html';
    bangding_phone=phone;
    var data={
            shoujihao:phone,
            check:"send_message"
            };
    $.ajax({
        type:'post',
        url:url,
        data:data,
        datatype:'json',
        async : false, 
        success:function(msg){
            if(msg===true){
                send_message='1';
                alert('短信已发送成功，请注意查看');
            }
        }
    });
}

function yanshi(){
    if(i>-1){
        $('input[name="btn_sjyz"]').unbind('click');
        $('input[name="btn_sjyz"]').attr('disabled',true);
        $('input[name="btn_sjyz"]').css('cursor','default');
        $('input[name="btn_sjyz"]').val('免费获取短信动态码'+'('+i+')');
        i--;
    }else{
        clearInterval(setit);
        $('input[name="btn_sjyz"]').val('免费获取短信动态码');
        $('input[name="btn_sjyz"]').bind('click',btn_sjyz_click);
        $('input[name="btn_sjyz"]').attr('disabled',false);
    }
}


$('input[name="shoujiyanzheng"]').bind('focus',function(){
    if(!phone_blur()){
        return false;
    }
    if(send_message!==''){
        $('#infor').css('display','block');
        $('#infor').html('请输入手机短信动态码');
    }else{
        $('#infor').css('display','block');
        $('#infor').html('请先点击:免费获取短信动态码');
    }
});
$('input[name="shoujiyanzheng"]').bind('blur',function(){
    if(!phone_blur()){
        return false;
    }
    shoujiyanzheng_blur();
        
});
function shoujiyanzheng_blur(){
    var sjyz;
    if(send_message===''){
        $('#infor').css('display','block');
        $('#infor').html('请先点击:免费获取短信动态码');
        return false;
    }else if($('input[name="shoujiyanzheng"]').val()===''){
        $('#infor').css('display','block');
        $('#infor').html('短信动态码为空');
        return false;
    }else{
        infor_none();
        var url='/Home/Ajaxnologin/send_message.html';
        var data={
            yanzhengma:$('input[name="shoujiyanzheng"]').val(),
            check:"yanzheng_message"
            };
        $.ajax({
            type:'post',
            url:url,
            data:data,
            datatype:'json',
            async : false, 
            success:function(msg){
                sjyz=msg;
                if(msg){
                    infor_none();
                }else{
                    $('#infor').css('display','block');
                    $('#infor').html('短信动态码错误,请重新输入');
                }
            }
        });
        if(sjyz){
            return true;
        }else{
            return false;
        }
    }
}
var obj_form=document.bangding;
$('#bangding_xiayibu').bind('click',function(){
    if(phone_blur()&&shoujiyanzheng_blur()){
        //绑定手机号
        ajax_bangding();
        return false;
    }else{ 
        return false;
    }
});


function ajax_bangding(){
    var url='/Home/Ajaxlogin/bangding_shouji.html';
    var data={
            shoujihao:bangding_phone,
            check:"bangding_check"
            };
    $.ajax({
        type:'post',
        url:url,
        data:data,
        datatype:'json',
        async : true, 
        success:function(msg){
            if(msg){
                window.location.href=ref; 
            }
        }
    });
}
