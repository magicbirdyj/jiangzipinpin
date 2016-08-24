<?php
namespace Home\Controller;
use  Home\Controller;
class CrontabController extends FontEndController {
    
    public function upload_order() {
        $this->quxiao_order();
        $this->ztsb();
        $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        var_dump($url);
    }
    

    private function quxiao_order(){
        $time=  time();
        //2个小时未付款的订单，取消订单
        $ordermodel=D('Order');
        $arr_no_pay=$ordermodel->where("deleted=0 and pay_status=0 and status=1")->field('order_id,created')->select();
        foreach ($arr_no_pay as $value) {
            //2个小时未付款的订单，取消订单
            if($time>($value['created']+21600)){
                $row=array('status'=>7);
                $order_id=$value['order_id'];
                $ordermodel->where("order_id=$order_id")->save($row);
                $remark="点我，重新购买该商品";
                $this->quxiao_order_tep($value['order_id'],$remark);//通知消息
            }
        }
    }
    
    
    private function ztsb(){
        $time=  time();
         //24小时未组团成功，团内订单全部组团失败
        $ordermodel=D('Order');
        $arr_tuan_no=$ordermodel->where("deleted=0 and pay_status=1 and status=1 and tuan_no<>0")->getField('tuan_no',true);
        array_unique($arr_tuan_no);
        foreach ($arr_tuan_no as $value) {
            $order=$ordermodel->where("order_id=$value")->field('created,tuan_number')->find();
            if($time>$order['created']+86400){
                $count=$ordermodel->where("tuan_no=$value and pay_status=1 and status=1 and deleted=0")->count();
                if($count<$order['tuan_number']){
                    $row=array('status'=>6);
                    $ordermodel->where("tuan_no=$value and status=1")->save($row);
                    //该团中每个付款的成员都要退款并发送退款通知
                    $arr_order_id=$ordermodel->where("tuan_no=$value and pay_status=1")->getFiele('order_id',true);
                    foreach ($arr_order_id as $value_1) {
                        $this->refund($value_1);
                    }
                }
            }
        }
    }
    
    
    
    private function refund($order_id) {
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id=$order_id")->find();
        if($order['pay_status']!=1&&$order['pay_status']!=2){
            $this->error('该订单未付款或者正在申请换货或者已经退款成功,无法退款');
        }
        vendor('wxp.native'); //引入第三方类库
            $refundInput = new \WxPayRefund();
            $refundInput->SetTransaction_id($order['trade_no']);
            $refundInput->SetOut_refund_no($order['order_no']);
            $refundInput->SetOut_trade_no($order['order_no']);
            $refundInput->SetTotal_fee($order['dues'] * 100);
            $refundInput->SetRefund_fee($order['dues'] * 100);
            $refundInput->SetOp_user_id('1380048502');
            $refundInfo = \WxPayApi::refund($refundInput, 300);

            if (is_array($refundInfo) && $refundInfo['result_code'] == 'SUCCESS') {//退款成功
                $row=array('pay_status'=>4,'shouhou_cause'=>'活动商品未获奖');
                $ordermodel->where("order_id=$order_id")->save($row);
                $this->refund_tep_ztsb($order_id);
            } else {
                $this->error("退款失败" .  $refundInfo['return_msg']);
            }
               
    }
    private function quxiao_order_tep($order_id,$remark){
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id=$order_id")->find();
        $user_id=$order['user_id'];
        $usersmodel=D('Users');
        $user=$usersmodel->where("user_id=$user_id")->field('open_id,user_name')->find();
        $template_id="f1x_qFFCFwJS_-kYDemBbGmLYqy4TNeqBiP6UqfskvI ";
        $goods_id=$order['goods_id'];
        $url=U('Goods/index',array('goods_id'=>$goods_id));
        $arr_data=array(
            'first'=>array('value'=>"您购买的商品".$order["goods_name"]." 因超过6小时未付款，系统自动取消订单","color"=>"#666"),
            'keyword1'=>array('value'=>$order['order_no'],"color"=>"#666"),
            'keyword2'=>array('value'=>"取消订单","color"=>"#666"),
            'keyword3'=>array('value'=>$order['dues'],"color"=>"#666"),
            'keyword4'=>array('value'=>date("Y年m月d日 h:i:s",$order['created']),"color"=>"#666"),
            'keyword5'=>array('value'=>$user['user_name'],"color"=>"#666"),
            'remark'=>array('value'=>$remark,"color"=>"#F90505")
        );
        $this->response_template($user['open_id'], $template_id, $url, $arr_data);
    }
    
    private function refund_tep_ztsb($order_id){
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id=$order_id")->find();
        $user_id=$order['user_id'];
        $usersmodel=D('Users');
        $open_id=$usersmodel->where("user_id=$user_id")->getField('open_id');
        $template_id="95UZl_xx_sjJdno-l1X4vUrRvOLlsepMEZHPFsofZms";
        $goods_id=$order['goods_id'];
        $url=U('Goods/index',array('goods_id'=>$goods_id));
        $arr_data=array(
            'first'=>array('value'=>"您好，您拼团购买的商品：".$order["goods_name"]." 组团失败，已全额退款给您！","color"=>"#666"),
            'reason'=>array('value'=>'【'.$order['tuan_number']."】人团 组团失败，您可以重新开团或者参团","color"=>"#F90505"),
            'refund'=>array('value'=>$order["dues"]."元","color"=>"#666"),
            'remark'=>array('value'=>"点我，重新去开团或参团","color"=>"#F90505")
        );
        $this->response_template($open_id, $template_id, $url, $arr_data);
    }
    
}


