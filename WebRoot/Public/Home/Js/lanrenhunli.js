// JavaScript Document
//onfocus
//onblur
$('.shopping_img img').each(function(i,item){
        if($(item).height()<191){
            $(item).css('height','191px');
            $(item).css('width','auto');
        }
    });

