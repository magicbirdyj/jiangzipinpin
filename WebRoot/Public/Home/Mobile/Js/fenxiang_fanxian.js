


$('#a_zhishifenxiang').bind('click',function(){
    tanchu('zhishi_fenxiang');
});
 
$('#zhishi_fenxiang').css('width',pageWidth());
$('#zhishi_fenxiang').css('height',pageHeight());
$('#zhishi_fenxiang').css('background-size',pageWidth());
var text_h=373/586*pageWidth();
$('.text1').css('top',text_h-10+"px");
$('.text2').css('top',text_h+"px");
$('.text3').css('top',text_h+10+"px");
            

$('#fengxiang_success').css('top',($(window).height()-$('#fengxiang_success').height())/2);        




function tanchu(id){
        $('#'+id).show();
	$('.big-shade-all').show();
}

$('#zhishi_fenxiang').bind('click',function(){
    $('#zhishi_fenxiang').hide();
	$('.big-shade-all').hide();
});