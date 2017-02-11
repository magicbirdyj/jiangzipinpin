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
                'status' => 10
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
        $total_cost_price=0;
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
            $total_cost_price+=$goods['cost_price']*$value['number'];
            $result=$order_goodsmodel->add($row);
        }
        if($result){
            $row=array(
                'status' => 3,
                'price'=>$total_price,
                'cost_price'=>$total_cost_price,
                'dues'=>$total_price
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
            //发送消息给用户 确认商品成功
            $remark='点我，查看订单详情';
            $this->confirm_goods_tem($order_id,$remark);
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
    
    
    private function confirm_goods_tem($order_id,$remark){
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
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='$order_id'")->find();
        //获取用户open_id
        $usersmodel=D('Users');
        $user_id=$order['user_id'];
        $open_id=$usersmodel->where("user_id='$user_id'")->getField('open_id');
        $template_id="0tPJ9Kzm7sMTW80L61xyvlUdOd5jp4l0K83ietGMkH8";
        $url=U('Order/view',array('order_id'=>$order['order_id']));
        $arr_data=array(
            'first'=>array('value'=>"尊敬的客户，您的订单已经确认衣物。","color"=>"#666"),
            'keyword1'=>array('value'=>$order['order_no'],"color"=>"#666"),//订单编号
            'keyword2'=>array('value'=>date("Y年m月d日 H:i",$order['created']),"color"=>"#666"),//下单时间
            'keyword3'=>array('value'=>$goods,"color"=>"#666"),//订单详情
            'keyword4'=>array('value'=>$order['price'],"color"=>"#666"),//订单金额
            'remark'=>array('value'=>$remark,"color"=>"#F90505")
        );
        $this->response_template($open_id, $template_id, $url, $arr_data);
    }
}


