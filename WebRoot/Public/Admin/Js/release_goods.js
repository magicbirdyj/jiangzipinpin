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
$(':text[name=units]').bind('focus',function(){text_focus($('#info_units'),'如1个（3-4斤）');});
$(':text[name=units]').bind('blur',function(){text_blue($(this),$('#info_units'),'商品单位重量 ');});


$(':text[name=price]').bind('focus',function(){text_focus($('#info_price'),'填写售价');});
$(':text[name=price]').bind('blur',function(){price_blue($(this),$('#info_price'));});
$(':text[name=yuan_price]').bind('focus',function(){text_focus($('#info_yuan_price'),'填写原价');});
$(':text[name=yuan_price]').bind('blur',function(){price_blue($(this),$('#info_yuan_price'));});
$(':text[name=fanxian]').bind('focus',function(){text_focus($('#info_fanxian'),'填写乐享红包，金额为1-200之间');});
$(':text[name=fanxian]').bind('blur',function(){fanxian_blue($(this),$('#info_fanxian'));});
//$(':text[name=tuan_price]').bind('focus',function(){text_focus($('#info_tuan_price'),'填写团购价');});
//$(':text[name=tuan_price]').bind('blur',function(){price_blue($(this),$('#info_tuan_price'));});
$('#xiayibu').bind('click',function(){fabu();});





//给1元购和抽奖radio一个默认值
//$('input[name=radio_1yuangou]:eq(1)').attr('checked','checked');
//$('input[name=radio_choujiang]:eq(1)').attr('checked','checked');

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
        'flash', 'media', 'insertfile', 'table', 'hr','emoticons', 'baidumap', 'pagebreak',
        'anchor', 'link', 'unlink', '|', 'about'
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
            width:'760px',
            height:'450px',
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
        return true;
    }else{
        obj_info.css('color','red');
        obj_info.html('不符合规范，请填入正确金额，如100或者9.99');
        return false;
    }
}

function fanxian_blue(obj,obj_info){
    var reg=/^\d+\.?\d{0,2}$/gi;
    var result= reg.test(obj.val());
    if(result){
        if(obj.val()<1||obj.val()>200){
            obj_info.css('color','red');
            obj_info.html('红包金额必须在1到200之间');
            return false;
        }else{
            obj_info.html('&radic;');
            obj_info.css('color','#666');
        }
        return true;
    }else{
        obj_info.css('color','red');
        obj_info.html('不符合规范，请填入正确金额，如100或者9.99');
        return false;
    }
}








function fabu(){
    
    var aa=$('input[name=goods_img]').attr('value');
    var bb=$('input[name=goods_zhanshitu]').attr('value');
    if(aa.indexOf("undefined")!==-1||bb.indexOf("undefined")!==-1){
        alert('商品图片因超过5M或其它原因未上传成功');
    }else{
        var a=text_blue($('input[name=title]'),$('#info_title'),'商品标题');
        var e=text_blue($('textarea[name=goods_jianjie]'),$('#info_jianjie'),'商品简介');
        var h=text_blue($('input[name=units]'),$('#info_units'),'商品单位重量 ');
        var g=check_file($('input[name=goods_img]'),$('#span_shangpintu'));
        var b=check_file($('input[name=goods_zhanshitu]'),$('#span_zhanshitu'));
        var c=price_blue($('input[name=price]'),$('#info_price'));
        var d=price_blue($('input[name=yuan_price]'),$('#info_yuan_price'));
        var f=fanxian_blue($('input[name=fanxian]'),$('#info_fanxian'));
        if(a&&e&&h&&g&&b&&c&&d&&f){
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




//添加商品图片点击+
$('#file_jia').bind('click',function(){
    $('input[name=file_img]').trigger('click');
});
//商品图片上传后
$('input[name=file_img]').bind('change',function(){
    if(check_file_image($(this),$('#span_shangpintu'),true)){
        file_jia_change("#form_file_jia");
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
                        if(id=='#form_file_jia'){
                            creat_img($('#file_jia'),img_url,img_url_thumb);
                        }else{
                            creat_zhanshitu($('#file_jia_zhanshitu'),img_url,img_url_thumb);
                        }
                       
                        return true; 
                    },  
                    error: function(){  
                        alert('上传图片失败,三星前置摄像头照片可能导致此错误');
                        return false;
                    }  
                });  
}

function creat_img(obj,img_url,img_url_thumb){
    var str='<div class="div_goods_img"><img src="" class="empty_img" /><img class="goods_img goods_shangpintu" src=/'+img_url_thumb+' /><a id="a_shangpintu" title="删除"></a></div>';
    obj.before(str);
    $('#img_count').html($('.goods_shangpintu').length);
    if($('.goods_shangpintu').length>3){
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

function creat_zhanshitu(obj,img_url,img_url_thumb){
    var str='<div class="div_goods_img"><img src="" class="empty_img" /><img class="goods_img" src=/'+img_url_thumb+' /><a id="a_zhanshitu" title="删除"></a></div>';
    obj.before(str);
    obj.css('display','none');
    $('input[name=goods_zhanshitu]').attr('value',img_url);
};
$('body').on('click','.div_goods_img #a_zhanshitu',function(){
    $('#file_jia_zhanshitu').css('display','block');
    $(this).parent().remove();
    $('input[name=goods_zhanshitu]').attr('value',"");
});



//增加商品自选属性js
//
//
//增加属性值
$('body').on('click','.input_button_sxz',function(){
    var index=$(this).parent().prevAll('div.zx_tr').length;
    var str='<div class="js_div ">';
    str+='<input name="zx_shuxingzhi['+index+'][]" class="tr_td2 release_select shuxing" type="text" value="请输入属性值"/>';
    str+='<a class="del_a del_a1" title="删除"></a>';
    str+='</div>';
    $(this).before(str);
});
//动态生成元素添加事件
$('body').on('mouseover','.js_div',function(){$(this).children('a').css('display','block');});
$('body').on('mouseout','.js_div',function(){$(this).children('a').css('display','none');});
$('body').on('click','.del_a1',function(){
        $(this).parent('.js_div').remove();
    });




//增加属性
$('#add_sx').bind('click',function(){
    //var input_name=$(this).parent().prev('.tr').children('div.tr_td1').children('input.tr_td1_input').attr('name');
    //var index=parseInt(input_name.substr(8))+1;
    var str='<div class="tr zx_tr">';
    str+='<div class="tr_td1 js_div ">';
    str+='<input name="zx_shuxing[]" class="tr_td1_input release_select shuxing" type="text" value="请输入属性名" />';
    str+='<a class="del_a" title="删除"></a></div>';
    str+='<input class="input_button_sxz" type="button" value="增加属性值"  />';
    str+='</div>';
    $(this).parent().before(str);
});
//动态生成元素添加事件
$('body').on('click','.del_a:not(.del_a1)',function(){
    if(window.confirm('确定要删除该属性（包括属性值）吗？(需点击确认修改生效)')){
        $(this).parents('.tr').remove();
    }
});
$('body').on('click','.shuxing',function(){
    $(this).val('');
});