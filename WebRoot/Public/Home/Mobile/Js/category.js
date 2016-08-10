//点击选择分类
$('#fenlei_li').bind('click',function(){
    menu_click('fenlei');
});
$('#didian_li').bind('click',function(){
    menu_click('didian');
});
$('#paixu_li').bind('click',function(){
    menu_click('paixu');
});
$('#shaixuan_li').bind('click',function(){
    menu_click('shaixuan');
});

function menu_click(id){
    $('.fenlei_select:not(#'+id+'_select)').css('display','none');
    $('#menu_ul>li:not(#'+id+'_li)').children('span').html('&#xe602;');
    $('#menu_ul>li:not(#'+id+'_li)').css('color','#999');
    $('#menu_ul>li:not(#'+id+'_li)').children('span').css('color','#999');
    var height=$("#fenlei_menu").offset().top;
    $(document).scrollTop(height);
    if($('#'+id+'_select').css('display')==='none'){
        showOverlay(''+id+'_select');
        $('#'+id+'_li').children('span').html('&#xe602;');
        $('#'+id+'_li').css('color','#06c1ae');
        $('#'+id+'_li').children('span').css('color','#06c1ae');
    }else{
        hideOverlay(''+id+'_select');
        $('#'+id+'_li').children('span').html('&#xe602;');
        $('#'+id+'_li').css('color','#999');
        $('#'+id+'_li').children('span').css('color','#999');
    }     
}


function showOverlay(id) {
    $("#overlay").height(pageHeight());
    $("#overlay").width("100%");

    // fadeTo第一个参数为速度，第二个为透明度
    // 多重方式控制透明度，保证兼容性，但也带来修改麻烦的问题
    $("#overlay").fadeTo(200, 0.7);
    //$("#"+id).css('display','block');
    $("#"+id).slideDown(300);
}

/* 隐藏覆盖层 */
function hideOverlay(id) {
    $("#overlay").fadeOut(200);
    //$('#'+id).css('display','none')
    $("#"+id).slideUp(300);
}

/* 当前页面高度 */
function pageHeight() {
    return $(document.body).height();
}

