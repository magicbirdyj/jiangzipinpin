// JavaScript Document
//onfocus
//onblur
//var obj_form=document.sv_cont;
//var server_content=obj_form.server_content;
var input_file_img='<input name="file_img" type="file" id="file_img" />';
var input_file_img_zhanshitu='<input name="file_img_zhanshitu" type="file"  />';
var obj=document.getElementById("infor");
var select_cate_0=document.release_goods.cate_0;
var select_cate_1=document.release_goods.cate_1;
select_cate_0.onchange=function (){cate_0_onchange(this.selectedIndex);};
select_cate_0.length=arr_cate_0.length;
select_cate_1.length=arr_cate_1[0][0].length;
for(var i=0;i<arr_cate_0.length;i++ ){
	select_cate_0.options[i].text=arr_cate_0[i][0];
        select_cate_0.options[i].value=arr_cate_0[i][1];
	}

select_cate_1.options[0].text=arr_cate_1[0][0][1];
select_cate_1.options[0].value=arr_cate_1[0][0][0];
function cate_0_onchange(index){
	obj.innerHTML="";
	cate_0_index=index;
	select_cate_1.length=0;
	select_cate_1.length=arr_cate_1[index].length;
	for(var i=0;i<arr_cate_1[index].length;i++){
		select_cate_1.options[i].text=arr_cate_1[index][i][1];
                select_cate_1.options[i].value=arr_cate_1[index][i][0];
		}
        get_shuxing($('select[name=cate_1]').val());
	}

//给分类一个默认值
$("select[name=cate_0]").val(default_cat_0);
var selectedIndex=$("select[name=cate_0]").prop('selectedIndex');
cate_0_onchange(selectedIndex);
$("select[name=cate_1]").val(default_cat_id);
get_shuxing($('select[name=cate_1]').val());






$(':text[name=title]').bind('blur',function(){text_blue($(this),$('#infor'),'商品标题');});
$('textarea[name=goods_jianjie]').bind('blur',function(){text_blue($(this),$('#infor'),'商品简介');});
$(':text[name=units]').bind('blur',function(){text_blue($(this),$('#infor'),'单位规格');});
$('#button_jia').bind('click',function(){tianjia($(this));});
$(':text[name=price]').bind('focus',function(){$('#infor').css('display','none');});
$(':text[name=price]').bind('blur',function(){$('#infor').css('display','block');price_blue($(this),$('#infor'));});
$(':text[name=yuan_price]').bind('focus',function(){$('#infor').css('display','none');});
$(':text[name=yuan_price]').bind('blur',function(){$('#infor').css('display','block');price_blue($(this),$('#infor'));});
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



