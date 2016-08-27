<?php
namespace Home\Controller;
use  Home\Controller;
class AjaxnologinController extends FontEndController {
    public function auto_tiaozhuan() {
        session('auto_ref','yes');
        $this->ajaxReturn($_SESSION['auto_ref']);
    }
    public function quxiao_auto_ref(){
        session('auto_ref',null);
        $this->ajaxReturn(0);
    }

    public function address_tiaozhuan() {
        $a=urlencode("http://m.jiangzipinpin.com/Home/Member/address_manage");
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx91953340c19f656e&redirect_uri=".$a."&response_type=code&scope=snsapi_base&state=1#wechat_redirect";
        header("Location:{$url}"); 
        exit();
    }
    
}


