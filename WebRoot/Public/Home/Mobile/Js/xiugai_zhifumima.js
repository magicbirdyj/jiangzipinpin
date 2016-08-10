// JavaScript Document
//onfocus
//onblur
$('#infor').css('display','block');
var obj_form=document.xiugaimima;
var yanzhengma,yuan_mima;
$.ajaxSetup({ 
    async : false 
});     

obj_form.yanzhengma.onfocus=function (){yanzhengma_foucs();}
obj_form.yanzhengma.onblur=function (){yanzhengma_blur();}




function yanzhengma_blur(){
    var obj=document.getElementById("infor");
    if($('input[name=yanzhengma]').val()===''){
        $(obj).css('color','red');
        obj.innerHTML="验证码为空，请输入验证码";
        return false;
    }else{
    var data={
        yanzhengma:$('input[name=yanzhengma]').val(),
        check:"yanzhengma"
    };
    var url='/Home/zhuce/check.html';
    $.post(url,data,function(msg){
         yanzhengma=msg;
        if(msg===0){
            $(obj).css('color','red');
            obj.innerHTML="验证码错误，请重新输入";
        }
        else if(msg===-1){
            $(obj).css('color','red');
            obj.innerHTML="验证码已过期，请点击图片刷新";
        }
        else if(msg===1){
            obj.innerHTML="&radic;";
        }
    });
    }
    if(yanzhengma===1){
        return true;
    }else{
        return false;
    }
}

function checkForm(obj){
	 yuan_mima_blur();
         new_mima_blur();
	if(yanzhengma_blur()&&yuan_mima_blur()&&new_mima_blur()){
		obj_form.submit();
	}
        return false;
  }
  

        
        
        
//验证码刷新
var captcha_img=$('.zhuce1_yanzhengma');
captcha_img.attr('title','点击刷新');
var captcha_img_src=captcha_img.attr('src');
captcha_img.bind('click',yanzhengma_click);
function yanzhengma_click(){
    if(captcha_img_src.indexOf('?')>0){  
        $(this).attr("src", captcha_img_src+'&date='+new Date().getTime());  
    }else{  
        $(this).attr("src", captcha_img_src.replace(/\?.*$/,'')+'?'+new Date().getTime());  
    }
}


//原密码失去焦点
$('input[name=yuan_mima]').bind('blur',function(){
    yuan_mima_blur();
});
function yuan_mima_blur(){
    var obj=document.getElementById("infor");
    if($('input[name=yuan_mima]').val()==""){
        $(obj).css('color','red');
        obj.innerHTML="密码为空，请输入您的原密码";
        return false;
        }else{
            var data={
                mima:$('input[name=yuan_mima]').val(),
                check:"xiugai_mima"
                };
                    var url='/Home/Member/xiugai_zhifumima_check.html';
                    $.ajax({
                        type:'post',
                        async : false,
                        url:url,
                        data:data,
                        datatype:'json',
                        beforeSend:function(){
                            obj.innerHTML="检测中。。。";
                        },
                        success:function(msg){
                            yuan_mima=msg;
                        if(msg==='1'){
                                obj.innerHTML="&radic;";
                                }else{
                                    $(obj).css('color','red');
                                    obj.innerHTML="原密码错误，请重新输入";
                                }
                        }
                    });
            if(yuan_mima==='1'){
                return true;
            }else{
                return false;
            }
        }
}

//新密码失去焦点
$('input[name=new_mima]').bind('blur',function(){
    new_mima_blur();
});

function new_mima_blur(){
    querenmima_blur();
    var obj=document.getElementById("infor");
    if($('input[name=new_mima]').val()==""){
        $(obj).css('color','red');
        obj.innerHTML="密码为空，请输入您的密码";
        return false;
        }
        else if($('input[name=new_mima]').val().length<5||$('input[name=new_mima]').val().length>32){
			$(obj).css('color','red');
			obj.innerHTML="密码小于5个字符或者大于32个字符";
			return false;
			}
                else if(!querenmima_blur()){
			obj.innerHTML="&radic;";
			return false;
			}
		else {
                    obj.innerHTML="&radic;";
                    return true;
                }
}
//新密码输入密码 提示
$('input[name=new_mima]').bind('keyup',function(){
    var obj=document.getElementById("mimaxiaoguo");
	var arr=obj.getElementsByTagName("div");
	if(isNaN($(this).val())&&/\d/.test($(this).val())){
		if($(this).val().length<5&&$(this).val().length>0){
			arr[0].style.cssText="background-color:#F76120;";
			arr[1].style.cssText="background-color:#EEEEEE;";
			arr[2].style.cssText="background-color:#EEEEEE;";
			}
			else if($(this).val().length>=5&&$(this).val().length<8){
				arr[0].style.cssText="background-color:#FF8900;";
				arr[1].style.cssText="background-color:#FF8900;";
				arr[2].style.cssText="background-color:#EEEEEE;";
				}
			else if($(this).val().length>=8){
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
			if($(this).val().length<15&&$(this).val().length>0){
				arr[0].style.cssText="background-color:#F76120;";
				arr[1].style.cssText="background-color:#EEEEEE;";
				arr[2].style.cssText="background-color:#EEEEEE;";
				}
				else if($(this).val().length>=15){
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
});

//确认密码失去焦点
$('input[name=again_mima]').bind('blur',function(){
    querenmima_blur();
});


function querenmima_blur(){
	var obj=document.getElementById("infor");
	if($('input[name=again_mima]').val()==""){
		$(obj).css('color','red');
		obj.innerHTML="确认密码为空，请再次输入您的密码";
		return false;
		}
		else if(!($('input[name=again_mima]').val()==$('input[name=new_mima]').val())){
			obj.innerHTML="两次输入的密码不相同，请重新输入";
			return false;
			}
		else {
			obj.innerHTML="&radic;";
			return true;
			}
	}