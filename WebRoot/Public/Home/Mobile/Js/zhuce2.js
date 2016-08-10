// JavaScript Document
//var backurl=document.referrer;
$('#infor').css('display','block');
var obj_form=document.zhuce;
var huiyuanming;
var i;
var setit;
var send_message='';
document.getElementById("dlm_sjh").style.cssText="background-color:#03BA8A;color:#FFF";
obj_form.huiyuanming.onfocus=function (){huiyuanming_foucs();};
obj_form.huiyuanming.onblur=function (){huiyuanming_blur();};
obj_form.shezhimima.onfocus=function (){shezhimima_foucs();};
obj_form.shezhimima.onblur=function (){shezhimima_blur();};
obj_form.shezhimima.onkeyup=function (){shezhimima_keyup();};
obj_form.querenmima.onfocus=function (){querenmima_foucs();};
obj_form.querenmima.onblur=function (){querenmima_blur();};
$('input[name="shoujiyanzheng"]').bind('focus',function(){
    if(send_message!==''){
        $('#infor').css('color','#666');
        $('#infor').html('请输入手机短信动态码');
    }else{
        $('#infor').css('color','red');
        $('#infor').html('请先点击:免费获取短信动态码');
    }
});
$('input[name="shoujiyanzheng"]').bind('blur',function(){
    shoujiyanzheng_blur();
        
});
function shoujiyanzheng_blur(){
    var sjyz;
    if(send_message===''){
        $('#infor').css('color','red');
        $('#infor').html('请先点击:免费获取短信动态码');
        return false;
    }else if($('input[name="shoujiyanzheng"]').val()===''){
        $('#infor').html('短信动态码为空');
        $('#infor').css('color','red');
        return false;
    }else{
        var url='/Home/zhuce/send_message.html';
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
                    $('#infor').html('&radic;');
                    $('#infor').css('color','#666');
                }else{
                    $('#infor').html('短信动态码错误');
                    $('#infor').css('color','red');
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

$('input[name="btn_sjyz"]').bind('click',btn_sjyz_click);
function btn_sjyz_click(){
    i=30;
    setit=setInterval("yanshi()",1000);
    var url='/Home/zhuce/send_message.html';
    var data={
            shoujihao:$('#dlm_sjh').text(),
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
function huiyuanming_foucs(){
	$('#infor').css('color','#666');
	$('#infor').html("输入您想要的会员名，不可更改，建议使用中文");
	}
function huiyuanming_blur(){
	if(obj_form.huiyuanming.value===""){
                $('#infor').css('color','red');
		$('#infor').html("会员名为空，请输入你的会员名");
		return false;
		}
		else if(obj_form.huiyuanming.value.length<2||obj_form.huiyuanming.value.length>12){
			$('#infor').css('color','red');
			$('#infor').html("会员名小于2个字符或者大于12个字符");
			return false;
			}
                else if(is_feifa(obj_form.huiyuanming.value)){
                    $('#infor').css('color','red');
                    $('#infor').html("会员名含有非法字符");
                    return false;
                }
		else{
                    var data={
                            huiyuanming:$('input[name=huiyuanming]').val(),
                            check:"huiyuanming"
                            };
                    var url='/Home/zhuce/check.html';
                    $.ajax({
                        type:'post',
                        async : false,
                        url:url,
                        data:data,
                        datatype:'json',
                        beforeSend:function(){
                             $('#infor').html("检验中...");
                        },
                        success:function(msg){
                        huiyuanming=msg;
                        if(msg!=='0'){
                            $('#infor').css('color','red');
                            $('#infor').html("会员名已经被注册，请重新填写");
                            }else {
                                $('#infor').html("会员名可用&radic;");
                                }
                        }
                    });
                    if(huiyuanming==='0'){
                        return true;
                    }else{
                        return false;
                    }			
			}
	}
function shezhimima_foucs(){
	$('#infor').css('color','#666');
	$('#infor').html("设置您的密码，建议使用英文与数字结合");
	}
	
function shezhimima_blur(){	
	if(obj_form.shezhimima.value==""){
		$('#infor').css('color','red');
		$('#infor').html("密码为空，请输入您的密码");
		return false;
		}
		else if(obj_form.shezhimima.value.length<5||obj_form.shezhimima.value.length>32){
			$('#infor').css('color','red');
			$('#infor').html("密码小于5个字符或者大于32个字符");
			return false;
			}
		else {
                        $('#infor').css('color','#666');
			$('#infor').html("密码符合规则&radic;");
			return true;
			}
	}
function shezhimima_keyup(){
	var obj=document.getElementById("mimaxiaoguo");
	var arr=obj.getElementsByTagName("div");
	if(isNaN(obj_form.shezhimima.value)&&/\d/.test(obj_form.shezhimima.value)){
		if(obj_form.shezhimima.value.length<5&&obj_form.shezhimima.value.length>0){
			arr[0].style.cssText="background-color:#F76120;";
			arr[1].style.cssText="background-color:#EEEEEE;";
			arr[2].style.cssText="background-color:#EEEEEE;";
			}
			else if(obj_form.shezhimima.value.length>=5&&obj_form.shezhimima.value.length<8){
				arr[0].style.cssText="background-color:#FF8900;";
				arr[1].style.cssText="background-color:#FF8900;";
				arr[2].style.cssText="background-color:#EEEEEE;";
				}
			else if(obj_form.shezhimima.value.length>=8){
				arr[0].style.cssText="background-color:#5BAB3C;";
				arr[1].style.cssText="background-color:#5BAB3C;";
				arr[2].style.cssText="background-color:#5BAB3C;";
				}
			else {
				arr[0].style.cssText="background-color:#EEEEEE;";
				arr[1].style.cssText="background-color:#EEEEEE;";
				arr[2].style.cssText="background-color:#EEEEEE;";
				}
	}
		else{
			if(obj_form.shezhimima.value.length<15&&obj_form.shezhimima.value.length>0){
				arr[0].style.cssText="background-color:#F76120;";
				arr[1].style.cssText="background-color:#EEEEEE;";
				arr[2].style.cssText="background-color:#EEEEEE;";
				}
				else if(obj_form.shezhimima.value.length>=15){
					arr[0].style.cssText="background-color:#FF8900;";
					arr[1].style.cssText="background-color:#FF8900;";
					arr[2].style.cssText="background-color:#EEEEEE;";
					}
				else {
					arr[0].style.cssText="background-color:#EEEEEE;";
					arr[1].style.cssText="background-color:#EEEEEE;";
					arr[2].style.cssText="background-color:#EEEEEE;";
					}
			}
	}
function querenmima_foucs(){
	$('#infor').css('color','#666');
	$('#infor').html("请再次输入您的密码");
	}
function querenmima_blur(){
	if(obj_form.querenmima.value==""){
		$('#infor').css('color','red');
		$('#infor').html("确认密码为空，请再次输入您的密码");
		return false;
	}else if(!(obj_form.querenmima.value==obj_form.shezhimima.value)){
                        $('#infor').css('color','red');
			$('#infor').html("两次输入的密码不相同，请重新输入");
			return false;
	}else {
                        $('#infor').css('color','#666');
			$('#infor').html("两次输入密码相同&radic;");
			return true;
	}
}

        
$('#zhuce1_xiayibu').bind('click',function(){
    if(shoujiyanzheng_blur()&&huiyuanming_blur()&&shezhimima_blur()&&querenmima_blur()){
        obj_form.submit();
        return false;
    }else{ 
        return false;
    }
});

        



