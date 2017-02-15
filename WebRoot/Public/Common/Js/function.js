//去两边空格
function Trim(str){ 
    return str.replace(/(^\s*)|(\s*$)/g, ""); 

}
//时间戳转换成时间
function getDate(tm){
    var tt=new Date(parseInt(tm) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");
    return tt;
} 
//验证手机号，如果是，返回true,否则返回false
function is_shoujihao(str){
    var reg=/^1[3458]\d{9}$/gi;
    return reg.test(str);
}


//验证邮箱，如果是返回true,否则返回false
function is_youxiang(str){
    var reg=/^\w+[.\w]*@(\w+\.)+\w{2,4}$/gi;
    return reg.test(str);
}


//验证IP是否有效，如果是返回true,否则返回false
function is_ip(str){
    var reg = /^([1-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])(\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])){3}$/gi;
    return reg.test(str);
}

//验证是否含有非法字符，含有非法返回true，否则返回false
function is_feifa(str){
    var reg = /[=;:#&\\\^\$\[\]\{\}\*\+\?\"\']+/gi;
    var result= reg.exec(str);
    return result;
}

//文本框获取焦点时，提示文字显示的（第一个参数是需要显示信息的jq对象，第二个参数是要显示的提示文字）
function text_focus(obj,str){
    obj.css('color','#666');
    obj.html(str);
}

//文本框失去焦点，检查是否为空和非法（第一个参数是失去焦点的本身对象（this），第二个参数是需要显示信息的jq对象）
function text_blue(obj,obj_info,txt){
    if(Trim(obj.val())==''){
        obj_info.css('color','red');
        obj_info.html(txt+'为空，请输入内容');
        obj_info.css('display','block');
        setTimeout(infor_none,5000);
        return false;
    }else if(is_feifa(Trim(obj.val()))){
        obj_info.css('color','red');
        //obj_info.html('含有非法字符=;:#&\/^$()[]{}*+?-"，请重新输入');
        obj_info.html(txt+'含有非法字符：'+is_feifa(obj.val()));
        obj_info.css('display','block');
        setTimeout(infor_none,5000);
        return false;
    }else{
        //obj_info.css('color','#666');
        //obj_info.html('&radic;');
        //setTimeout(infor_none,5000);
        return true;
    }
}


//验证图片是否上传和类型是否正确，第一个参数是文件对象，第二个参数是信息对象，第三个参数为真，则弹出对话框，为假，不弹出。  参数为JQ对象
function check_file_image(obj_file,obj_info,flag){
	var arr_image=["jpg","jpeg","png","gif",'swf','bmp'];
	var str_suffix=obj_file.val().substr(obj_file.val().lastIndexOf(".")+1).toLowerCase();//获取后缀
        if(str_suffix==false){
            obj_info.css('color','red');
            obj_info.html("未上传文件，请上传图片");
            return false;
        }
	for(var i=0;i<arr_image.length;i++){
		if(str_suffix==arr_image[i]){
                    obj_info.html("");
                    return true;
                    break;
			}
		}
                if(flag){
                    alert("文件类型不允许上传，请选择图片格式");
                    obj_file.val('');
                }
            obj_info.css('color','red');
            obj_info.html("文件类型不允许，请上传正确的图片格式");
            return false;
	}
//ajax请求判断用户是否登录
function check_login(){
    var data;
    var url='/Home/login/is_login.html';
    $.ajax({
        type:'post',
        async : false,
        url:url,
        datatype:'json',
        success:function(msg){
            if(msg===0){
                data=0;
            }else{
                data=msg;
            }
        }
    });
    return data;
}


//星星分数变成百分数
function xingxing_baifenbi(score){
    var score1=score/5;
    score1=score1.toFixed(2)*100;
    return score1+'%';
}

//改变url参数 主要用于菜单筛选
function change_url_canshu(url_full,canshu,value){
    var url,index,new_url;
    var arr_url;
    var index_0=url_full.lastIndexOf('.html');
    if(index_0!==-1){
        url=url_full.substr(0,index_0);
    }else{
        url=url_full;
    }
    
    index=url.lastIndexOf(canshu);
    if(index!==-1){
        url_b=url.substr(index);
        arr_url=url_b.split('/');
        new_url=url.replace(arr_url[1],value);
    }else{
        new_url=url+'/'+canshu+'/'+value;
    }
    
    return new_url;
}
//清除url参数 主要用于菜单筛选
function clear_url_canshu(url,canshu){
    var index,new_url,url_b;
    var arr_url;
    index=url.lastIndexOf(canshu);
    if(index!==-1){
        url_b=url.substr(index);
        arr_url=url_b.split('/');
        new_url=url.replace('/'+canshu+'/'+arr_url[1],'');
    }else{
        new_url=url;
    }
    return new_url;
}

//改变url的属性参数 主要用于菜单筛选
function change_url_shuxing(url_full,name,value){
    var url,index,new_url;
    var index_0=url_full.lastIndexOf('.html');
    if(index_0!==-1){
        url=url_full.substr(0,index_0);
    }else{
        url=url_full;
    }
    
    index=url.lastIndexOf('shuxing');
    if(index===-1){
        new_url=url+'/'+'shuxing/'+name+'-'+value;
        return new_url;
    }
    
    index_1=url.lastIndexOf(name);
    if(index_1===-1){
        new_url=url.substr(0,index)+'shuxing/'+name+'-'+value+'__'+url.substr(index+8);
        return new_url;
    }
    var url_b=url.substr(index_1);
    var arr_url=url_b.split(/(__|\/)/);
    new_url=url.replace(arr_url[0],name+'-'+value);
    return new_url;
}

//清除url的属性参数 主要用于菜单筛选
function clear_url_shuxing(url,name,value){
    var index,new_url;
    var mylength=(name+'-'+value).length;
    index=url.lastIndexOf(name+'-'+value);
    if(url.substr(index-1,1)!=='/'){
        new_url=url.replace('__'+name+'-'+value,'');
        return new_url;
    }
    if(url.substr(index+mylength,2)==='__'){
        new_url=url.replace(name+'-'+value+'__',''); 
    }else{
        new_url=clear_url_canshu(url,'shuxing');
    }
    return new_url;
    
   
}

function infor_none(){
    $('#infor').css('display','none');
}




//文本框失去焦点，检查是否为空和非法（第一个参数是失去焦点的本身对象（this），第二个参数是需要显示信息的jq对象）
function text_blue_shouji(obj,obj_info,txt){
    if(Trim(obj.val())===''){
        obj_info.css('display','block');
        obj_info.css('color','red');
        obj_info.html(txt+'为空，请输入内容');
        setTimeout(infor_none,5000);
        return false;
    }else if(is_feifa(Trim(obj.val()))){
        obj_info.css('display','block');
        obj_info.css('color','red');
        //obj_info.html('含有非法字符=;:#&\/^$()[]{}*+?-"，请重新输入');
        obj_info.html(txt+'含有非法字符：'+is_feifa(obj.val()));
        setTimeout(infor_none,5000);
        return false;
    }else if(!is_shoujihao(Trim(obj.val()))){
        obj_info.css('color','red');
        obj_info.html(txt+' 不是手机号');
        setTimeout(infor_none,5000);
        return false;
    }else{
        obj_info.css('color','#666');
        obj_info.html('&radic;');
        //obj_info.css('display','none');
        return true;
    }
}

//验证图片是否上传和类型是否正确，第一个参数是文件对象，第二个参数是信息对象，第三个参数为真，则弹出对话框，为假，不弹出。  参数为JQ对象
function check_file_image_shouji(obj_file,obj_info,flag){
	var arr_image=["jpg","jpeg","png","gif",'swf','bmp'];
	var str_suffix=obj_file.val().substr(obj_file.val().lastIndexOf(".")+1).toLowerCase();//获取后缀
        if(str_suffix==false){
            obj_info.css('display','block');
            obj_info.css('color','red');
            obj_info.html("未上传文件，请上传图片");
            setTimeout(infor_none,5000);
            return false;
        }
	for(var i=0;i<arr_image.length;i++){
		if(str_suffix==arr_image[i]){
                    obj_info.css('display','none');
                    return true;
                    break;
			}
		}
                if(flag){
                    alert("文件类型不允许上传，请选择图片格式");
                    obj_file.val('');
                }
            obj_info.css('display','block');
            obj_info.css('color','red');
            obj_info.html("文件类型不允许，请上传正确的图片格式");
            setTimeout(infor_none,5000);
            return false;
}
function check_file(obj_file,obj_info){
    var a=obj_file.val();
    if(!a){
        obj_info.css('color','red');
        obj_info.html("未上传文件，请上传图片");
        return false;
    }else{
        obj_info.html("");
        return true;
    }
}

function check_file_shouji(obj_file,obj_info){
    var a=obj_file.val();
    if(!a){
        obj_info.css('display','block');
        obj_info.css('color','red');
        obj_info.html("未上传文件，请上传图片");
        setTimeout(infor_none,5000);
        return false;
    }else{
        obj_info.css('display','none');
        return true;
    }
}


function infor_none(){
    $('#infor').css('display','none');
}
        
        
        
        
        


/* 当前页面高度 */
function pageHeight() {
    return document.body.scrollHeight;
}

/* 当前页面宽度 */
function pageWidth() {
    return document.body.scrollWidth;
}


/*弹出遮罩层 ，显示提示*/
function tanchu(id){
        $('#'+id).show();
	$('.big-shade-all').show();
}