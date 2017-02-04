// JavaScript Document
//onfocus
//onblur
//创建个img标签并且插入obj前面
var goods_img="";
$('select[name=server_content]').bind('change',function(){sc_change();});
$(':text[name=title]').bind('focus',function(){text_focus($('#info_title'),'商品标题可以尽量多包含关键字');});
$(':text[name=title]').bind('blur',function(){text_blue($(this),$('#info_title'),'商品标题');});
$('textarea[name=goods_jianjie]').bind('focus',function(){text_focus($('#info_jianjie'),'商品简介控制在6行以内');});
$('textarea[name=goods_jianjie]').bind('blur',function(){text_blue($(this),$('#info_jianjie'),'商品简介');});


$(':text[name=price]').bind('focus',function(){text_focus($('#info_price'),'填写售价');});
$(':text[name=price]').bind('blur',function(){price_blue($(this),$('#info_price'));});
$(':text[name=yuan_price]').bind('focus',function(){text_focus($('#info_yuan_price'),'填写成本价');});
$(':text[name=yuan_price]').bind('blur',function(){price_blue($(this),$('#info_yuan_price'));});



$('#xiayibu').bind('click',function(){fabu();});







    

function sc_change(){
    $('form[name=sv_cont]').submit();
}

function price_blue(obj,obj_info){
    var reg=/^\d+\.?\d{0,2}$/gi;
    var result= reg.test(obj.val());
    if(result){
        obj_info.html('&radic;');
        obj_info.css('color','#666');
        return true;
    }else{
        obj_info.css('color','red');
        obj_info.html('不符合规范，请填入正确金额，如100或者9.99');
        return false;
    }
}










function fabu(){
    
    var bb=$('input[name=goods_zhanshitu]').attr('value');
    if(bb.indexOf("undefined")!==-1){
        alert('商品图片因超过5M或其它原因未上传成功');
    }else{
        var a=text_blue($('input[name=title]'),$('#info_title'),'商品标题');
        var b=check_file($('input[name=goods_zhanshitu]'),$('#span_zhanshitu'));
        var c=price_blue($('input[name=price]'),$('#info_price'));
        var d=price_blue($('input[name=cost_price]'),$('#info_yuan_price'));
       
        if(a&&b&&c&&d){
            $('form[name=release_goods]').submit();
        }
    }
    
    return false;
}

//添加展示图片点击+
$('#file_jia_zhanshitu').bind('click',function(){
    $('input[name=file_img_zhanshitu]').trigger('click');
});
//展示图片上传后
$('input[name=file_img_zhanshitu]').bind('change',function(){
    if(check_file_image($(this),$('#span_zhanshitu'),true)){
        file_jia_change("#form_file_jia_zhanshitu");
    };
});






//文件上传控件内容改变时的ajax上传函数
function file_jia_change(id){
    $(id).ajaxSubmit({  
                    type: 'post',  
                    dataType:"json",
                    async : true,
                    success: function(msg){
                        if(msg.result==='error'){
                            alert(msg.error);//测试error才用
                            //alert('图片超过5M的大小限制，请重新选择图片');
                            return false;
                        }
                        var img_url=msg.src;
                        //var img_url_thumb=msg.src_thumb;
                      
                        creat_zhanshitu($('#file_jia_zhanshitu'),img_url);
                        
                       
                        return true; 
                    },  
                    error: function(){  
                        alert('上传图片失败,三星前置摄像头照片可能导致此错误');
                        return false;
                    }  
                });  
}



//动态生成的元素添加事件
$('body').on('mouseover','.div_goods_img',function(){$(this).children('a').css('display','block');});
$('body').on('mouseout','.div_goods_img',function(){$(this).children('a').css('display','none');});
$('body').on('click','.div_goods_img #a_shangpintu',function(){
    $('#file_jia').css('display','block');
    $(this).parent().remove();
    var img_url=$(this).prev().attr('src').substr(1);
    img_url=img_url.replace('/thumb','');
    goods_img=goods_img.replace(img_url+'+img+','');
    goods_img=goods_img.replace('+img+'+img_url,'');
    goods_img=goods_img.replace(img_url,'');
    $('input[name=goods_img]').attr('value',goods_img);
    $('#img_count').html($('.goods_shangpintu').length);
});

function creat_zhanshitu(obj,img_url){
    var str='<div class="div_goods_img"><img src="" class="empty_img" /><img class="goods_img" src=/'+img_url+' /><a id="a_zhanshitu" title="删除"></a></div>';
    obj.before(str);
    obj.css('display','none');
    $('input[name=goods_zhanshitu]').attr('value',img_url);
};
$('body').on('click','.div_goods_img #a_zhanshitu',function(){
    $('#file_jia_zhanshitu').css('display','block');
    $(this).parent().remove();
    $('input[name=goods_zhanshitu]').attr('value',"");
});



