// JavaScript Document
//onfocus
//onblur
var obj_form=document.zhuce;
var login;

obj_form.shoujihao.onfocus=function (){yzshouji_foucs();};
obj_form.shoujihao.onblur=function (){yzshouji_blur();};
function yzshouji_foucs(){
	var obj=document.getElementById("infor_shoujihao");
	obj.style.cssText="color:#666;";
	obj.innerHTML="请输入你的登录号码";
	}
function yzshouji_blur(){
	var obj=document.getElementById("infor_shoujihao");
	if(obj_form.shoujihao.value==""){
		obj.style.cssText="color:red;";
		obj.innerHTML="登录号码为空，请输入";
		return false;
		}else if(!is_shoujihao(obj_form.shoujihao.value)){
			obj.style.cssText="color:red;";
			obj.innerHTML="不正确，请输入正确的手机号码";
			return false;
			}else {
                            obj.innerHTML="&radic;";
                            return true;
                        }
		
	}


        
function login(obj){
	if(yzshouji_blur()){
            obj=document.getElementById("info_login");
            var data={
                shoujihao:$('input[name=shoujihao]').val(),
                mima:$('input[name=mima]').val(),
                check:"login"
                };
                    var url='/Home/login/login.html';
                    $.ajax({
                        type:'post',
                        async : false,
                        url:url,
                        data:data,
                        datatype:'json',
                        beforeSend:function(){
                            obj.innerHTML="登录中。。。";
                        },
                        success:function(msg){
                        if(msg==='-1'){
                            obj.style.color="red";
                            obj.innerHTML="账号不存在，请重新输入";
                            }else if(msg==='1'){
                                obj.innerHTML="等待进入。。。";
                                obj_form.submit();
                                }else{
                                    obj.style.color="red";
                                    obj.innerHTML="账号或密码错误，请重新输入";
                                }
                        }
                    });        
	}
        return false;
  }        

