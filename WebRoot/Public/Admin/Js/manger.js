/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$('select[name=server_content]').bind('change',function(){sc_change();});
function sc_change(){
    $('form[name=sv_cont]').submit();
}

$('#qrxg').bind('click',function(event){
    if(window.confirm('确定要修改分类属性吗？')){
    }else{
        event.preventDefault();
    }
});


//增加属性值
$('body').on('click','.input_button_sxz',function(){
    var index=$(this).parent().prevAll('div.tr').length;
 
    var str='<div class="js_div ">';
    str+='<input name="shuxingzhi['+index+'][]" class="tr_td2 release_select" type="text" value="请输入属性值"/>';
    str+='<a class="del_a del_a1" title="删除"></a>';
    str+='</div>';
    $(this).before(str);
});
//动态生成元素添加事件
$('body').on('mouseover','.js_div',function(){$(this).children('a').css('display','block');});
$('body').on('mouseout','.js_div',function(){$(this).children('a').css('display','none');});
$('body').on('click','.del_a1',function(){if(window.confirm('确定要删除该属性值吗？(需点击确认修改生效)')){
        $(this).parent('.js_div').remove();
    }});




//增加属性
$('#add_sx').bind('click',function(){
    //var input_name=$(this).parent().prev('.tr').children('div.tr_td1').children('input.tr_td1_input').attr('name');
    //var index=parseInt(input_name.substr(8))+1;
    var str='<div class="tr">';
    str+='<div class="tr_td1 js_div ">';
    str+='<input name="shuxing[]" class="tr_td1_input release_select" type="text" value="请输入属性名" />';
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
$('body').on('click','.release_select',function(){
    $(this).val('');
});