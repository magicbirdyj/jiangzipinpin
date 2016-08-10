// JavaScript Document
//onfocus
//onblur
$('input[name=tixian]').bind('focus',function(){
    $('#tixian_tishi').html('输入提现金额，如100.00');
});
$('input[name=tixian]').bind('keyup',function(){
     yanzheng_tixian($('input[name=tixian]'));
});

function is_tixian(str){
    var reg=/^\d+\.?\d{0,2}$/gi;
    return reg.test(str);
}

