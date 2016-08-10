// JavaScript Document

window.onload=function(){
    $('.shopping_img img').each(function(i,item){
        if($(item).height()<200){
            $(item).css('height','200px');
            $(item).css('width','auto');
        }
    });
  
};

$('.box_r_shopping:last').css('border','none');

