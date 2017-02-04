
var total_number=0;
var total_price=0.00;

$('.x3 li').each(function(){
    var length=$(this).siblings().length+1;
    $(this).css('width',100/length+'%');
});

$('.page').eq(0).css('display','block');//显示第一大类
$('.x2 li').eq(0).children('a').addClass('active');
$('.x3').each(function(){
    $(this).children('li').eq(0).children('a').addClass('active');
});
$('.page').each(function(){
    $(this).find('.m-business').eq(0).css('display','block');//显示第一小类
});



//点击商品 j加入购物车

    var offset = $("#car_img").offset(); 
    $("ul.m-business a").click(function(event){ 
        var addcar = $(this); 
        buy_number(addcar); 
        add_li(addcar);
        var img = addcar.children('img').attr('src'); 
        var flyer = $('<img class="u-flyer" src="'+img+'">'); 
        flyer.fly({ 
            start: { 
                left: event.pageX, //开始位置（必填）#fly元素会被设置成position: fixed 
                top: event.pageY //开始位置（必填） 
            }, 
            end: { 
                left: offset.left+23, //结束位置（必填） 
                top: offset.top+20, //结束位置（必填） 
                width: 0, //结束时宽度 
                height: 0 //结束时高度 
            }, 
            onEnd: function(){ //结束回调 
                //$("#msg").show().animate({width: '250px'}, 200).fadeOut(1000); //提示信息 
                car_change();
                this.destory(); //移除dom 
            } 
        }); 
    }); 


function car_change(){
    $('.buy-number-total').css('display','block');
    $('.buy-number-total').html(total_number);
    $('.total-price').html(total_price.toFixed(2));
    $('#car_img').animate({width:"55px"},300, function (){
    $('#car_img').animate({width:"45px"},300);
    });
}
function car_change_minus(){
    $('.buy-number-total').css('display','block');
    $('.buy-number-total').html(total_number);
    if(total_number==0){
        $('.buy-number-total').css('display','none');
    }
    $('.total-price').html(total_price.toFixed(2));
    $('#car_img').animate({width:"55px"},300, function (){
    $('#car_img').animate({width:"45px"},300);
    });
}
function buy_number(obj){
    var obj_buy=obj.children('.buy-number');
    var yuan_number=parseInt(obj_buy.html());
    obj_buy.html(yuan_number+1);
    obj_buy.css('display','block');
    total_number++;
    var price=parseFloat(obj.find('.price').html());
    total_price=parseFloat(total_price+price);
}
function buy_number_minus(obj){
    var obj_buy=obj.children('.buy-number');
    var yuan_number=parseInt(obj_buy.html());
    obj_buy.html(yuan_number-1);
    if(yuan_number==1){
        obj_buy.css('display','none');
    }
    total_number--;
    var price=parseFloat(obj.find('.price').html());
    total_price=parseFloat(total_price-price);
}

$('#car_img').bind('click',function(){
    $('#price-forecast').show();
    $('.big-shade-all').show();
});
$('#close').bind('click',function(){
    $('#price-forecast').hide();
    $('.big-shade-all').hide();
});

function add_li(addcar){
    var data_id=addcar.attr('data_id');
    var li=$('#car_ul').find('li[data_li='+data_id+']');
    if(li.length==0){
        var src=addcar.children('img').attr('src');
        var obj=$(obj_li);
        obj.attr('data_li',data_id);
        obj.find('.pic-box').children('img').attr('src',src);
        obj.find('.clothes-name').html(addcar.children('.goods_name').html());
        obj.find('.single_price').html(addcar.find('.price').html());
        obj.appendTo('#car_ul');
    }else{
       add_one(li);
    }
}

function add_one(obj){
    var num=parseInt(obj.find('.single_number').html());
    obj.find('.single_number').html(num+1);
}
function minus_one(obj){
    var num=parseInt(obj.find('.single_number').html());
    obj.find('.single_number').html(num-1);
    if(num==1){
        obj.remove();
    }
}
$('body').on('click','.add',function(){
    var obj=$(this).parents('.car_li');
    add_one(obj);
    //相当于商品点击1下
    var data_li=obj.attr('data_li');
    var addcar=$('.m-business').children('a[data_id='+data_li+']');
    buy_number(addcar); 
    car_change();
});

$('body').on('click','.minus',function(){
    var obj=$(this).parents('.car_li');
    minus_one(obj);
    //点击商品的逆操作
    var data_li=obj.attr('data_li');
    var addcar=$('.m-business').children('a[data_id='+data_li+']');
    buy_number_minus(addcar); 
    car_change_minus();
});

//购物车清空按钮
$('#clear').bind('click',function(){
    $('#car_ul li').remove();
    $('.buy-number-total').css('display','none');
    $('.buy-number-total').html(0);
    $('.total-price').html('0.00');
    $('.buy-number').css('display','none');
    $('.buy-number').html(0);
    total_number=0;
    total_price=0.00;
});



//分类按钮的点击
$('.x2 .curr').bind('click',function(){
    var is_select=$(this).children('a').attr('class');
    if(is_select=='active'){
        return false;
    }
    var index=$(this).index();
    $('.page').eq(index).css('display','block').siblings('.page').css('display','none');
    $(this).children('a').addClass('active');
    $(this).siblings('.curr').children('a').removeClass('active');
});
$('.x3 .curr').bind('click',function(){
    var is_select=$(this).children('a').attr('class');
    if(is_select=='active'){
        return false;
    }
    var index=$(this).index();
    var obj=$(this).parent('.x3');
    obj.siblings('ul').eq(index).css('display','block').siblings('ul').css('display','none');
    $(this).children('a').addClass('active');
    $(this).siblings('.curr').children('a').removeClass('active');
});


//确认商品
$('.order-btn').bind('click',function(){
    if($('#car_ul li').length==0){
        alert('您还未添加任何商品');
        return false;
    }
    var data={};
    $('#car_ul li').each(function(i){
        data[(i+1)]={
            goods_id:$(this).attr('data_li'),
            number:$(this).find('.single_number').html()
        };
    });
    data.order_id=order_id;
    ajax_confirm(data);
});


function ajax_confirm(data){
    var url='/Home/Ajaxlogin/confirm_goods';
        $.ajax({
            type:'post',
            async : true,
            url:url,
            datatype:'json',
            data:data,
            success:function(){
                window.location.href='/Home/Horseman/order_view/order_id/'+order_id; 
            }
        });
}

