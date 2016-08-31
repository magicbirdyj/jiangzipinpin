// JavaScript Document
//onfocus
//onblur

$('#tijiao').bind('click',function(){
    var a=yz_miaoshu($('textarea[name=miaoshu]'));
    var b=yz_shouji($('input[name=shouhou_iphone]'));
    var c=yz_img();
    if(!(a&&b&&c)){
        return false;
    }
    $('form[name=shouhou]').submit();
});



//上传文件必须是图片
$('input[name=file_img]').bind('change',function(){
    if(check_file_image($(this),$('#file_img_info'),true)){
        file_jia_change();
    };
    $('input[name=file_img]').val('');
});




//动态生成的元素添加事件
$('body').on('click','.bt_delete',function(){delete_file($(this));});
$('body').on('change','.file_img1',function(){check_file_image($(this),$(this).next('span'),true);});


function delete_file(obj){
    obj.parent().parent().remove();
}




//添加商品图片点击+
$('#file_jia').bind('click',function(){
    $('input[name=file_img]').trigger('click');
});


//文件上传控件内容改变时的ajax上传函数
function file_jia_change(){
    $('#form_file_jia').ajaxSubmit({  
                    type: 'post',  
                    dataType:"json",
                    async : true,
                    success: function(msg){
                        if(msg.result==='error'){
                            //alert(msg.error);
                            alert('图片超过5M的大小限制，请重新选择图片');
                            return false;
                        }
                        var img_url=msg.src;
                        var img_url_thumb=msg.src_thumb;
                        creat_img($('#file_jia'),img_url,img_url_thumb);
                        yz_img();
                        return true; 
                    },  
                    error: function(){  
                        alert('上传图片失败,三星前置摄像头照片可能导致此错误');
                        return false;
                    }  
                });  
}
//创建个img标签并且插入obj前面
var goods_img="";
function creat_img(obj,img_url,img_url_thumb){
    var str='<div class="div_goods_img"><img src="" class="empty_img" /><img class="goods_img" src=/'+img_url_thumb+' /><a title="删除"></a></div>';
    obj.before(str);
    $('#img_count').html($('.goods_img').length);
    if($('.goods_img').length>3){
        obj.css('display','none');//隐藏添加图片按钮
    }
    if(goods_img===''){
        goods_img+=img_url;
    }else{
        goods_img+='+img+'+img_url;
    }
    $('input[name=goods_img]').attr('value',goods_img);
};


//动态生成的元素添加事件
$('body').on('mouseover','.div_goods_img',function(){$(this).children('a').css('display','block');});
$('body').on('mouseout','.div_goods_img',function(){$(this).children('a').css('display','none');});
$('body').on('click','.div_goods_img a',function(){
    $('#file_jia').css('display','block');
    $(this).parent().remove();
    var img_url=$(this).prev().attr('src').substr(1);
    img_url=img_url.replace('/thumb','');
    goods_img=goods_img.replace(img_url+'+img+','');
    goods_img=goods_img.replace(img_url,'');
    $('input[name=goods_img]').attr('value',goods_img);
    $('#img_count').html($('.goods_img').length);
});


//描述字数限制
$('textarea[name=miaoshu]').bind('keyup',function(){
    $('#miaoshu_tishi').css('color','#888');
    var length=$(this).val().length;
    var shengyu=170-length;
    if(length > 169){
    $(this).val($(this).val().substring(0,170));
   }
    $('#miaoshu_tishi').text('（您还可以输入'+shengyu+'个字）');
});

//验证描述
$('textarea[name=miaoshu]').bind('blur',function(){
    yz_miaoshu($(this));
});
function yz_miaoshu(obj){
    if(obj.val()===""){
        $('#miaoshu_tishi').css('color','red');
        $('#miaoshu_tishi').html("(问题描述为空，请输入)");
	return false;
	}else if(is_feifa(obj.val())){
            $('#miaoshu_tishi').css('color','red');
            $('#miaoshu_tishi').html("( 含有非法字符："+is_feifa(obj.val())+")");
            return false;
            }else{
                return true;
            }
}

//验证手机
$('input[name=shouhou_iphone]').bind('blur',function(){
    yz_shouji($(this));
});
function yz_shouji(obj){
    if(obj.val()===""){
        $('#lianxi_tishi').html("(手机号码为空，请输入)");
	return false;
	}else if(!is_shoujihao(obj.val())){
            $('#lianxi_tishi').html("(不正确，请输入正确的手机号码)");
            return false;
            }else{
                $('#lianxi_tishi').html("");
                return true;
            }
		
}


//验证文件是否上传了
function yz_img(){
    if( $('#img_count').html()=='0'){
        $('#img_tishi').css('color','red');
        $('#img_tishi').html("(未上传图片，请至少上传1张)");
	return false;
    }else{
        $('#img_tishi').html("");
        return true;
    }
}