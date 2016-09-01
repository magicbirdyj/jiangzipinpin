$('.qrsc').bind('click',function(){
    if(window.confirm('确定要上传网站首页轮播广告吗？')){
        var name=$(this).attr('id');
        if($('form[name='+name+']').children('input').attr('value')===''){
            alert('您没有更改广告图片');
        }else{
            $('form[name='+name+']').submit();
        }
    };
});

//url_xuhao改变时候，text_url_xuhao 跟着改变
$('.url').bind('change',function(){
    var value=$(this).val();
    var id=$(this).attr('id');
    $("form[name=qrsc_"+id+"]>input[name=url]").val(value);
});

$('.goods_img').bind('mouseover',function(){
    var src=$(this).attr('src');
    $('.fangda').attr('src',src);
    $('.fangda').css('display','block');
    
});
$('.goods_img').bind('mousemove',function(e){
    $('.fangda').css('display','block');
    var pointx=e.pageX+100;
    var pointy=e.pageY-150;
    $('.fangda').css('top',pointy);
    $('.fangda').css('left',pointx);
});
$('.goods_img').bind('mouseout',function(){
    $('.fangda').css('display','none');
});



$('.goods_img').bind('click',function(){
    var id=$(this).attr('id');
    $('input[name='+id+']').trigger('click');
});




$('input[type=file]').bind('change',function(){
    if(check_file_image($(this),$("#span_touxiang"),true)){
        file_jia_change($(this));
    };
    
});

//文件上传控件内容改变时的ajax上传函数
function file_jia_change(obj){
    var id=obj.attr('name');
    $("#form_"+id).ajaxSubmit({  
                    type: 'post',  
                    dataType:"json",
                    async : false,
                    success: function(msg){
                        var img_url='';
                        if(id==='file_1'){
                            img_url=msg.file_1;
                        }else if(id==='file_2'){
                            img_url=msg.file_2;
                        }else if(id==='file_3'){
                            img_url=msg.file_3;
                        }else if(id==='file_4'){
                            img_url=msg.file_4;
                        }
                        $('#'+id).attr('src','/'+img_url);
                        $('input[name=text_'+id+']').attr('value',img_url);
                        return true; 
                    },  
                    error: function(){  
                        alert('上传文件出错');
                        return false;
                    }  
                });  
}