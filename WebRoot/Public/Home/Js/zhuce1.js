// JavaScript Document
//onfocus
//onblur
var obj_form=document.zhuce;
var yanzhengma,shoujihao;
$.ajaxSetup({ 
    async : false 
});     
obj_form.shoujihao.onfocus=function (){yzshouji_foucs();};
obj_form.shoujihao.onblur=function (){yzshouji_blur();};
obj_form.yanzhengma.onfocus=function (){yanzhengma_foucs();};
//obj_form.yanzhengma.onblur=function (){yanzhengma_blur();}
document.getElementById("tyxy").onclick=function (){tyxy_click();};
function yzshouji_foucs(){
	var obj=document.getElementById("infor_shoujihao");
	obj.style.cssText="color:#666;";
	obj.innerHTML="请输入你的手机号码";
	}
function yzshouji_blur(){
	var obj=document.getElementById("infor_shoujihao");
	if(obj_form.shoujihao.value==""){
		obj.style.cssText="color:red;";
		obj.innerHTML="手机号码为空，请输入";
		return false;
		}
		else if(!is_shoujihao(obj_form.shoujihao.value)){
			obj.style.cssText="color:red;";
			obj.innerHTML="不正确，请输入正确的手机号码";
			return false;
			}
		else{
                    var data={
                            shoujihao:$('input[name=shoujihao]').val(),
                            check:"shoujihao"
                            };
                    var url='/Home/zhuce/check.html';
                    $.ajax({
                        type:'post',
                        url:url,
                        data:data,
                        datatype:'json',
                        beforeSend:function(){
                            obj.innerHTML="检验中...";
                        },
                        success:function(msg){
                        shoujihao=msg;
                        if(msg==='1'){
                            obj.style.cssText="color:red;";
                            obj.innerHTML="手机号已经被注册，请重新填写";
                            }else if(msg==='0'){
                                obj.innerHTML="&radic;";
                                }else{
                                    obj.innerHTML="系统错误，请重试";
                                }
                        }
                    });
                    if(shoujihao==='0'){
                        return true;
                    }else{
                        return false;
                    }
		}
	}

function yanzhengma_foucs(){
	var obj=document.getElementById("infor_yanzhengma");
	obj.style.cssText="color:#666;";
	obj.innerHTML="请输入以下图片中的数字";
	}
function yanzhengma_blur(){
    var obj=document.getElementById("infor_yanzhengma");
    if($('input[name=yanzhengma]').val()===''){
        obj.style.cssText="color:red;";
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
            obj.style.cssText="color:red;";
            obj.innerHTML="验证码错误，请重新输入";
        }
        else if(msg===-1){
            obj.style.cssText="color:red;";
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

$('#zhuce1_xiayibu').bind('click',function(event){
    event.preventDefault();
    var a=yanzhengma_blur();
    var b=yzshouji_blur();
    if(a&&b){
	obj_form.submit();
        return false;
    }else{
            return false;
    }
});
function checkForm(obj){
	yzshouji_blur();
	if(yanzhengma_blur()&&yzshouji_blur()){
		obj_form.submit();
                return false;
	}else{
            return false;
        }
  }
  
  //点击同意协议
function tyxy_click(){
	document.getElementById("zcxy").style.cssText="display:none;";
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

