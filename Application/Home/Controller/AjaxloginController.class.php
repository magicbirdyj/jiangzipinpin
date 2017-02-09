<?php
namespace Home\Controller;
use  Home\Controller;
class AjaxloginController extends FontEndController {
    public function bangding_shouji() {
        $post=$_POST;
        if($post['check']!='bangding_check'){
            exit;
        }
        $phone=$post['shoujihao'];
        $open_id=$_SESSION['huiyuan']['open_id'];
        $usersmodel=D('Users');
        $row=array(
            'phone'=>$phone
        );
        $result=$usersmodel->where("open_id='$open_id'")->save($row);
        $this->ajaxReturn($result);
    }
    
    //成为骑手
    public function become_horseman() {
        $post=$_POST;
        if($post['check']!='bangding_check'){
            exit;
        }
        $phone=$post['shoujihao'];
        $open_id=$_SESSION['huiyuan']['open_id'];
        $name=$post['name'];
        $card_id=$post['card_id'];
        $horsemanmodel=D('Horseman');
        $row=array(
            'open_id'=>$open_id,
            'mobile_phone'=>$phone,
            'horseman_name'=>$name,
            'card_id'=>$card_id,
            'add_time'=>time(),
            'last_login'=>time(),
            'last_ip'=>$_SERVER['REMOTE_ADDR']
        );
        $result=$horsemanmodel->add($row);
        $this->ajaxReturn($result);
    }
    
    //骑手接单ajax
    public function order_taking() {
        $post=$_POST;
        if($post['check']!='wy_taking'){
            $this->ajaxReturn(false);
            exit;
        }
        $horsemanmodel=D('Horseman');
        $horseman_open_id=$_SESSION['huiyuan']['open_id'];
        $horseman=$horsemanmodel->where("open_id='$horseman_open_id'")->find();
        if(!$horseman['horseman_id']){
            $this->ajaxReturn(FALSE);
            exit;
        }
        $row=array(
            'status'=>2,
            'horseman_id'=>$horseman['horseman_id']
        );
        $order_id=$post['order_id'];
        $ordermodel=D('Order');
        $result=$ordermodel->where("order_id='$order_id'")->save($row);
        if($result){
            //订单操作表
            $order_actionmodel=D('Order_action');
            $row=array(
                'order_id'=>$order_id,
                'action_type'=>'horseman',
                'actionuser_id'=>$horseman['horseman_id'],
                'actionuser_name'=>$horseman['horseman_name'],
                'order_status' => 2,
                'pay_status'=>0,
                'log_time'=>time()
            );
            $result = $order_actionmodel->add($row);
        }
        if($result){
            //发送模板消息给该骑手，接单成功
            $remark='点我，确认取件';
            $this->taking_success_tem($order_id,$horseman_open_id,$remark);
        }
        $this->ajaxReturn($result);
    }
    
