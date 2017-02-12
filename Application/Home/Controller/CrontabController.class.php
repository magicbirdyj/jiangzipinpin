<?php
namespace Home\Controller;
use  Home\Controller;
class CrontabController extends FontEndController {
    
    public function upload_order() {
        $this->remind_horseman();
        $this->remind_users();
        //$this->remind_pay();
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
    private function remind_horseman() {
        $time=  time();
        //提前半小时，提醒骑手准备上门取件
        $ordermodel=D('Order');
        //上门取衣
        $arr_order=$ordermodel->where("deleted=0  and status=1")->field('order_id,appointment_time,order_address,remark,remind_horseman_time')->select();
        foreach ($arr_order as $value) {
            //提前半小时，提醒骑手准备上门取件
            if($time>($value['appointment_time']-1800) and ($time-600)>$value['remind_horseman_time']){
                $row=array(
                    'remind_horseman_time'=>$time
                );
                $order_id=$value['order_id'];
                $ordermodel->where("order_id='$order_id'")->save($row);
                $remark="点我，马上接单";
                $this->remind_horseman_tem($value,$remark);//通知消息
            }
        }
         //上门送衣
        $arr_order_deliver=$ordermodel->where("deleted=0  and status=6")->field('order_id,deliver_time,deliver_address,deliver_remind_horseman')->select();
        foreach ($arr_order_deliver as $value) {
            //提前一小时，提醒骑手准备上门送衣
            if($time>($value['deliver_time']-3600) and ($time-600)>$value['deliver_remind_horseman']){
                $row=array(
                    'deliver_remind_horseman'=>$time
                );
                $order_id=$value['order_id'];
                $ordermodel->where("order_id='$order_id'")->save($row);
                $shop_name=$ordermodel->where("order_id='$order_id'")->getField('shop_name');
                $remark="请先前往洗衣店(".$shop_name.")取衣服，然后给客户送衣。点我，马上接单";
                $this->remind_songyi_horseman_tem($value,$remark);//通知消息
            }
        }
    }
    
    private function remind_users() {
        $time=  time();
        //每24小时，提醒用户选择送衣时间
        $ordermodel=D('Order');
        $arr_order=$ordermodel->where("deleted=0  and status=5")->field('order_id,user_id,remind_user_time')->select();
        foreach ($arr_order as $value) {
            //每24小时，提醒用户选择送衣时间
            if(($time-86400)>$value['remind_user_time']){
                $row=array(
                    'remind_user_time'=>$time
                );
                $order_id=$value['order_id'];
                $ordermodel->where("order_id='$order_id'")->save($row);
                $remark="点我,选择给您上门送衣时间";
                $this->remind_user_tem($value['order_id'],$remark);//通知消息
            }
        }
    }
    
    private function remind_pay() {
        $time=  time();
        //每2小时，提醒用户付款
        $ordermodel=D('Order');
        $arr_order=$ordermodel->where("deleted=0  and status=8 and pay_status=1")->field('order_id,user_id,remind_pay_time')->select();
        foreach ($arr_order as $value) {
            //每2小时，提醒用户付款
            if(($time-7200)>$value['remind_pay_time']){
                $row=array(
                    'remind_pay_time'=>$time
                );
                $order_id=$value['order_id'];
                $ordermodel->where("order_id='$order_id'")->save($row);
                $remark='点我，马上付款';
                $this->deliver_tem($order_id, $remark);//通知消息
            }
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
    private function remind_horseman_tem($order,$remark){
        $horsemanmodel=D('Horseman');
        $arr_horseman=$horsemanmodel->getField('open_id',true);
        $address=  unserialize($order['order_address']);
        foreach ($arr_horseman as $value) {
            $template_id="FAMVTSzVfg8IC9YKCfjAx8WD2ttaz8UvDF_B924inZ8";
            $url=U('Horseman/order_view',array('order_id'=>$order['order_id']));
            $arr_data=array(
                'first'=>array('value'=>"又有新的预约时间到了，准备接单吧","color"=>"#666"),
                'keyword1'=>array('value'=>date("m月d日 H:i",$order['appointment_time']).'--'.date("H:i",(int)$order['appointment_time']+3600),"color"=>"#666"),
                'keyword2'=>array('value'=>$address['location'].' '.$address['address'],"color"=>"#666"),
                'keyword3'=>array('value'=>$address['name'].' '.$address['mobile'],"color"=>"#666"),
                'keyword4'=>array('value'=>'衣物',"color"=>"#666"),
                'keyword5'=>array('value'=>$order['remark']?$order['remark']:'无',"color"=>"#666"),
                'remark'=>array('value'=>$remark,"color"=>"#F90505")
            );
            $this->response_template($value, $template_id, $url, $arr_data);
        }
    }
    
    private function remind_songyi_horseman_tem($order,$remark){
        $order_id=$order['order_id'];
        $order_goodsmodel=D('Order_goods');
        $arr_goods=$order_goodsmodel->where("order_id='{$order_id}'")->field('goods_name,goods_number')->select();
        $goods='';
        $key_last = count($arr_goods)-1;
        foreach ($arr_goods as $k=>$value) {
            if($k != $key_last){
                $goods.=$value['goods_name'].'×'.$value['goods_number'].'、'; 
            }else{
                $goods.=$value['goods_name'].'×'.$value['goods_number'];
            }
        }
        $horsemanmodel=D('Horseman');
        $arr_horseman=$horsemanmodel->getField('open_id',true);
        $address=  unserialize($order['deliver_address']);
        foreach ($arr_horseman as $value) {
            $template_id="FAMVTSzVfg8IC9YKCfjAx8WD2ttaz8UvDF_B924inZ8";
            $url=U('Horseman/order_view',array('order_id'=>$order['order_id']));
            $arr_data=array(
                'first'=>array('value'=>"又有新的预约时间到了，准备接单吧","color"=>"#666"),
                'keyword1'=>array('value'=>date("m月d日 H:i",$order['deliver_time']).'--'.date("H:i",(int)$order['deliver_time']+3600),"color"=>"#666"),
                'keyword2'=>array('value'=>$address['location'].' '.$address['address'],"color"=>"#666"),
                'keyword3'=>array('value'=>$address['name'].' '.$address['mobile'],"color"=>"#666"),
                'keyword4'=>array('value'=>$goods,"color"=>"#666"),
                'keyword5'=>array('value'=>$order['remark']?$order['remark']:'无',"color"=>"#666"),
                'remark'=>array('value'=>$remark,"color"=>"#F90505")
            );
            $this->response_template($value, $template_id, $url, $arr_data);
        }
    }
    
    private function remind_user_tem($order_id,$remark){
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='$order_id'")->find();
        $order_goodsmodel=D('Order_goods');
        $arr_goods=$order_goodsmodel->where("order_id='{$order_id}'")->field('goods_name,goods_number')->select();
        $goods='';
        $key_last = count($arr_goods)-1;
        foreach ($arr_goods as $k=>$value) {
            if($k != $key_last){
                $goods.=$value['goods_name'].'×'.$value['goods_number'].'、'; 
            }else{
                $goods.=$value['goods_name'].'×'.$value['goods_number'];
            }
        }
        $template_id="A1s_g4U-xAAqCxGKdeUnZgiluf7gy-HT-T3kbVCerK4";
        $url=U('Order/view',array('order_id'=>$order_id));
        $arr_data=array(
            'first'=>array('value'=>'您的订单已清洗完成，请及时选择送衣时间，以便骑手送达',"color"=>"#666"),
            'keyword1'=>array('value'=>$order['order_no'],"color"=>"#666"),
            'keyword2'=>array('value'=>$goods,"color"=>"#666"),
            'remark'=>array('value'=>$remark,"color"=>"#F90505")
        );
        $usersmodel=D('Users');
        $user_id=$order['user_id'];
        $user_open_id=$usersmodel->where("user_id='{$user_id}'")->getField('open_id');
        $this->response_template($user_open_id, $template_id, $url, $arr_data);
    }
    
    private function deliver_tem($order_id,$remark){
        $order_goodsmodel=D('Order_goods');
        $arr_goods=$order_goodsmodel->where("order_id='{$order_id}'")->field('goods_name,goods_number')->select();
        $goods='';
        $number=0;
        $key_last = count($arr_goods)-1;
        foreach ($arr_goods as $k=>$value) {
            if($k != $key_last){
                $goods.=$value['goods_name'].'×'.$value['goods_number'].'、'; 
            }else{
                $goods.=$value['goods_name'].'×'.$value['goods_number'];
            }
            $number+=(int)$value['goods_number'];
        }
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='$order_id'")->find();
        $address=  unserialize($order['deliver_address']);
        $template_id="Iqo9S-38jP8Pjw1PNt2tw4MUXyWN8H9W1QWa0LugavI";
        $url=U('Order/view',array('order_id'=>$order['order_id']));
        
        //用户open_id
        $user_id=$order['user_id'];
        $usersmodel=D('Users');
        $open_id=$usersmodel->where("user_id='{$user_id}'")->getField('open_id');
        $arr_data=array(
            'first'=>array('value'=>"您的衣物已经清洗完成并送达上门，请您付款","color"=>"#666"),
            'keyword1'=>array('value'=>$order['order_no'],"color"=>"#666"),
            'keyword2'=>array('value'=>'衣干净',"color"=>"#666"),
            'keyword3'=>array('value'=>$number.'件('.$goods.')',"color"=>"#666"),
            'keyword4'=>array('value'=>'￥'.($order['price']-$order['daijinquan']),"color"=>"#666"),
            'remark'=>array('value'=>'送达时间:'.date("Y年m月d日 H:i",$order['deliver_time']).'。'.$remark,"color"=>"#F90505")
        );
        $this->response_template($open_id, $template_id, $url, $arr_data);
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
            'keyword4'=>array('value'=>date("Y年m月d日 H:i:s",$order['created']),"color"=>"#666"),
            'keyword5'=>array('value'=>$user['user_name'],"color"=>"#666"),
            'remark'=>array('value'=>$remark,"color"=>"#F90505")
        );
        $this->response_template($user['open_id'], $template_id, $url, $arr_data);
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


