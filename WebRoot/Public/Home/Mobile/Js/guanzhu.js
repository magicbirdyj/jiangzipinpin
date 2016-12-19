//如果guanzhu=weiguanzhu 弹出关注二维码对话框



function tanchuguanzhu(){
        $('#guanzhu').show();
	$('.big-shade-all').show();
        //$('#guanzhu').css('top',(window.screen.availHeight-$('#guanzhu').height())/2);
        $('.tb_zhiwen').css('height',$('.tb_zhiwen').css('width'));
        $('.tb_zhiwen').css('line-height',$('.tb_zhiwen').css('width'));
        $('.erweima_div').css('height',$('.erweima_div').css('width'));
}


//ajax删除$_session
    function delete_guanzhu(){
        $.ajax({
            type:'post',
            url:'/Home/Login/delete_guanzhu',
            data:0,
            dataType:'json'
        });
    } 
    
    //ajax保存url进数据库
    function save_url(s_url){
        var data={
        url:s_url
    };
        $.ajax({
            type:'post',
            url:'/Home/Login/save_url_ajax',
            data:data,
            dataType:'json',
            
        });
    } 