    function fenxiang_success(){
        //分享成功回调 fengxiang=1
        fenxiang_huidiao();
        $('#zhishi_fenxiang').hide();
        tanchu('fengxiang_success');
        $('#fengxiang_success').bind('click',function(){
            $('#fengxiang_success').hide();
            $('.big-shade-all').hide();
        });
    }
   
    
    function panduan(){
        if(!if_guanzhu()){
            return false;
        }else if(choujiang==0&&fenxiang==1){
            $('#tishi').html('您已经抽过奖了！');
            return false;
        }else if(choujiang==0&&fenxiang==0){
            tanchu('zhishi_fenxiang');
            return false;
        }else{
            return true;
        }
    }
    
    

	$(".rotate-con-zhen").rotate({
		bind:{
			click:function(){
                            if(!panduan()){
                                return false;
                            }
				var a = runzp();
				 $(this).rotate({
					 	duration:3000,               //转动时间
					 	angle: 0,                    //起始角度
            			animateTo:1440+a.angle,      //结束的角度
						easing: $.easing.easeOutSine,//动画效果，需加载jquery.easing.min.js
						callback: function(){
                                                    choujiang_huidiao(a.id);
                                                    //$('#tishi').html('恭喜您获得：'+a.prize);
                                                    alert('恭喜您获得：'+a.prize+a.id);//简单的弹出获奖信息
                                                    window.location.href='/Home/Member/daijinquan';
						}
				 });
			}
		}
	});

    
function fenxiang_huidiao(){
    var url='/Home/Ajaxlogin/fenxiang_huidiao.html';
    var data={
            check:"fenxiang_huidiao"
            };
    $.ajax({
        type:'post',
        url:url,
        data:data,
        datatype:'json',
        async : true, 
    });
}

function choujiang_huidiao(id){
    var url='/Home/Ajaxlogin/choujiang_huidiao.html';
    var data={
            id:id,
            check:"choujiang_huidiao"
            };
    $.ajax({
        type:'post',
        url:url,
        data:data,
        datatype:'json',
        async : true, 
    });
}