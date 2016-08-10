// JavaScript Document
//onfocus
//onblur
//var obj_form=document.sv_cont;
//var server_content=obj_form.server_content;
$('select[name=server_content]').bind('change',function(){sc_change();});
$(':text[name=title]').bind('focus',function(){text_focus($('#info_title'),'商品标题可以尽量多包含关键字');});
$(':text[name=title]').bind('blur',function(){text_blue($(this),$('#info_title'));});
$('input[name=file_img]').bind('change',function(){
    if(check_file_image($(this),$('#span_touxiang'),true)){
        file_jia_change();
    };
});
$(':text[name=price]').bind('focus',function(){text_focus($('#info_price'),'填写售价');});
$(':text[name=price]').bind('blur',function(){price_blue($(this),$('#info_price'));});
$(':text[name=yuan_price]').bind('focus',function(){text_focus($('#info_yuan_price'),'填写原价');});
$(':text[name=yuan_price]').bind('blur',function(){price_blue($(this),$('#info_yuan_price'));});
$('#xiayibu').bind('click',function(){fabu();});
//动态生成的元素添加事件
$('body').on('mouseover','.div_goods_img',function(){$(this).children('a').css('display','block');});
$('body').on('mouseout','.div_goods_img',function(){$(this).children('a').css('display','none');});
$('body').on('click','.div_goods_img a',function(){
    $('#file_jia').css('display','block');
    $(this).parent().remove();
    var img_url=$(this).prev().attr('src').substr(1);
    goods_img=goods_img.replace('/'+img_url+'+img+','');
    goods_img=goods_img.replace(img_url+'+img+','');
    goods_img=goods_img.replace('/'+img_url,'');
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
        'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image','multiimage',
        'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
        'anchor', 'link', 'unlink', '|', 'about'
],
            uploadJson:"/Home/Member/editor_check",
            allowMediaUpload:false,//true时显示视音频上传按钮。
            allowFlashUpload:false,//true时显示Flash上传按钮。
            allowFileUpload:false,//true时显示文件上传按钮。
            allowFileManager:false,//true时显示浏览远程服务器按钮。
            height:'800px',
            fontSizeTable:['9px', '10px', '12px', '14px', '16px', '18px', '24px', '32px']//指定文字大小。
        };
        editor = K.create('textarea[name="content"]',options);
    });


function sc_change(){
    $('form[name=sv_cont]').submit();
}

function price_blue(obj,obj_info){
    var reg=/^\d+\.?\d{0,2}$/gi;
    var result= reg.test(obj.val());
    if(result){
        obj_info.html('&radic;');
        obj_info.css('color','#666');
        obj.val(parseFloat(obj.val()).toFixed(2));
        return true;
    }else{
        obj_info.css('color','red');
        obj_info.html('不符合规范，请填入正确价格，如100.00');
        return false;
    }
}



var i=1;
function tianjia(obj){
    var str=' <div  class="tr" id="insert_img"><div class="tr_td1"><input type="button" value="删除" class="bt_delete" /></div><input name="file_imgi" type="file" class="tr_td2 input_img1" /><span id="span_touxiang2"></span></div>';
    if($('input[type=file]').length>3){
        alert('最多添加4张图片作为商品展示图');
        return false;
    }
    obj.before(str);
    $('input[name=file_imgi]').attr('name','file_img'+i);
    i++;
}

/*上传商品展示图片相关暂时注释
function delete_file(obj){
    obj.parent().parent().remove();
}
*/


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
                        var img_url=msg.src;
                        creat_img($('#file_jia'),img_url);
                        if(String(img_url)=== "undefined"){
                            alert('商品图片因超过5M或其它原因未上传成功,请重新上传');
                        }
                        return true; 
                    },  
                    error: function(){  
                        alert('上传文件出错');
                        return false;
                    }  
                });  
}

//创建个img标签并且插入obj前面
function creat_img(obj,img_url){
    var str='<div class="div_goods_img"><img src="" class="empty_img" /><img class="goods_img" src=/'+img_url+' /><a title="删除"></a></div>';
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






function fabu(){
    //text_blue($('input[name=title]'),$('#info_title'));
    //check_file_image($('input[name=file_img]'),$('#span_touxiang'),false);
    var aa=$('input[name=goods_img]').attr('value');
    if(aa.indexOf("undefined")!==-1){
        alert('商品图片因超过5M或其它原因未上传成功');
    }else{
        price_blue($('input[name=price]'),$('#info_price'));
        price_blue($('input[name=yuan_price]'),$('#info_yuan_price'));
        //if(text_blue($('input[name=title]'),$('#info_title'))&&check_file_image($('input[name=file_img]'),$('#span_touxiang'),false)&&price_blue($('input[name=price]'),$('#info_price'))&&price_blue($('input[name=yuan_price]'),$('#info_yuan_price'))){
        if(text_blue($('input[name=title]'),$('#info_title'))&&price_blue($('input[name=price]'),$('#info_price'))&&price_blue($('input[name=yuan_price]'),$('#info_yuan_price'))){    
            $('form[name=release_goods]').submit();
        }
    }
    
    return false;
}
