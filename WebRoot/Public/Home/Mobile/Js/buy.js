$('.a_tjdd').bind('click',function(){
        if((Trim($('#default_name').html()).indexOf("点我")>=0)||Trim($('#default_location').html()).indexOf("添加收货地址")>=0){
            var url='/Home/Ajaxnologin/auto_tiaozhuan';
            $.ajax({
                url:url,
                async : true,
                datatype:'json',
                success:function(msg){
                    window.location.href="/Home/Ajaxnologin/address_tiaozhuan"; 
                }
            });
        }else if(Trim($('#default_location').html()).indexOf("冷水江")==-1){
            if(is_1yuangou=='1'){
                tishi('tishi1','此活动商品仅支持送货冷水江市，请更改地址','350px');
            }else{
                $(':hidden[name=order_address]').val($('#default_location').html()+'  '+$('#default_name').html());
                alert( $(':hidden[name=order_address]').val());
                $('form[name=dingdan]').submit();
            }
        }else{
            $(':hidden[name=order_address]').val($('#default_location').html()+'  '+$('#default_name').html());
            $('form[name=dingdan]').submit();
        }
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
        
        
        function tishi(tishi_id,text,bottom){
        $('#'+tishi_id).html(text);
        $('#'+tishi_id).css('display','block');
        $('#'+tishi_id).css('bottom',bottom);
        setTimeout("$('.fixed_tishi').css('display','none')",3000);
    }