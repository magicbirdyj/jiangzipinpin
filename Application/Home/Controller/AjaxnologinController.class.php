<?php
namespace Home\Controller;
use  Home\Controller;
class AjaxnologinController extends FontEndController {

   

    public function address_tiaozhuan() {
        $a=urlencode("http://m.jiangzipinpin.com/Home/Member/address_manage");
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx91953340c19f656e&redirect_uri=".$a."&response_type=code&scope=snsapi_base&state=1#wechat_redirect";
        header("Location:{$url}"); 
        exit();
    }
    
    public function dandu_buy_tiaozhuan() {
        $get=$_GET;
        $fanhui=U('Goods/dandu_buy',$get);
        $a=urlencode("http://m.jiangzipinpin.com".$fanhui);
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx91953340c19f656e&redirect_uri=".$a."&response_type=code&scope=snsapi_base&state=1#wechat_redirect";
        header("Location:{$url}"); 
        exit();
    }
    
}


