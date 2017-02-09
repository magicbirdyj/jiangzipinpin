//点击立即预约
$('.a_tjdd').bind('click',function(){
        if((Trim($('#default_name').html()).indexOf("添加")>=0)||Trim($('#default_location').html()).indexOf("送衣地址")>=0){
           tishi('tishi','请添加送衣地址','350px');
        }else if(Trim($('#default_location').html()).indexOf("娄星区")==-1){
            tishi('tishi','目前仅支持娄星区，请更改地址','350px');
        }else if($('#time').html()=='请选择送衣时间'||$(':hidden[name=order_time]').val()==''){
                tishi('tishi','请选择送衣时间','350px');
        }else{
            $(':hidden[name=address_location]').val($('#address_location').html());
            $(':hidden[name=address_address]').val($('#address_address').html());
            $(':hidden[name=address_name]').val($('#address_name').html());
            $(':hidden[name=address_mobile]').val($('#address_mobile').html());
            
            $('form[name=dingdan]').submit();
        }
    });















    //点击地址a 弹出地址编辑页面
    $('#address_a').bind('click',function(){
        tanchu($('#bianji_dizhi_div'));
    });
    


 //点击时间 弹出时间编辑页面
    $('#time-part').bind('click',function(){
        tanchu($('#bianji_time_div'));
    });
    
    function tanchu(obj){
        obj.css('height',$(window).height());
        obj.css('display','block');
        window.scrollTo(0,0);
        obj.animate({'left':'0%'},'normal',function(){
            $('#main_div').css('display','none');
        });
    }



    //点击返回购买下单页面
$('#address_fanhui').bind('click',function(){
    fanhui_main($('#bianji_dizhi_div'));
});

$('#time_fanhui').bind('click',function(){
    fanhui_main($('#bianji_time_div'));
});

function fanhui_main(obj){
    $('#main_div').css('display','block');
    obj.animate({'left':'100%'},'normal',function(){
        obj.css('display','none');
    });
}


function tishi(tishi_id,text,bottom){
        $('#'+tishi_id).html(text);
        $('#'+tishi_id).css('display','block');
        $('#'+tishi_id).css('bottom',bottom);
        setTimeout("$('.fixed_tishi').css('display','none')",3000);
    }