/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$('#queding').bind('click',function(){
    var password=$('input[name=zhifu_password]').val();
    if(password===''){
        $('#tishi').html('请输入支付密码。');
        $('#tishi').css('color','#FF5243');
    }else{
        var data={
            mima:password,
            check:'yanzheng'
        };
        var url='/Home/Order/yanzheng_zfmm.html';
        $.ajax({
            type:'post',
            async : false,
            url:url,
            data:data,
            datatype:'json',
            success:function(msg){
                if(msg==='0'){
                    $('#tishi').html('密码错误，请重新输入。');
                    $('#tishi').css('color','#FF5243');
                }else if(msg==='1'){
                    $('form[name=form_queren]').submit();
                }
            }
        });
    }
});