$('.jibie_1').next('ul').css('display','none');

$('.jibie_1').bind('click',function(){
    if($(this).next('ul').css('display')==='none'){
        $(this).next('ul').slideDown(100);
    }else{
        $(this).next('ul').slideUp(100);
    }
});


