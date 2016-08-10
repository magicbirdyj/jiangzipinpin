<?php
namespace Home\Controller;
use Home\Controller;
class BuyController extends FontEndController {
    public function index(){
        $this->display(index);
 
    }
    public function pay(){
        
        
        
    }
    
    public function getQRPHP(){
         vendor('wxp.example.phpqrcode.phpqrcode'); //引入第三方类库
         $url = urldecode($_GET["data"]);
        \QRcode::png($url);
    }


}