$('#overlay,#zhishi_fenxiang').bind('click',function(){
        hideOverlay('zhishi_fenxiang');
    }); 
showOverlay('zhishi_fenxiang');
$('.fixed_bottom').bind('click',function(){
    showOverlay('zhishi_fenxiang');
})
            
            
  
 
 
$('#zhishi_fenxiang').css('width',pageWidth());
$('#zhishi_fenxiang').css('height',pageHeight());
$('#zhishi_fenxiang').css('background-size',pageWidth());
var text_h=373/586*pageWidth();
$('.text1').css('top',text_h-10+"px");
$('.text2').css('top',text_h+"px");
$('.text3').css('top',text_h+10+"px");
            

$('#fengxiang_success').css('top',(pageHeight()-$('#fengxiang_success').height())/2);        
            
