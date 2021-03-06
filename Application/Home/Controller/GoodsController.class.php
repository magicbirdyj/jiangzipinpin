<?php

namespace Home\Controller;

use Home\Controller;

class GoodsController extends FontEndController {
    public function index() {
        $categorymodel=D('Category');
        $arr_cat_top=$categorymodel->where("pid='0' and deleted=0")->select();
        $this->assign('arr_cat_top',$arr_cat_top);
        $goodsmodel=D('Goods');
        foreach ($arr_cat_top as $value) {
            $pid=$value['cat_id'];
            $arr_cat[$pid]=$categorymodel->where("pid='$pid' and deleted=0")->select();
            foreach ($arr_cat[$pid] as $value_cat) {
                $cat_id=$value_cat['cat_id'];
                $goods[$pid][$cat_id]=$goodsmodel->where("cat_id='$cat_id' and is_delete=0")->select();
            }
        }
        $arr_cat[1]['hot']=array('cat_name'=>'爆品');
        $this->assign('arr_cat',$arr_cat);
        $goods[1]['hot']=$goodsmodel->where($where)->where("is_hot=1 and is_delete=0")->select();
        $this->assign('goods',$goods);
        
        
        $canshu=$_GET['canshu'];
        $this->assign('canshu',$canshu);
        $this->display();
    }
    public function buy() {
        $open_id=$_SESSION['huiyuan']['open_id'];
        $usersmodel=D('Users');
        $user=$usersmodel->where("open_id='$open_id'")->find();
        if($user['phone']==0){
            $this->redirect('Member/bangding_phone');
        }
        
        
        if(isset($_GET['code'])){//微信地址接口
            $code=$_GET['code'];
            $parameters=$this->get_address_data($code);
            $this->assign('signPackage',$parameters);
        }
        $this->assign('open_id',$open_id);
        //微信地址接口
        $user_id=$_SESSION['huiyuan']['user_id'];
        $address=$usersmodel->where("user_id=$user_id")->field('address,default_address,daijinquan')->find();
        if($address['address']!=''){
                $arr_address=  unserialize($address['address']);
            }else{
                $arr_address='';
            }
        $this->assign('arr_address',$arr_address);
        $default=$address['default_address'];
        $default_address=$arr_address[$default];
        $this->assign('default_Address',$default_address);
        $this->assign('default_eq',$default);
        
        $this->display();

    }
    
    
    public function buy_success(){
        $post=$_POST;
        $ordermodel = D('Order');
        // 手动进行令牌验证 
        if (!$ordermodel->autoCheckToken($_POST)){ 
            if($_COOKIE['order_id']){
                $order_id=$_COOKIE['order_id'];//一个小时内重复提交订单，进入支付页面
                $this->redirect('Order/index');
            }else{
                $this->error('不能重复提交订单',U('Order/index'));
            }
            exit();
        }
        $user_id = $_SESSION['huiyuan']['user_id'];
        $arr_order_address=array(
            'name'=>$post['address_name'],
            'mobile'=>$post['address_mobile'],
            'location'=>$post['address_location'],
            'address'=>$post['address_address'],
        );
        $order_address=  serialize($arr_order_address);
        $order_time=$post['order_time'];
        $order_remark=mb_substr($post['remark'], 0, 120,'utf-8');
        $row = array(
            'user_id' => $user_id,
            "order_no" => $this->getUniqueOrderNo(),
            'appointment_time'=>$order_time,
            'remark'=>$order_remark,
            'status' => 1, //生成订单
            'pay_status' => 0, //支付状态为未支付
            'created' => time(),
            'updated' => time(),
            'order_address'=>$order_address,
        );
        $result = $ordermodel->add($row); //订单信息写入数据库order表
        if(!$result){
            $this->error('订单提交失败，请重新提交', $_SERVER['HTTP_REFERER'], 3);
        }
        $usersmodel=D('Users');
        $user_name=$usersmodel->where("user_id='$user_id'")->getField('user_name');
        $order_actionmodel=D('Order_action');
        $row_action=array(
            'order_id'=>$result,
            'action_type'=>'user',
            'actionuser_id'=>$user_id,
            'actionuser_name'=>$user_name,
            'order_status'=>1,//生成订单
            'pay_status' => 0, //支付状态为未支付
            'log_time'=>time()
        );
        $order_actionmodel->add($row_action); //订单操作信息写入数据库order_action表
        cookie('order_id',$result,36000);
        $this->redirect('Goods/success_buy_page',array('order_id'=>$result));
        
    }
    public function success_buy_page() {
        $order_id=$_GET['order_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='{$order_id}'")->find();
        $user_id=$_SESSION['huiyuan']['user_id'];
        if($user_id!=$order['user_id']){
            $this->error('您没有该订单!');
        }
        $order['order_address']=  unserialize($order['order_address']);
        $this->assign('order',$order);
        $this->display();
    }

    
   

    public function zhifu() {
        $user_id = $_SESSION['huiyuan']['user_id'];
        $order_id = $_GET['order_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='{$order_id}'")->find();
        $order_user_id = $order['user_id']; //登录用户无该订单权限
        if ($order_user_id != $user_id) {//登录用户无该订单权限
            $this->error('您没有该订单权限');
        }
        if($order['status']!=8||$order['deleted']==1){
            $this->error('该订单状态已无法付款');
        }
        if($order['pay_status']!=0){
            $this->error('该订单已经付款');
        }
       
        
        $this->assign('order',$order);
       
        $this->alipay($order_id);
       
    }

    /**
     * 生成唯一的订单号 会查询订单表来保证唯一性
     * 
     */
    private function getUniqueOrderNo() {
        $code = getname();
        $OrderModel = D("Order");
        $res = $OrderModel->where("order_no='{$code}' and deleted=0")->find();
        if ($res) {
            $this->getUniqueOrderNo();
        }
        return $code;
    }

    //生成微信支付订单
    private function alipay($order_id) {
        $ordermodel = D('Order');
        $order = $ordermodel->where("order_id=$order_id and deleted=0 ")->find();
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
        //微信
        $user_id=$order['user_id'];
        $usersmodel=D('Users');
        $open_id=$usersmodel->where("user_id=$user_id")->getField('open_id');
        $paydata=array(
            'body'=>sprintf("衣干净： 清洗物品：%s",  mb_substr($goods, 0, 25, 'utf-8')),
            'total_fee'=>$order['dues'],
            'notify'=>PAY_HOST . U("Goods/notifyweixin"),
            'shop_name'=>'衣干净',
            'order_no'=>$order['order_no'],
            'open_id'=>$open_id,
            'goods_name'=> $goods,
            'order_id'=>$order_id
        );
        if(is_weixin()){//如果是微信浏览器 直接公众号支付，否则 扫一扫支付
            $this->weixin_zhijiezhifu($paydata);
        }else{
            $this->weixin_saomazhifu($paydata);
        } 

    }
    
    private function weixin_zhijiezhifu($paydata){
            vendor('wxp.native'); //引入第三方类库
            $orderInput = new \WxPayUnifiedOrder();
            $orderInput->SetBody($paydata['body']);
            $orderInput->SetAttach($paydata['shop_name']);
            $orderInput->SetOut_trade_no($paydata['order_no']);
            $orderInput->SetTotal_fee($paydata['total_fee'] * 100);
            $orderInput->SetGoods_tag($paydata['shop_name']);
            $orderInput->SetNotify_url($paydata['notify']);
            $orderInput->SetTrade_type("JSAPI");
            $orderInput->SetOpenid($paydata['open_id']);//必须为登录
            $orderInfo = \WxPayApi::unifiedOrder($orderInput, 300);

            if (is_array($orderInfo) && $orderInfo['result_code'] == 'SUCCESS') {
                $jsapi = new \WxPayJsApiPay();
                $jsapi->SetAppid($orderInfo["appid"]);
                $timeStamp = time();
                $timeStamp = "$timeStamp";
                $jsapi->SetTimeStamp($timeStamp);
                $jsapi->SetNonceStr(\WxPayApi::getNonceStr());
                $jsapi->SetPackage("prepay_id=" . $orderInfo['prepay_id']);
                $jsapi->SetSignType("MD5");
                $jsapi->SetPaySign($jsapi->MakeSign());
                $parameters = $jsapi->GetValues();
            } else {
                $this->error("下单失败" . $orderInfo['return_msg']);
            }
            
            $this->assign('paydata',$paydata);
            $this->assign("parameters", json_encode($parameters));
            $this->display('zhifu');
    }
    
    

    /**
     * 微信支付的 异步回调
     * 
     */
    public function notifyweixin(){
        vendor('wxp.notify'); //引入第三方类库
        $notify = new \PayNotifyCallBack();
        $notify->Handle(false);
        $returnPay = $notify->getPayReturn();
        if (!$returnPay || $returnPay[""]) {
            echo "fail";
        }
        if (array_key_exists("return_code", $returnPay) && array_key_exists("result_code", $returnPay) && $returnPay["return_code"] == "SUCCESS" && $returnPay["result_code"] == "SUCCESS") {
            $ordermodel = D('Order');
            $order = $ordermodel->where("order_no='{$returnPay["out_trade_no"]}' and deleted=0 ")->find();
            //验证交易金额是否为订单的金额;
            if (!empty($returnPay['total_fee'])) {
                if ($returnPay['total_fee'] != $order['dues'] * 100) {
                    file_put_contents('./index.txt',$returnPay['total_fee'],FILE_APPEND);
                    file_put_contents('./index.txt',$order['dues'],FILE_APPEND);
                    echo "fail";
                }
            } 
            $order_id = $order['order_id'];
            $row = array(
                'pay_status' => 1, //支付状态为支付
                'updated' => time(),
                "pay_type" => 1,
                "trade_no" => $returnPay['transaction_id'],
                "pay_info" => serialize($returnPay)
            );
            if (!$ordermodel->where("order_id='{$order_id}'")->save($row)) {
                echo "fail";
            }
            
           
            echo "success";
        }
    }

  

    

 
    
    
    
    public function gmcg_wx(){
        $this->get_weixin_config();
        $this->assign('title','付款成功');
        $order_id=$_GET['order_id'];
        $user_id=$_SESSION['huiyuan']['user_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='{$order_id}' and deleted=0")->find();
        $this->assign('order', $order);
        if($user_id!=$order['user_id']){
            $this->error('您没有该订单！',U('Order/index'),3);
        }
        if($order['pay_status']!='1'){
            $this->error('未付款成功,将返回付款页面',U('Goods/zhifu',"order_id=$order_id"));
        }
        
        
        $order_goodsmodel=D('Order_goods');
        $order_goods=$order_goodsmodel->where("order_id='$order_id'")->select();
        $order_price=0;
        
        $this->assign('order_goods',$order_goods);

        $this->display('gmcg_dandu');

    }
    
    public function fenxiang() {
        $order_id=$_GET['order_id'];
        $this->get_weixin_config();
        $this->assign('title','分享返现');
        $user_id=$_SESSION['huiyuan']['user_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='{$order_id}' and deleted=0")->find();
        $this->assign('order', $order);
        if($user_id!=$order['user_id']){
            $this->error('您没有该订单！',U('Order/index'),3);
        }
        if($order['pay_status']!='1'){
            $this->error('未付款成功,将返回付款页面',U('Goods/zhifu',"order_id=$order_id"));
        }
        
        
        $order_goodsmodel=D('Order_goods');
        $order_goods=$order_goodsmodel->where("order_id='$order_id'")->select();
        $order_price=0;
        foreach ($order_goods as $value) {
            $order_price+=$value['price']*$value['goods_number'];
        }
        $this->assign('order_price',$order_price);
        $this->assign('order_goods',$order_goods);
        $this->display('gmcg_dandu');
    }
    
    
    
    
    public function jiance_pay(){
        if($_POST['check']==='wx_zhifu'){
            $order_id=$_POST['order_id'];
            $ordermodel=D('Order');
            $pay_status=$ordermodel->where("order_id=$order_id")->getField('pay_status');
            $this->ajaxReturn($pay_status);
        }
    }



    public function sellection_join() {
        if ($_POST['check'] !== 'sellection_join') {
            exit();
        }
        $user_id = $_SESSION['huiyuan']['user_id'];
        $goods_id = $_POST['goods_id'];
        $sellectionmodel = D('Sellection');
        $count = $sellectionmodel->where("user_id=$user_id and goods_id=$goods_id")->count();
        if ($count != '0') {
            exit();
        }
        $row = array(
            'user_id' => $user_id,
            'goods_id' => $goods_id,
            'add_time' => mktime()
        );
        $result = $sellectionmodel->add($row); //信息写入数据库
        if ($result) {
            $data = '1';
        } else {
            $data = '-1';
        }
        $this->ajaxReturn($data);
        exit();
    }
    
    
    
    
   






     
    
    private function use_daijinquan($user_id,$ky_daijinquan){
        $usersmodel=D('Users');
        $daijinquan=$usersmodel->where("user_id=$user_id")->getField('daijinquan');
        $arr=  unserialize($daijinquan);
        foreach ($arr as $key => $value) {
            if($value['sum']==$ky_daijinquan){
                array_splice($arr, $key, 1);
                break;;
            }
        }
        $new_daijinquan=  serialize($arr);
        $row=array(
            'daijinquan'=>$new_daijinquan
        );
        $result=$usersmodel->where("user_id=$user_id")->save($row);
        return $result;
    }
    
    
    
    private function weixin_saomazhifu(){
        $this->display('bendi_zhifu');
    }
    public function bendi_zhifu(){
         $order_id = $_GET['order_id'];
            $row = array(
                'pay_status' => 1, //支付状态为支付
                'updated' => time(),
                "pay_type" => 1
            );
            $ordermodel=D('Order');
            if (!$ordermodel->where("order_id=$order_id")->save($row)) {
                $this->error('支付失败');
            }
            $this->redirect('Goods/gmcg_wx',array('order_id'=>$order_id),0);
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
                $this->refund_tep_weihuojiang($order_id);
            } else {
                $this->error("退款失败" .  $refundInfo['return_msg']);
            }
               
    }
    
    private function refund_tep_weihuojiang($order_id){
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id=$order_id")->find();
        $user_id=$order['user_id'];
        $usersmodel=D('Users');
        $open_id=$usersmodel->where("user_id=$user_id")->getField('open_id');
        $template_id="95UZl_xx_sjJdno-l1X4vUrRvOLlsepMEZHPFsofZms";
        $goods_id=$order['goods_id'];
        $url=U('Goods/index',array('goods_id'=>$goods_id));
        $arr_data=array(
            'first'=>array('value'=>"您好，您拼团购买的1元购商品：".$order["goods_name"]." 未被抽中，已全额退款给您！","color"=>"#666"),
            'reason'=>array('value'=>"1元购活动将在".($order['tuan_number']-1)."名团员中抽取一人获奖，团长将100%获奖，您还可以自己去开团，组团成功后，您将100%获奖","color"=>"#F90505"),
            'refund'=>array('value'=>$order["dues"]."元","color"=>"#666"),
            'remark'=>array('value'=>"点我，现在就去开团","color"=>"#F90505")
        );
        $this->response_template($open_id, $template_id, $url, $arr_data);
    }
    
    private function send_dainjinquan_tep($order_id){
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id=$order_id")->find();
        $user_id=$order['user_id'];
        $usersmodel=D('Users');
        $open_id=$usersmodel->where("user_id=$user_id")->getField('open_id');
        $template_id="-CvJ9caeLvY9Vdqehftu8JkW0LMg0_xfmsRdK8V3_WI";
        $url=U('Index/index');
        $tm=time();
        $youxiaoqi=date('Y.m.d',$tm).'-'.date('Y.m.d',($tm+345600));
        $arr_data=array(
            'first'=>array('value'=>"亲爱的用户，88元代金券已经成功发放给您，前往：会员中心--我的代金券 即可查看","color"=>"#666"),
            'keyword1'=>array('value'=>"88元代金券","color"=>"#F90505"),
            'keyword2'=>array('value'=>date('Y年m月d日'),"color"=>"#666"),
            'keyword3'=>array('value'=>'已经成功发放给您的账户',"color"=>"#666"),
            'keyword4'=>array('value'=>'代金券使用有效期：'.$youxiaoqi,"color"=>"#666"),
            'remark'=>array('value'=>"点我，查看更多拼团，前往使用代金券。","color"=>"#F90505")
        );
        $this->response_template($open_id, $template_id, $url, $arr_data);
    }
    
    
    public function dianpu_sale_tep($order_id) {
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id=$order_id")->find();
        $user_id=$order['user_id'];
        $usersmodel=D('Users');
        $user_name=$usersmodel->where("user_id=$user_id")->getField('user_name');
        $shop_id=$order['shop_id'];
        $shopsmodel=D('Shops');
        $shop=$shopsmodel->where("shop_id=$shop_id")->field('open_id,shop_name')->find();
        $template_id="ichV1e55uH-myne3PhPaYmgNQuCu0K54v6NuUqjTrIU";
        $url=U('Shop/view_order',array('order_id'=>$order_id));
        $remark="请您尽快发货哦,点击发货";
        $arr_data=array(
            'first'=>array('value'=>"恭喜您，".$user_name."成功购买了店铺[".$shop['shop_name']."]的商品!","color"=>"#666"),
            'keyword1'=>array('value'=>$order['order_no'],"color"=>"#666"),
            'keyword2'=>array('value'=>$order['goods_name'].'： '.$order['zx_shuxing'],"color"=>"#666"),
            'keyword3'=>array('value'=>$order['price'],"color"=>"#666"),
            'keyword4'=>array('value'=>$order['price'],"color"=>"#666"),
            'keyword5'=>array('value'=>$order['order_address'],"color"=>"#666"),
            'remark'=>array('value'=>$remark,"color"=>"#F90505")
        );
        $this->response_template($shop['open_id'], $template_id, $url, $arr_data);
    }
    
    private function get_88_daijinquan($user_id) {
        $this->get_daijinquan($user_id, '通用券', 5);
        $this->get_daijinquan($user_id, '通用券', 8);
        $this->get_daijinquan($user_id, '通用券', 10);
        $this->get_daijinquan($user_id, '通用券', 15);
        $this->get_daijinquan($user_id, '通用券', 20);
        $this->get_daijinquan($user_id, '通用券', 30);
    }
    
     private function get_address_data($code){
            $wangye=$this->get_wangye($code);
            //同时相当于伪登陆
            $row=array(
                 'open_id'=>$wangye['openid'],
                );
            $_SESSION['wei_huiyuan']=$row;
            
            $access_token=$wangye['access_token'];//共享收货地址必须使用网页授权access_token
            
            $appid=APPID;
            $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $nonceStr=$this->createNonceStr(32);
            $timeStamp=time();
            $timeStamp="$timeStamp";
             $data = array();
		$data["appid"] =$appid;
		$data["url"] = $url;
		$data["timestamp"] = $timeStamp;
		$data["noncestr"] = $nonceStr;
		$data["accesstoken"] = $access_token;
		ksort($data);
                $params = $this->ToUrlParams($data);
                $addrSign = sha1($params);
		
		$afterData = array(
			"addrSign" => $addrSign,
			"signType" => "sha1",
			"scope" => "jsapi_address",
			"appId" => $appid,
			"timeStamp" => $data["timestamp"],
			"nonceStr" => $data["noncestr"]
		);
		$parameters = json_encode($afterData);
                return $parameters;
    }
    
    private function get_wangye($code){
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".APPID."&secret=".APPSECRET."&code=".$code."&grant_type=authorization_code" ;
        $res = file_get_contents($url); //获取文件内容或获取网络请求的内容
        $result = json_decode($res, true);//接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
        //S('wangye_access_token',$result['access_token'],7000);
        return $result;
  }
  
  private function ToUrlParams($urlObj)
	{
		$buff = "";
		foreach ($urlObj as $k => $v)
		{
			if($k != "sign"){
				$buff .= $k . "=" . $v . "&";
			}
		}
		
		$buff = trim($buff, "&");
		return $buff;
    }
   
   
}
