// JavaScript Document
//onfocus
//onblur
//创建个img标签并且插入obj前面
$('#insert_img_one').css('display','none');
$('#insert_img_one').next().css('display','none');
$('input[name=head_url]').val('/Public/Home/Mobile/Images/public/jzpp_logo.jpg');
var goods_img="";
$('select[name=status]').bind('change',function(){st_change();});
$(':text[name=shop_name]').bind('focus',function(){text_focus($('#info_title'),'店铺名不能重名');});
$(':text[name=shop_name]').bind('blur',function(){title_blue();});


$(':text[name=qq]').bind('focus',function(){text_focus($('#info_qq'),'填写客服QQ');});
$(':text[name=qq]').bind('blur',function(){text_blue($(this),$('#info_qq'),'客服QQ');});
$(':text[name=tel]').bind('focus',function(){text_focus($('#info_tel'),'填写客服电话');});
$(':text[name=tel]').bind('blur',function(){text_blue_shouji($(this),$('#info_tel'),'客服电话');});
$('#xiayibu').bind('click',function(){fabu();});

function title_blue(){
    var a=text_blue($('input[name=shop_name]'),$('#info_title'),'商品标题');
    if(a){
        b=title_ajax();
        if(b){
             $('#info_title').css('color','#666');
            $('#info_title').html('&radic;');
        }else{
            $('#info_title').css('color','red');
            $('#info_title').html('该店铺名重复，请重新输入');
        }
        return b;
    }else{
        return false;
    }
}
//检查店铺名是否有重名
function title_ajax(){
    var count=1;
    var url='/Admin/Shopsmanage/title_ajax.html';
    var data={
        shop_name:$('input[name=shop_name]').val(),
        check:"title_ajax"
    };
   $.ajax({
        type:'post',
        async : false,
        url:url,
        data:data, 
        datatype:'json',
        success:function(msg){
            count=msg;
        }
    });
    if(count==0){
        return true;
    }else{
        return false;
    }
}
    


function st_change(){
    var value=$("select[name=status]>option:selected").val();
    if(value=='自营'){
        $('#insert_img_one').css('display','none');
        $('#insert_img_one').next().css('display','none');
        $('.div_goods_img #a_zhanshitu').click();
        $('input[name=head_url]').val('/Public/Home/Mobile/Images/public/jzpp_logo.jpg');
    }else{
        $('#insert_img_one').css('display','block');
        $('#insert_img_one').next().css('display','block');
        $('input[name=head_url]').val('');
    }
}






function fabu(){
    var aa=$('input[name=head_img]').attr('value');
    if(aa.indexOf("undefined")!==-1){
        alert('商品图片因超过5M或其它原因未上传成功');
    }else{
        var a=title_blue();
        var b=check_file($('input[name=head_img]'),$('#span_head_img'));
        var c=text_blue($('input[name=qq]'),$('#info_qq'),'客服QQ');
        var d=text_blue_shouji($('input[name=tel]'),$('#info_tel'),'客服电话');
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
                            //alert(msg.error);//测试error才用
                            alert('图片超过5M的大小限制，请重新选择图片');
                            return false;
                        }
                        var img_url=msg.src;
                        var img_url_thumb=msg.src_thumb;
                        if(id=='#form_file_jia'){
                            creat_img($('#file_jia'),img_url,img_url_thumb);
                        }else{
                            creat_zhanshitu($('#file_jia_zhanshitu'),img_url,img_url_thumb);
                        }
                        /*应该不再需要这段
                        if(String(img_url)=== "undefined"){
                            alert('商品图片因超过5M或其它原因未上传成功,请重新上传');
                            return false
                        }*/
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


function creat_zhanshitu(obj,img_url,img_url_thumb){
    var str='<div class="div_goods_img"><img src="" class="empty_img" /><img class="goods_img" src=/'+img_url_thumb+' /><a id="a_zhanshitu" title="删除"></a></div>';
    obj.before(str);
    obj.css('display','none');
    $('input[name=head_img]').attr('value',img_url);
};
$('body').on('click','.div_goods_img #a_zhanshitu',function(){
    $('#file_jia_zhanshitu').css('display','block');
    $(this).parent().remove();
    $('input[name=head_img]').attr('value',"");
});



