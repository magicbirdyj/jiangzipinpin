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
            'name'=>$name,
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
        $horseman_id=$horsemanmodel->where("open_id='$horseman_open_id'")->getField('user_id');
        if(!$horseman_id){
            $this->ajaxReturn(FALSE);
            exit;
        }
        $row=array(
            'status'=>2,
            'horseman_id'=>$horseman_id
        );
        $order_id=$post['order_id'];
        $ordermodel=D('Order');
        $result=$ordermodel->where("order_id='$order_id'")->save($row);
        if($result){
            //发送模板消息给该骑手，接单成功
            $remark='点我，查看订单详情';
            $this->taking_success_tem($order_id,$horseman_open_id,$remark);
        }
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
    
    
    
    
    
    
    
    
    public function goods_xiajia() {
        $post=$_POST;
        if($post['check']!='xiajia'){
            exit;
        }
        $goods_id=$post['goods_id'];
        $goodsmodel=D('Goods');
        $open_id=$_SESSION['wei_huiyuan']['open_id'];
        $shopsmodel=D('Shops');
        $huiyuan_shop_id=$shopsmodel->where("open_id='$open_id'")->getField('shop_id');
        $shop_id=$goodsmodel->where("goods_id=$goods_id")->getField('shop_id');
        if($huiyuan_shop_id!=$shop_id){
            $result=false;
            $this->ajaxReturn($result);
            exit();
        }
        $row=array(
                'is_delete' => 1
            );
        $result = $goodsmodel->where("goods_id=$goods_id")->save($row);
        $this->ajaxReturn($result);
    }
    
    
    public function goods_shangjia() {
        $post=$_POST;
        if($post['check']!='shangjia'){
            exit;
        }
        $goods_id=$post['goods_id'];
        $goodsmodel=D('Goods');
        $open_id=$_SESSION['wei_huiyuan']['open_id'];
        $shopsmodel=D('Shops');
        $huiyuan_shop_id=$shopsmodel->where("open_id='$open_id'")->getField('shop_id');
        $shop_id=$goodsmodel->where("goods_id=$goods_id")->getField('shop_id');
        if($huiyuan_shop_id!=$shop_id){
            $result=false;
            $this->ajaxReturn($result);
            exit();
        }
        $row=array(
                'is_delete' => 0
            );
        $result = $goodsmodel->where("goods_id=$goods_id")->save($row);
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
}


