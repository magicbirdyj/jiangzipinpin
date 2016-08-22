<?php
namespace Home\Controller;
use  Home\Controller;
class CrontabController extends FontEndController {
    
    public function upload_order() {
        $ordermodel=D('Order');
        $time=  time();
        
        //2个小时未付款的订单，取消订单
        $arr_no_pay=$ordermodel->where("deleted=0 and pay_status=0 and status=1")->field('order_id,created')->select();
        foreach ($arr_no_pay as $value) {
            //2个小时未付款的订单，取消订单
            if($time>($value['created']+7200)){
                $row=array('status'=>7);
                $order_id=$value['order_id'];
                $ordermodel->where("order_id=$order_id")->save($row);
            }
        }
        
        //24小时未组团成功，团内订单全部组团失败
        $arr_tuan_no=$ordermodel->where("deleted=0 and pay_status=1 and status=1 and tuan_no<>0")->getField('tuan_no',true);
        array_unique($arr_tuan_no);
        foreach ($arr_tuan_no as $value) {
            $order=$ordermodel->where("order_id=$value")->field('created,tuan_number')->find();
            if($time>$order['created']+86400){
                $count=$ordermodel->where("tuan_no=$value and pay_status=1 and status=1 and deleted=0")->count();
                if($count<$order['tuan_number']){
                    $row=array('status'=>6);
                    $ordermodel->where("tuan_no=$value and status=1")->save($row);
                }
            }
        }
        
    }
    

    
    
    
    
}


