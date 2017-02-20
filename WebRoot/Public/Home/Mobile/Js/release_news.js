// JavaScript Document
//onfocus
//onblur
//var obj_form=document.sv_cont;
//var server_content=obj_form.server_content;

var input_file_img_zhanshitu='<input name="file_img_zhanshitu" type="file"  />';
var obj=document.getElementById("infor");







$(':text[name=title]').bind('blur',function(){text_blue($(this),$('#infor'),'文章标题');});

$('#fabu').bind('click',function(){fabu();});



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














//添加展示图片点击+
$('#file_jia_zhanshitu').bind('click',function(){
    $('input[name=file_img_zhanshitu]').trigger('click');
});
//展示图片上传后
$('body').on('change','input[name=file_img_zhanshitu]',function(){
    if(check_file_image($(this),$('#infor'),true)){
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
                        var img_url_thumb=msg.src_thumb;
                       
                        creat_zhanshitu($('#file_jia_zhanshitu'),img_url,img_url_thumb);
                        
                       
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



function creat_zhanshitu(obj,img_url,img_url_thumb){
    var str='<div class="div_goods_img"><img src="" class="empty_img" /><img class="goods_img" src=/'+img_url_thumb+' /><a id="a_zhanshitu" title="删除"></a></div>';
    obj.before(str);
    obj.css('display','none');
    $('input[name=goods_zhanshitu]').attr('value',img_url);
    $('#form_file_jia_zhanshitu').html(input_file_img_zhanshitu);
};

$('body').on('click','.div_goods_img #a_zhanshitu',function(){
    $('#file_jia_zhanshitu').css('display','block');
    $(this).parent().remove();
    $('input[name=goods_zhanshitu]').attr('value',"");
});

//动态生成的元素添加事件
$('body').on('mouseover','.div_goods_img',function(){$(this).children('a').css('display','block');});
$('body').on('mouseout','.div_goods_img',function(){$(this).children('a').css('display','none');});
$('body').on('click','.div_goods_img a',function(){
    $('#file_jia').css('display','block');
    var length=$(this).parent().siblings('.div_goods_img').length;
    $(this).parent().remove();
    var img_url=$(this).prev().attr('src').substr(1);
    img_url=img_url.replace('/thumb','');
    goods_img=goods_img.replace(img_url+'+img+','');
    goods_img=goods_img.replace('+img+'+img_url,'');
    goods_img=goods_img.replace(img_url,'');
    $('input[name=goods_img]').attr('value',goods_img);
    $('#img_count').html(length);
});





function fabu(){
    //text_blue($('input[name=title]'),$('#info_title'));
    var aa=$('input[name=goods_zhanshitu]').attr('value');
    if(aa.indexOf("undefined")!==-1){
        alert('商品图片因超过5M或其它原因未上传成功');
    }else if(text_blue($('input[name=title]'),$('#infor'),'文章标题')){
        $('form[name=release_news]').submit();
    }
    return false;
}