function price_blue(obj,obj_info,msg){
    var reg=/^\d+\.?\d{0,2}$/gi;
    var result= reg.test(obj.val());
    if(result){
        //obj_info.css('display','none');
        obj_info.css('color','#666');
        obj.val(parseFloat(obj.val()).toFixed(2));
        return true;
    }else{
        obj_info.css('display','block');
        obj_info.css('color','red');
        obj_info.html(msg+'没填或不符合规范');
        setTimeout(infor_none,3000);
        return false;
    }
}










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
//添加商品图片点击+
$('#file_jia').bind('click',function(){
    $('input[name=file_img]').trigger('click');
});
//商品图片上传后
$('body').on('change','input[name=file_img]',function(){
    if(check_file_image($(this),$('#infor'),true)){
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
//创建个img标签并且插入obj前面
var goods_img="";
function creat_img(obj,img_url,img_url_thumb){
    var str='<div class="div_goods_img"><img src="" class="empty_img" /><img class="goods_img" src=/'+img_url_thumb+' /><a title="删除"></a></div>';
    obj.before(str);
    var length=obj.siblings('.div_goods_img').length;
    $('#img_count').html(length);
    if(length>3){
        obj.css('display','none');//隐藏添加图片按钮
    }
    if(goods_img===''){
        goods_img+=img_url;
    }else{
        goods_img+='+img+'+img_url;
    }
    $('input[name=goods_img]').attr('value',goods_img);
    $('#form_file_jia').html(input_file_img);
};


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



$('#xiayibu').bind('click',xiayibu);
function xiayibu(){
    $('#info').css('display','block');
    var aa=$('input[name=goods_img]').attr('value');
    var bb=$('select[name=cate_1]').val();
    if(aa.indexOf("undefined")!==-1){
        alert('商品图片因超过5M或其它原因未上传成功');
    }else if(bb=='请选择分类'){
        alert('您还没选择商品分类');
    }else if(text_blue($('input[name=title]'),$('#infor'),'商品标题')&&text_blue($('textarea[name=goods_jianjie]'),$('#infor'),'商品简介')&&text_blue($('input[name=units]'),$('#infor'),'单位规格')&&check_file_shouji($('input[name=goods_zhanshitu]'),$('#infor'))&&check_file_shouji($('input[name=goods_img]'),$('#infor'))&&price_blue($('input[name=price]'),$('#infor'),'乐享价')&&price_blue($('input[name=yuan_price]'),$('#infor'),'原价')&&price_blue($('input[name=fanxian]'),$('#infor'),'乐享红包')){
        $('#infor').css('display','none');
        $('#fanhui_1').css('display','none');
        $('.tr').css('display','none');
        $('.xuxian').css('display','none');
        $('textarea[name=goods_jianjie]').css('display','none');
        $('#xiayibu').css('display','none');
        $('#spms').css('display','block');
        $('#bianjiqi').css('display','block');
        scroll(0,0);
    }
    return false;
}
function fabu(){
    //text_blue($('input[name=title]'),$('#info_title'));
    var aa=$('input[name=goods_img]').attr('value');
    var bb=$('select[name=cate_1]').val();
    if(aa.indexOf("undefined")!==-1){
        alert('商品图片因超过5M或其它原因未上传成功');
    }else if(bb=='请选择分类'){
        alert(您还没选择商品分类);
    }else if(text_blue($('input[name=title]'),$('#infor'),'商品标题')&&text_blue($('textarea[name=goods_jianjie]'),$('#infor'),'商品简介')&&text_blue($('input[name=units]'),$('#infor'),'单位规格')&&check_file_shouji($('input[name=goods_zhanshitu]'),$('#infor'))&&check_file_shouji($('input[name=goods_img]'),$('#infor'))&&price_blue($('input[name=price]'),$('#infor'),'乐享价')&&price_blue($('input[name=yuan_price]'),$('#infor'),'原价')&&price_blue($('input[name=fanxian]'),$('#infor'),'乐享红包')){
        $('form[name=release_goods]').submit();
    }
    return false;
}
$('#fanhui_2').bind('click',fanhui);
function fanhui(){
    $('#fanhui_1').css('display','block');
    $('.tr').css('display','block');
    $('.xuxian').css('display','block');
    $('#xiayibu').css('display','block');
    $('textarea[name=goods_jianjie]').css('display','block');
    $('#spms').css('display','none');
    $('#bianjiqi').css('display','none');
}

//得到具体分类的属性
$('select[name=cate_1]').bind('change',function(){
    get_shuxing($('select[name=cate_1]').val());
});

    function get_shuxing(cat_id){
        var url='/Home/Ajaxnologin/get_shuxing';
        var data={
            'cat_id':cat_id,
            'check':'get_shuxing'
        };
        $.ajax({
            type:'post',
            async : false,
            url:url,
            datatype:'json',
            data:data,
            success:function(msg){
                $('.shuxing').remove();
                $('#shuxing_xuxian').before(msg);
                
            }
        });
    }


//增加商品自选属性js
//
//
//增加属性值
$('body').on('click','.input_button_sxz',function(){
    var index=$(this).parent().prevAll('div.zx_tr').length;
    var str='<div class="js_div ">';
    str+='<input name="zx_shuxingzhi['+index+'][]" class="tr_td1_input" type="text" placeholder="请输入属性值"/>';
    str+='<a class="del_a del_a1">删除</a>';
    str+='</div>';
    $(this).before(str);
});
//动态生成元素添加事件

$('body').on('click','.del_a1',function(){
        $(this).parent('.js_div').remove();
    });




//增加属性
$('#add_sx').bind('click',function(){
    //var input_name=$(this).parent().prev('.tr').children('div.tr_td1').children('input.tr_td1_input').attr('name');
    //var index=parseInt(input_name.substr(8))+1;
    var str='<div class="tr zx_tr">';
    str+='<div class="js_div ">';
    str+='<input name="zx_shuxing[]" class="tr_td1_input" type="text" placeholder="请输入属性名" />';
    str+='<a class="del_a">删除</a></div>';
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
