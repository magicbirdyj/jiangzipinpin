//如果guanzhu=weiguanzhu 弹出关注二维码对话框



function tanchuguanzhu(){
        showOverlay('guanzhu');
        $('#guanzhu').css('top',(window.screen.availHeight-$('#guanzhu').height())/2);
        $('.tb_zhiwen').css('height',$('.tb_zhiwen').css('width'));
        $('.tb_zhiwen').css('line-height',$('.tb_zhiwen').css('width'));
        $('.erweima_div').css('height',$('.erweima_div').css('width'));
}

