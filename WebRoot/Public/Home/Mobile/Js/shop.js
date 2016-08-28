
if(!fengge){
    fengge_0();
}else if(fengge==1){
    fengge_1()
}



function fengge_0(){
    //添加css文件
        $("<link>").attr({ rel: "stylesheet",
            type: "text/css",
            href: shop_1_href,
            id:'shop_1'
        }).appendTo("head");
        //删除原 shop_2的css文件
        $('#shop_2').remove();
       //风格1的shop的偶数取消左边框
        var data={
            'border-left' :'none'
        };
        $('.shopping:odd').css(data);

        //添加.goods.title的class----border-bottom
        $('.goods_title').addClass('border-bottom');
        //url改变
        $('#fengge').attr('href',fengge1_url);
        //图标变成风格2
        obj.html('&#xe630;');
}

function fengge_1(){
    //添加css文件
        $("<link>").attr({ rel: "stylesheet",
            type: "text/css",
            href: shop_2_href,
            id:'shop_2'
        }).appendTo("head");
        //删除原 shop_1的css文件
        $('#shop_1').remove();
        //风格2的shop的偶数取消右边框 加个左边框
        var data={
            'border-right' :'none',
            'border-left' :'3px solid #f0f0f0'
        };
        $('.shopping:odd').css(data);

        //取消.goods.title的class----border-bottom
        $('.goods_title').removeClass('border-bottom');
        //url改变
        $('#fengge').attr('href',fengge0_url);
        //图标变成风格2
        obj.html('&#xe631;');
}