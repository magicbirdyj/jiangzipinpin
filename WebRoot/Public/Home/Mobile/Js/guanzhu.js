//如果guanzhu=weiguanzhu 弹出关注二维码对话框



function tanchuguanzhu(){
        $('#guanzhu').css('display','block');
        $('#guanzhu').css('top',($(window).height()-$('#guanzhu').height())/2);
        showOverlay('guanzhu');
        $('.tb_zhiwen').css('height',$('.tb_zhiwen').css('width'));
        $('.tb_zhiwen').css('line-height',$('.tb_zhiwen').css('width'));
        $('.erweima_div').css('height',$('.erweima_div').css('width'));
}

