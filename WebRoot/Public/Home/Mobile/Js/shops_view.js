// JavaScript Document
//var backurl=document.referrer;


//上传文件必须是图片
$('input[name=file_img]').bind('change',function(){
    if(check_file_image($(this),$('#file_img_info'),true)){
        file_jia_change();
    };
    $('input[name=file_img]').val('');
});



//确认收衣按钮绑定事件
$('#shops_confirm').bind('click',function(){
    var aa=$('input[name=goods_img]').attr('value');
    if(aa.indexOf("undefined")!==-1){
        alert('评价图片因超过5M或其它原因未上传成功');
        return false;
    }
    var bb=$('textarea[name=pingjia_text]').html();
    if(bb==''){
        alert('您还没填写备注');
        return false;
    }
    $('form[name=shops_confirm]').submit();
    return true;
    
});


//添加商品图片点击+
$('#file_jia').bind('click',function(){
    $('input[name=file_img]').trigger('click');
});


//文件上传控件内容改变时的ajax上传函数
function file_jia_change(){
    $("#form_file_jia").ajaxSubmit({  
                    type: 'post',  
                    dataType:"json",
                    async : true,
                    success: function(msg){
                        if(msg.result==='error'){
                            //alert(msg.error);//测试error才用
                            alert('图片超过5M的大小限制，请重新选择图片');
                            return false;
                        }
                        var img_url=msg.src;
                        var img_url_thumb=msg.src_thumb;
                        creat_img($('#file_jia'),img_url,img_url_thumb);
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
    if($('.goods_img').length>9){
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
    var img_url=$(this).prev().attr('src').substr(1).replace('thumb/','');
    goods_img=goods_img.replace(img_url+'+img+','');
    goods_img=goods_img.replace(img_url,'');
    $('input[name=goods_img]').attr('value',goods_img);
    $('#img_count').html($('.goods_img').length);
});