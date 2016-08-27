$('.a_tjdd').bind('click',function(){
    alert(Trim($('#default_name').html()));
    alert(Trim($('#default_name').html()).indexOf("点击添加地址"));
        if(Trim($('#default_name').html()).indexOf("点击添加地址")>=0){
            var url='/Home/Ajaxnologin/auto_tiaozhuan';
            $.ajax({
                url:url,
                async : true,
                datatype:'json',
                success:function(){
                    $('.address').trigger('click');
                }
            });
        }
        $('form[name=dingdan]').submit();
    });
    var value;
    $('#buy_number').val('1');
    $('#dues').text(totle_price-ky_daijinquan);
    $(':hidden[name=dues]').val(totle_price-ky_daijinquan);
    $('#jia').bind('click',function(){
        value=parseInt($('#buy_number').val());
        if((value)>8){
            return false;
        }
        $('#buy_number').val((value+1));
        value=parseInt($('#buy_number').val());
        $(':hidden[name=buy_number]').val(value);
        totle_price=value*price;
        $('#dues').html(totle_price-ky_daijinquan);
        $(':hidden[name=dues]').val(totle_price-ky_daijinquan);
        if((value)>8){
            $('#jia').css('background-color','#C8C8C8');
        }
        if((value)>1){
            $('#jian').css('background-color','#FFF');
        }
        daijinquan_each();
    });
    $('#jian').bind('click',function(){
        value=parseInt($('#buy_number').val());
        if((value)<2){
            return false;
        }
        $('#buy_number').val(value-1);
        value=parseInt($('#buy_number').val());
        $(':hidden[name=buy_number]').val(value);
        totle_price=value*price;
        $('#dues').html(totle_price-ky_daijinquan);
        $(':hidden[name=dues]').val(totle_price-ky_daijinquan);
        if((value)<2){
            $('#jian').css('background-color','#C8C8C8');
        }
        if((value)<9){
            $('#jia').css('background-color','#FFF');
        }
        daijinquan_each();
    });
    $('#jian').css('background-color','#C8C8C8');
    
    
    $('#buy_number').bind('change',function(){
        value=parseInt($('#buy_number').val());
        if(value>=9){
            $('#buy_number').val(9);
            $('#jia').css('background-color','#C8C8C8');
            $('#jian').css('background-color','#FFF');
        }else if(value<=1){
            $('#buy_number').val(1);
            $('#jian').css('background-color','#C8C8C8');
            $('#jia').css('background-color','#FFF');
        }
        value=parseInt($('#buy_number').val());
        totle_price=value*price;
        $('#dues').html(totle_price-ky_daijinquan);
        $(':hidden[name=dues]').val(totle_price-ky_daijinquan);
        $(':hidden[name=buy_number]').val(value);
        daijinquan_each();
        });