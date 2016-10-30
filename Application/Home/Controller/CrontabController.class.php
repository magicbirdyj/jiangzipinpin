<?php
namespace Home\Controller;
use  Home\Controller;
class CrontabController extends FontEndController {
    
    public function upload_order() {
        $this->quxiao_order();
        $this->aotu_queren_shouhuo();
        //$this->ztsb();
        //$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        //var_dump($url);
    }
    public function transfersh() {
        exit;
        if($_SERVER['REMOTE_ADDR']!='120.55.166.254'){
            var_dump('IP地址为'.$_SERVER['REMOTE_ADDR'].'非服务器IP');
            exit;
        }
        $shopsmodel=D('Shops');
        $arr_shop=$shopsmodel->where("status=1 and totle_amount>mentioned")->select();
        /*
        foreach ($arr_shop as $value) {
            $open_id=$value['open_id'];
            $amount=$value['totle_amount']-$value['mentioned'];
            $shijian=date('YmdHis');
            $result=$this->send_shops_transfers($open_id,$amount,$shijian);
            if($result['return_code']=='SUCCESS'&&$result['result_code']=='FAIL'){
                $result=$this->send_shops_transfers($open_id,$amount,$shijian);
            }

            //付款成功 ,改变shops里面的已经提现金额mentioned
            if($result['return_code']=='SUCCESS'&&$result['result_code']=='SUCCESS'){
                $row=array(
                    'mentioned'=>$value['mentioned']+$amount
                );
                $shopsmodel->where("open_id=$open_id")->save($row);
            }
        }
         * 
         */
        $shijian=date('YmdHis');
        $result=$this->send_shops_transfers('oSI43woDNwqw6b_jBLpM2wPjFn_M','0.01',$shijian);
        if($result['return_code']=='SUCCESS'&&$result['result_code']=='FAIL'){
            $result=$this->send_shops_transfers('oSI43woDNwqw6b_jBLpM2wPjFn_M','0.01',$shijian);
        }
        
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
    private function aotu_queren_shouhuo() {
        $time=  time();
        $ordermodel=D('Order');
        $yifahuo=$ordermodel->where("deleted=0 and pay_status=1 and status=3")->field('order_id,created,updated,shop_id,fenxiang,dues,fenxiang_dues')->select();
        foreach ($yifahuo as $value) {
            //两周已发货订单，自动确认收货
            if($time>($value['updated']+1209600)){
                //改变订单状态，同时无法再进行分享返现
                $row=array(
                    'status'=>4,
                    'fenxiang'=>2
                );
                $order_id=$value['order_id'];
                $result=$ordermodel->where("order_id=$order_id")->save($row);
                //店铺总金额增加
                $shop_id=$value['shop_id'];
                if($value['fenxiang']==1){
                    $amount=$value['dues']-$value['fenxiang_dues'];
                }else{
                    $amount=$value['dues'];
                }
                $row_shop=array(
                    'totle_amount'=>$amount
                );
                $shopsmodel=D('shops');
                $result=$shopsmodel->where("shop_id=$shop_id")->save($row_shop);
                    
        
                //发送交易成功通知
                $remark='点我进行评价，您的评价是对卖家最好的肯定。';
                $this->jiaoyi_success_tep($order_id, $remark);
        
                //给商家发送订单已经确认收货通知
                $remark='订单金额已经转入您的店铺金额,系统将在周一早上8点统一打款至您的微信账户中';
                $this->queren_shouhuo_tep($order_id, $remark);
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
                    $arr_order_id=$ordermodel->where("tuan_no=$value and pay_status=1")->getField('order_id',true);
                    //file_put_contents('./ztsb_0.txt',print_r($arr_order_id,true),FILE_APPEND);
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
                $row=array('pay_status'=>4,'shouhou_cause'=>'组团失败');
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
        $template_id="f1x_qFFCFwJS_-kYDemBbGmLYqy4TNeqBiP6UqfskvI";
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
    
    //收货成功后，给商家发送订单确认收货通知
    private function queren_shouhuo_tep($order_id,$remark){
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id=$order_id")->find();
        $user_id=$order['user_id'];
        $usersmodel=D('Users');
        $user_name=$usersmodel->where("user_id=$user_id")->getField('user_name');
        $shop_id=$order['shop_id'];
        $shopsmodel=D('Shops');
        $open_id=$shopsmodel->where("shop_id=$shop_id")->getField('open_id');
        $template_id="TlXhsrpBwj1I8v3pkClul5dDEuvrMBGmy1ihKqJOCyY";
        $url=U('Shop/view_order',array('order_id'=>$order_id));
        if($order['fenxiang']==1){
            $amount=$order['dues']-$order['fenxiang_dues'];
        }else{
            $amount=$order['dues'];
        }
        $arr_data=array(
            'first'=>array('value'=>"您好，您售出的商品(买家：".$user_name.")".$order['goods_name']."已经自动确认收货。","color"=>"#666"),
            'keyword1'=>array('value'=>$order['order_no'],"color"=>"#666"),
            'keyword2'=>array('value'=>$amount,"color"=>"#666"),
            'keyword3'=>array('value'=>  date('Y/m/d H:i:s'),"color"=>"#666"),
            'remark'=>array('value'=>$remark,"color"=>"#F90505")
        );
        $this->response_template($open_id, $template_id, $url, $arr_data);
    }
    
    
    //收货成功后，发送交易成功和请买家评价通知
    private function jiaoyi_success_tep($order_id,$remark){
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id=$order_id")->find();
        $user_id=$order['user_id'];
        $usersmodel=D('Users');
        $open_id=$usersmodel->where("user_id=$user_id")->getField('open_id');
        $template_id="VFmfBzeReRkds4Itr5HMDij0RTgPFalRQJpL5J7Pw9s";
        $url=U('Order/appraise',array('order_id'=>$order_id));
        $arr_data=array(
            'first'=>array('value'=>"您好，您购买的商品：".$order["goods_name"]."因超时未收货，已经自动确认收货。","color"=>"#666"),
            'keyword1'=>array('value'=>$order['dues'].'元',"color"=>"#666"),
            'keyword2'=>array('value'=>$order["goods_name"],"color"=>"#666"),
            'keyword3'=>array('value'=>$order['order_no'],"color"=>"#666"),
            'remark'=>array('value'=>$remark,"color"=>"#F90505")
        );
        $this->response_template($open_id, $template_id, $url, $arr_data);
    }
    
    
    private function send_shops_transfers($open_id,$amount,$shijian) {
        $desc='周一结算，货款打给商家';
        vendor('wxp.native'); //引入第三方类库
        $sendShopsTransfersInput = new \WxPaySendShoptransfers();
        //向商家付款
        $amount=(float)$amount;
        $sendShopsTransfersInput->SetAmount($amount*100);//付款金额 int
        $sendShopsTransfersInput->SetPartner_trade_no($open_id.$shijian);//商户订单号
        $sendShopsTransfersInput->SetOpenid($open_id);//接收付款商家
        $sendShopsTransfersInput->SetDesc($desc);//企业付款描述信息
        $sendShopsTransfersInput->SetCheck_name('NO_CHECK');//校验用户姓名选项
        $sendShopsTransfersInfo = \WxPayApi::sendshoptransfers($sendShopsTransfersInput, 300);
        return $sendShopsTransfersInfo;
    }
    
}


