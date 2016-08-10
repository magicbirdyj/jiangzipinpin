//点击#'xz_daijinquan 显示#div_daijinquan
$('#xz_daijinquan').bind('click',function(){
    showOverlay('div_daijinquan');
    $('#div_daijinquan').animate({'bottom':'0px'},'normal');
});
//点击#daijinquan_fanhui 隐藏选择属性
$('#daijinquan_fanhui').bind('click',function(){
    $('#div_daijinquan').animate({'bottom':'-500px'},'normal',function(){
        hideOverlay('div_daijinquan');
    });

});


$('.daijinquan_ul li').bind('click',function(){
    li_click($(this));
});

daijinquan_each();

function li_click(e){
    e.find('.tb_no_xuanzhong').css('display','none');
    e.find('.tb_xuanzhong').css('display','block');
    e.siblings().find('.tb_no_xuanzhong').css('display','block');
    e.siblings().find('.tb_xuanzhong').css('display','none');
    //给可用代金券赋值
    ky_daijinquan=e.find('.daijinquan_money').text();
    $('#ky_daijinquan').text('- '+ky_daijinquan+' 元');
    $(':hidden[name=ky_daijinquan]').val(ky_daijinquan);
    $('#dues').text(totle_price-ky_daijinquan);
    $(':hidden[name=dues]').val(totle_price-ky_daijinquan);
    $('#daijinquan_fanhui').click();
}
function li_xuanzhong(e){
    e.find('.tb_no_xuanzhong').css('display','none');
    e.find('.tb_xuanzhong').css('display','block');
    e.siblings().find('.tb_no_xuanzhong').css('display','block');
    e.siblings().find('.tb_xuanzhong').css('display','none');
    //给可用代金券赋值
    ky_daijinquan=e.find('.daijinquan_money').text();
    $('#ky_daijinquan').text('- '+ky_daijinquan+' 元');
    $(':hidden[name=ky_daijinquan]').val(ky_daijinquan);
    $('#dues').text(totle_price-ky_daijinquan);
    $(':hidden[name=dues]').val(totle_price-ky_daijinquan);
}

function daijinquan_each(){
    $('.daijinquan_money').each(function(){
    var a=$(this).text();
    if(10*a<=totle_price){
        $(this).parents('li').removeClass('huise');
        $(this).parents('li').find('.tb_xuanzhong').css('display','block');
        $(this).parents('li').bind('click',function(){li_click($(this));});
        li_xuanzhong($(this).parents('li'));
    }else{
        $(this).parents('li').addClass('huise');
        $(this).parents('li').find('.tb_xuanzhong').css('display','none');
        $(this).parents('li').unbind('click');
    }
    });
}





























