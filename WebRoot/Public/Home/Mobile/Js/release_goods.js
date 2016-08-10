// JavaScript Document
//onfocus
//onblur
//var obj_form=document.sv_cont;
//var server_content=obj_form.server_content;

$('select[name=server_content]').bind('change',function(){sc_change();});
$(':text[name=title]').bind('focus',function(){$('#infor').css('display','none');});
$(':text[name=title]').bind('blur',function(){$('#infor').css('display','block');text_blue_shouji($(this),$('#infor'),'商品标题');});
$('input[name=file_img]').bind('change',function(){
    if(check_file_image_shouji($(this),$('#infor'),true)){
        file_jia_change();
    };
    $('input[name=file_img]').val('');
});
$('#button_jia').bind('click',function(){tianjia($(this));});
$(':text[name=price]').bind('focus',function(){$('#infor').css('display','none');});
$(':text[name=price]').bind('blur',function(){$('#infor').css('display','block');price_blue($(this),$('#infor'));});
$(':text[name=yuan_price]').bind('focus',function(){$('#infor').css('display','none');});
$(':text[name=yuan_price]').bind('blur',function(){$('#infor').css('display','block');price_blue($(this),$('#infor'));});
$('#fabu').bind('click',function(){fabu();});
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




//给性别radio一个默认值
$('input[name=radio_sex]:eq(0)').attr('checked','checked');

 //引入在线编辑器
    var editor;
    KindEditor.options.filterMode = false;
    KindEditor.ready(function(K) {
        var options = {
            items:[
        'image', 'media',  'link'
],
            uploadJson:"/Home/Kindeditor/editor_check",
            allowMediaUpload:false,//true时显示视音频上传按钮。
            allowFlashUpload:false,//true时显示Flash上传按钮。
            allowFileUpload:false,//true时显示文件上传按钮。
            allowFileManager:false,//true时显示浏览远程服务器按钮。
            //autoHeightMode : true,//允许自动高度
            //afterCreate : function() {
                //this.loadPlugin('autoheight');
            //},//自动高度
            width:'100%',
            height:'450px',
            fontSizeTable:['9px', '10px', '12px', '14px', '16px', '18px', '24px', '32px']//指定文字大小。
        };
        editor = K.create('textarea[name="content"]',options);
       //给编辑器图标加文字
        $('.ke-icon-image').html('添加图片');
        $('.ke-icon-media').html('添加视频');
        $('.ke-icon-link').html('添加链接');
    });    

function sc_change(){
    $('form[name=sv_cont]').submit();
}

function price_blue(obj,obj_info){
    var reg=/^\d+\.?\d{0,2}$/gi;
    var result= reg.test(obj.val());
    if(result){
        obj_info.css('display','none');
        obj_info.css('color','#666');
        obj.val(parseFloat(obj.val()).toFixed(2));
        setTimeout(infor_none,3000);
        return true;
    }else{
        obj_info.css('color','red');
        obj_info.html('不符合规范，请填入正确价格，如100.00');
        setTimeout(infor_none,3000);
        return false;
    }
}









function fabu(){
    $('#info').css('display','block');
    //text_blue($('input[name=title]'),$('#info_title'));
    var aa=$('input[name=goods_img]').attr('value');
    if(aa.indexOf("undefined")!==-1){
        alert('商品图片因超过5M或其它原因未上传成功');
    }else if(text_blue_shouji($('input[name=title]'),$('#infor'),'商品标题')&&check_file_shouji($('input[name=goods_img]'),$('#infor'))&&price_blue($('input[name=price]'),$('#infor'))&&price_blue($('input[name=yuan_price]'),$('#infor'))){
        $('form[name=release_goods]').submit();
        
    }
    return false;
}

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








$('#xiayibu').bind('click',xiayibu);
function xiayibu(){
    $('#info').css('display','block');
    var aa=$('input[name=goods_img]').attr('value');
    if(aa.indexOf("undefined")!==-1){
        alert('商品图片因超过5M或其它原因未上传成功');
    }else if(text_blue_shouji($('input[name=title]'),$('#infor'),'商品标题')&&check_file_shouji($('input[name=goods_img]'),$('#infor'))&&price_blue($('input[name=price]'),$('#infor'))&&price_blue($('input[name=yuan_price]'),$('#infor'))){
        $('#infor').css('display','none');
        $('#fanhui_1').css('display','none');
        $('.tr').css('display','none');
        $('.xuxian').css('display','none');
        $('#xiayibu').css('display','none');
        $('#spms').css('display','block');
        $('#bianjiqi').css('display','block');
        scroll(0,0);
    }
    return false;
}

$('#fanhui_2').bind('click',fanhui);
function fanhui(){
    $('#fanhui_1').css('display','block');
    $('.tr').css('display','block');
    $('.xuxian').css('display','block');
    $('#xiayibu').css('display','block');
    $('#spms').css('display','none');
}



