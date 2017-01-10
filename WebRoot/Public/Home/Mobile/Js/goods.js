$('.x3 li').bind('click',function(){
    var cla=$(this).attr('class');
    if(cla!='curr'){
        $(this).addClass('curr');
        $(this).siblings().removeClass('curr');
    }
})