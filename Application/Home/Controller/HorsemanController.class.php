<?php
namespace Home\Controller;
use Home\Controller;
class HorsemanController extends FontEndController {
   
    public function index(){
        $this->display('order');
    }
    public function become_horseman() {
        $open_id=$_SESSION['huiyuan']['open_id'];
        $horsemanmodel=D('Horseman');
        $horseman=$horsemanmodel->where("open_id='$open_id'")->find();
        if($horseman){
            header("location:". U("Horseman/index"));
            exit();
        }
        $this->display();
    }
    public function order_view() {
        $order_id=$_GET['order_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='{$order_id}'")->find();
        if(!$order){
            $this->error('该订单号不存在或已经删除 ');
        }
        $address=  unserialize($order['order_address']);
        $order['order_address']=$address;
        $this->assign('order',$order);
        $this->display('view');
    }
    

    
    
    


}