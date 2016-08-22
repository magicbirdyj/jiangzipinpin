// JavaScript Document
var index_this=0;//index_this是当前显示的图片index
var times,left,right;
var number=$('#lunbo_div>a').length;
var margin_left='-'+number/2+'00%';
var max_left='-'+(number-1)+'00%';
var min_left='-'+(number/2-1)+'00%';
var max_right='-'+(number/2-2)+'00%';
var min_right='-'+(number-2)+'00%';
var img_width=100/number+'%';
$('#lunbo_div').css('width',number+'00%');
$('.lunbo_div img').css('width',img_width);
$('#lunbo_div').css('margin-left',margin_left);
if(number>2){
    $('.choose_div').append('<span class="bg_red margin_left"></span>');
    for(var i = 1;i < number/2; i++){
        $('.choose_div').append('<span></span>');
    }
}
    


     //手机滑动事件的监听
 var start_x,end_x,move_num;

    $("#lunbo_div").bind("touchstart", function(e) {
        start_x = e.originalEvent.targetTouches[0].clientX;
    });
    $("#lunbo_div").bind("touchmove", function(e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).removeClass("slow_action");
        end_x = e.originalEvent.targetTouches[0].clientX;
        move_num = (end_x - start_x).toFixed(2);
    });
     $("#lunbo_div").bind("touchend", function(e) {
         if(move_num<-10){
            huadong_l();
         }else if(move_num>10){
             huadong_r();
         }
     });

if(number===2){
    $('#lunbo_div').unbind();
}

    function huadong_l(){
        margin_left=$('#lunbo_div')[0].style.marginLeft;
        var n=parseInt(margin_left.substring(1,2));
        left='-'+(n+1)+'00%';
        
        $('#lunbo_div').animate({"margin-left":left},'normal',function(){
            if(left===max_left){
                $('#lunbo_div').css('margin-left',min_left);
            }
            margin_left=$('#lunbo_div')[0].style.marginLeft;
            n=parseInt(margin_left.substring(1,2));
            if(n===number/2-1){
                $('.choose div span').eq(number/2-1).addClass("bg_red").siblings().
            removeClass("bg_red");
            }else if(n===number/2){
                $('.choose div span').eq(0).addClass("bg_red").siblings().
            removeClass("bg_red");
            }else if(n===number/2+1){
                $('.choose div span').eq(1).addClass("bg_red").siblings().
            removeClass("bg_red");
            }else if(n===number/2+2){
                $('.choose div span').eq(2).addClass("bg_red").siblings().
            removeClass("bg_red");
            }
            
        });
        
    }
    if(number>2){
        lunbo_start();
    }

    function lunbo_start(){
        times=setInterval(huadong_l,3000);
    }
    function huadong_r(){
        margin_left=$('#lunbo_div')[0].style.marginLeft;
        var n=parseInt(margin_left.substring(1,2));
        left='-'+(n-1)+'00%';
        $('#lunbo_div').animate({"margin-left":left},'normal',function(){
            if(left===max_right){
                $('#lunbo_div').css('margin-left',min_right);
            }
            margin_left=$('#lunbo_div')[0].style.marginLeft;
            n=parseInt(margin_left.substring(1,2));
            if(n===number/2-1){
                $('.choose div span').eq(number/2-1).addClass("bg_red").siblings().
            removeClass("bg_red");
            }else if(n===number/2){
                $('.choose div span').eq(0).addClass("bg_red").siblings().
            removeClass("bg_red");
            }else if(n===number/2+1){
                $('.choose div span').eq(1).addClass("bg_red").siblings().
            removeClass("bg_red");
            }else if(n===number/2+2){
                $('.choose div span').eq(2).addClass("bg_red").siblings().
            removeClass("bg_red");
            }
        });
        
        
    }



