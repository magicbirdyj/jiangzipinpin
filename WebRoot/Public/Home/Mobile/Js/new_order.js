/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//循环检测新订单 显示到页面左上角
    function get_new_order(){
        $.ajax({
            type:'GET',
            url:'/Home/Login/get_new_order',
            data:0,
            dataType:'json',
            success:function(msg){
                if(msg!='0'){
                    var order_html='<div class="new_order_div"><img src="'+msg.head_url+'" /><span>'+msg.text+'</span></div>';
                    $('body').append(order_html);
                    setTimeout(function(){$('.new_order_div').remove();},5000);
                }
            }
        });
    }
    setTimeout(get_new_order,5000);
    setInterval('get_new_order()',10000);