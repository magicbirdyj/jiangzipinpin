<?php if (!defined('THINK_PATH')) exit();?>
<html style="cursor: auto ! important;">
    <head>
    <script src="/Public/Common/Js/function.js"></script>
    <script src="/Public/Common/Js/jquery.min.js"></script>
    <script type="text/javascript">
        function initEventlog() {
            //刷新menu页面
            var url="<?php echo U('Index/menu');?>";
                $.ajax({
                    type:'post',
                    url:url,
                    datatype:'json'
                });
            
            
            var is_login=check_login();
        	//setTimeout(function(){
                //根据是否登录 填写menu的内容
                        if(is_login!=0){
                            parent.$("#a_1").html("<?php echo ($huiyuanming); ?>");
                            parent.$("#a_1").attr('href',"<?php echo ($yonghu_url); ?>");
                            parent.$("#a_1").removeClass('red');
                            parent.$("#a_1").addClass('green');
                            parent.$("#a_2").html('退出');
                            parent.$("#a_2").attr('href',"<?php echo ($tuichu_url); ?>");
                        }else{
                            parent.$("#a_1").html('登录');
                            parent.$("#a_1").attr('href',"<?php echo ($login_url); ?>");
                            parent.$("#a_1").removeClass('green');
                            parent.$("#a_1").addClass('red');
                            parent.$("#a_2").html('注册');
                            parent.$("#a_2").attr('href',"<?php echo ($zhuce_url); ?>");
                        }
        	//},50);
        }
    </script>
    </head>
    <body onLoad="initEventlog()">
</body></html>