    //送达商店ajax
    public function deliver_shop() {
        $post=$_POST;
        if($post['check']!='wy_deliver'){
            $this->ajaxReturn(false);
            exit;
        }
        $horsemanmodel=D('Horseman');
        $horseman_open_id=$_SESSION['huiyuan']['open_id'];
        $horseman=$horsemanmodel->where("open_id='$horseman_open_id'")->find();
        $order_id=$post['order_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='{$order_id}'")->find();
        if($horseman['horseman_id']!=$order['horseman_id']){
            $this->ajaxReturn(FALSE);
            exit;
        }
        //订单加入商店id
        $shop_id='18';
        $shop_name='福莱特洗衣娄底店';
        $row=array(
            'shop_id'=>$shop_id,
            'shop_name'=>$shop_name
        );
        $result=$ordermodel->where("order_id='{$order_id}'")->save($row);
        if($result){
            $shopsmodel=D('Shops');
            $open_id=$shopsmodel->where("shop_id='$shop_id'")->getField('open_id');
            //发送模板消息给工厂，确认送达
            $remark='点我，确认衣物送达洗衣店';
            $this->deliver_shop_tem($order_id,$open_id,$remark);
            $this->ajaxReturn($result);
        }
    }
    
     //保存地址 ajax用
    public function save_or_add_address(){
        $data=$_POST;
        if(($data['open_id']!=$_SESSION['huiyuan']['open_id'])||($data['check']!='save'&&$data['check']!='add')){
            exit;
        }
        $open_id=$data['open_id'];
        $usersmodel=D('Users');
        $address=$usersmodel->where("open_id='$open_id'")->getField('address');
        $arr_address=  unserialize($address);
        
        $arr_data=array(
            'name'=>$data['name'],
            'mobile'=>$data['mobile'],
            'location'=>$data['location'],
            'address'=>$data['address']
        );
        if($data['check']=='save'){
            $arr_address[(int)$data['id']]=$arr_data;
        }elseif($data['check']=='add'){
            $arr_address[]=$arr_data;
        }
        $address=  serialize($arr_address);
        $row=array('address'=>$address);
        $result=$usersmodel->where("open_id='$open_id'")->save($row);
        $this->ajaxReturn($result);
    }
    
    //删除地址 ajax用
    public function delete_address() {
        $data=$_POST;
        if(($data['open_id']!=$_SESSION['huiyuan']['open_id'])||$data['check']!='del_address'){
            exit;
        }
        $open_id=$data['open_id'];
        $usersmodel=D('Users');
        $address=$usersmodel->where("open_id='$open_id'")->field('address,default_address')->find();
        $arr_address=  unserialize($address['address']);
        $length=count($arr_address);
        $int_id=(int)$data['id'];
        array_splice($arr_address,$int_id, 1);
        $address['address']=  serialize($arr_address);
        $row=array('address'=>$address['address']);
        if($int_id<=$address['default_address']){
            $row['default_address']=$address['default_address']-1;
        }
        $result=$usersmodel->where("open_id='$open_id'")->save($row);
        $this->ajaxReturn($row['default_address']);
    }
    
    //设置默认地址 ajax用
    public function shezhi_moren_address(){
        $data=$_POST;
        if(($data['open_id']!=$_SESSION['huiyuan']['open_id'])||$data['check']!='shezhi_moren'){
            exit;
        }
        $open_id=$data['open_id'];
        $item=$data['item'];
        $usersmodel=D('Users');
        $row=array('default_address'=>$item);
        $result=$usersmodel->where("open_id='$open_id'")->save($row);
        $this->ajaxReturn($result);
    }
    
    
    
    //取消订单
    public function quxiao_order(){
        if((!empty($_POST['order_id']))&&$_POST['check']==='quxiao_order'){
            $order_id=$_POST['order_id'];
            $ordermodel=D('Order');
            $row=array(
                'status' => 9
            );
            $order_user_id=$ordermodel->where("order_id=$order_id")->getField('user_id');//登录用户无该订单权限
            if($order_user_id!=$_SESSION['huiyuan']['user_id']){//登录用户无该订单权限
                $result=false;
                $this->ajaxReturn($result);
                exit();
            }
            $result = $ordermodel->where("order_id=$order_id")->save($row);
            $this->ajaxReturn($result);
        }
    }
    
    
    //骑手确认商品
    public function confirm_goods() {
        $post=$_POST;
        $order_id=$post['order_id'];
        $ordermodel=D('Order');
        $horseman_id=$ordermodel->where("order_id='$order_id'")->getField('horseman_id');
        $horsemanmodel=D('Horseman');
        $horseman=$horsemanmodel->where("horseman_id='$horseman_id'")->find();
        $open_id=$_SESSION['huiyuan']['open_id'];
        if($horseman['open_id']!=$open_id){
            exit;
        }
        $order_goodsmodel=D('Order_goods');
        $goodsmodel=D('Goods');
        $total_price=0;
        foreach ($post as $key => $value) {
            if($key=='order_id'){
                continue;
            }
            $goods_id=$value['goods_id'];
            $goods=$goodsmodel->where("goods_id=$goods_id")->find();
            $row=array(
                'order_id'=>$order_id,
                'goods_id'=>$value['goods_id'],
                'goods_name'=>$goods['goods_name'],
                'goods_number'=>$value['number'],
                'price'=>$goods['price'],
                'cost_price'=>$goods['cost_price']
            );
            $total_price+=$goods['price']*$value['number'];
            $result=$order_goodsmodel->add($row);
        }
        if($result){
            $row=array(
                'status' => 3,
                'price'=>$total_price
            );
            $result = $ordermodel->where("order_id=$order_id")->save($row);
        }
        if($result){
            $row=array(
                'order_id'=>$order_id,
                'action_type'=>'horseman',
                'actionuser_id'=>$horseman_id,
                'actionuser_name'=>$horseman['horseman_name'],
                'order_status' => 3,
                'pay_status'=>0,
                'log_time'=>time()
            );
            $order_actionmodel=D('Order_action');
            $result = $order_actionmodel->add($row);
        }
        $this->ajaxReturn($result);
    }
    
    
    //骑手 送衣接单ajax
    public function order_taking_deliver() {
        $post=$_POST;
        if($post['check']!='wy_taking'){
            $this->ajaxReturn(false);
            exit;
        }
        $horsemanmodel=D('Horseman');
        $horseman_open_id=$_SESSION['huiyuan']['open_id'];
        $horseman=$horsemanmodel->where("open_id='$horseman_open_id'")->find();
        if(!$horseman['horseman_id']){
            $this->ajaxReturn(FALSE);
            exit;
        }
        $row=array(
            'status'=>7,
            'deliver_horseman_id'=>$horseman['horseman_id']
        );
        $order_id=$post['order_id'];
        $ordermodel=D('Order');
        $result=$ordermodel->where("order_id='$order_id'")->save($row);
        if($result){
            //订单操作表
            $order_actionmodel=D('Order_action');
            $row=array(
                'order_id'=>$order_id,
                'action_type'=>'horseman',
                'actionuser_id'=>$horseman['horseman_id'],
                'actionuser_name'=>$horseman['horseman_name'],
                'order_status' => 7,
                'pay_status'=>0,
                'log_time'=>time()
            );
            $result = $order_actionmodel->add($row);
        }
        if($result){
            //发送模板消息给该骑手，接单成功
            $remark='点我，确认已经送达';
            $this->deliver_taking_success_tem($order_id,$horseman_open_id,$remark);
        }
        $this->ajaxReturn($result);
    }
    
    
    
    
    public function news_xiajia() {
        $post=$_POST;
        if($post['check']!='xiajia'){
            exit;
        }
        $news_id=$post['news_id'];
        $newsmodel=D('News');
        $open_id=$_SESSION['wei_huiyuan']['open_id'];
        $arr_admin=array('oSI43woDNwqw6b_jBLpM2wPjFn_M','oSI43wkMT4fkU_DXrU7XfdE9krA0','oSI43wqsiGkFK2YaGsC34fgwHEL0');
        if(!in_array($open_id, $arr_admin)){
            $result=false;
            $this->ajaxReturn($result);
            exit();
        }
        $row=array(
                'is_delete' => 1
            );
        $result = $newsmodel->where("news_id=$news_id")->save($row);
        $this->ajaxReturn($result);
    }
    
    public function news_shangjia() {
        $post=$_POST;
        if($post['check']!='shangjia'){
            exit;
        }
        $news_id=$post['news_id'];
        $newsmodel=D('News');
        $open_id=$_SESSION['wei_huiyuan']['open_id'];
        $arr_admin=array('oSI43woDNwqw6b_jBLpM2wPjFn_M','oSI43wkMT4fkU_DXrU7XfdE9krA0','oSI43wqsiGkFK2YaGsC34fgwHEL0');
        if(!in_array($open_id, $arr_admin)){
            $result=false;
            $this->ajaxReturn($result);
            exit();
        }
        $row=array(
                'is_delete' => 0
            );
        $result = $newsmodel->where("news_id=$news_id")->save($row);
        $this->ajaxReturn($result);
    }
    
    
    
    
    
    
    private function taking_success_tem($order_id,$horseman_open_id,$remark){
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='$order_id'")->find();
        $address=  unserialize($order['order_address']);
        $template_id="PUE-zt-KqzrR73H1kTdHjVK-q-uaeFut4r9giZrzZJg";
        $url=U('Horseman/order_view',array('order_id'=>$order['order_id']));
        $arr_data=array(
            'first'=>array('value'=>"您已接单成功，马上出发吧","color"=>"#666"),
            'keyword1'=>array('value'=>date("Y年m月d日 H:i",$order['appointment_time']),"color"=>"#666"),
            'keyword2'=>array('value'=>$address['location'].' '.$address['address'],"color"=>"#666"),
            'keyword3'=>array('value'=>$address['name'].' '.$address['mobile'],"color"=>"#666"),
            'keyword4'=>array('value'=>'衣物',"color"=>"#666"),
            'remark'=>array('value'=>$remark,"color"=>"#F90505")
        );
        $this->response_template($horseman_open_id, $template_id, $url, $arr_data);
    }
    
    private function deliver_taking_success_tem($order_id,$horseman_open_id,$remark){
        $order_goodsmodel=D('Order_goods');
        $arr_goods=$order_goodsmodel->where("order_id='{$order_id}'")->getField('goods_name',true);
        $goods='';
        $key_last = count($arr_goods)-1;
        foreach ($arr_goods as $k=>$value) {
            if($k != $key_last){
                $goods.=$value.'、'; 
            }else{
                $goods.=$value;
            }
        }
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='$order_id'")->find();
        $address=  unserialize($order['deliver_address']);
        $template_id="PUE-zt-KqzrR73H1kTdHjVK-q-uaeFut4r9giZrzZJg";
        $url=U('Horseman/order_deliver',array('order_id'=>$order['order_id']));
        $arr_data=array(
            'first'=>array('value'=>"您已接单成功，马上出发吧,请去洗衣店（".$order['shop_name']."）取衣送往用户处","color"=>"#666"),
            'keyword1'=>array('value'=>date("Y年m月d日 H:i",$order['deliver_time']),"color"=>"#666"),
            'keyword2'=>array('value'=>$address['location'].' '.$address['address'],"color"=>"#666"),
            'keyword3'=>array('value'=>$address['name'].' '.$address['mobile'],"color"=>"#666"),
            'keyword4'=>array('value'=>$goods,"color"=>"#666"),
            'remark'=>array('value'=>$remark,"color"=>"#F90505")
        );
        $this->response_template($horseman_open_id, $template_id, $url, $arr_data);
    }
    
    private function deliver_shop_tem($order_id,$open_id,$remark){
        $order_goodsmodel=D('Order_goods');
        $arr_goods=$order_goodsmodel->where("order_id='{$order_id}'")->getField('goods_name',true);
        $goods='';
        $key_last = count($arr_goods)-1;
        foreach ($arr_goods as $k=>$value) {
            if($k != $key_last){
                $goods.=$value.'、'; 
            }else{
                $goods.=$value;
            }
        }
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='$order_id'")->find();
        $horsemanmodel=D('Horseman');
        $horseman_id=$order['horseman_id'];
        $horseman=$horsemanmodel->where("horseman_id='{$horseman_id}'")->find();
        
        $template_id="aOHqR_v1qq1ycSSfqRVpDSW6izoEtmPSDRCOMuyW9iA";
        $url=U('Shops/order_view',array('order_id'=>$order['order_id']));
        $arr_data=array(
            'first'=>array('value'=>"有新的订单送达，请确认收取衣物","color"=>"#666"),
            'keyword1'=>array('value'=>$order['order_no'],"color"=>"#666"),
            'keyword2'=>array('value'=>$goods,"color"=>"#666"),
            'keyword3'=>array('value'=>$horseman['horseman_name'],"color"=>"#666"),
            'keyword4'=>array('value'=>date("Y年m月d日 H:i",time()),"color"=>"#666"),
            'keyword5'=>array('value'=>$order['remark'],"color"=>"#666"),
            'remark'=>array('value'=>$remark,"color"=>"#F90505")
        );
        $this->response_template($open_id, $template_id, $url, $arr_data);
    }
}


