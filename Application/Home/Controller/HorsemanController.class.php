<?php
namespace Home\Controller;
use Home\Controller;
class HorsemanController extends FontEndController {
   
    public function index(){
        $status=$_GET['status'];
        $this->assign('canshu',$_GET['status']);
        $ordermodel=D('Order');
        $open_id=$_SESSION['huiyuan']['open_id'];
        $horsemanmodel=D('Horseman');
        $horseman_id=$horsemanmodel->where("open_id='{$open_id}'")->getField('horseman_id');
        $status_count['no_taking']=$ordermodel->where("status=1 and deleted=0")->count();//获取待抢单条数
        $status_count['quyi']=$ordermodel->where("horseman_id='{$horseman_id}' and status>=2 and status<4 and deleted=0")->count();//获取正在取衣条数
        $status_count['songyi']=$ordermodel->where("deliver_horseman_id='{$horseman_id}' and status=7  and deleted=0")->count();//获取已完成条数
        $status_count['finished']=$ordermodel->where("(horseman_id='{$horseman_id}' and status>3 and deleted=0) or (deliver_horseman_id='{$horseman_id}' and status>7 and deleted=0)")->count();//获取待付款条数
        $this->assign(status_count,$status_count);
        $time=  time();
        $this->assign('time',$time);
        if(empty($status)){
            $list=$ordermodel->where("status=1 and deleted=0")->select();
            $this->assign('list',$list);
        }else if($status==='quyi'){
             $list=$ordermodel->where("horseman_id='{$horseman_id}' and status>=2 and status<4 and deleted=0")->select();
             $this->assign('list',$list);
         }else if($status==='songyi'){
             $list=$ordermodel->where("deliver_horseman_id='{$horseman_id}' and status=7  and deleted=0")->select();
             $this->assign('list',$list);
         }else if($status==='finished'){
             $list=$ordermodel->where("(horseman_id='{$horseman_id}' and status>3 and deleted=0) or (deliver_horseman_id='{$horseman_id}' and status>7 and deleted=0)")->select();
             $this->assign('list',$list);
         }
         $this->display();
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
            $this->error('该订单号不存在或已经删除','/Home/Horseman/index');
        }
        //骑手信息
        $horsemanmodel=D('Horseman');
        $horseman_id=$order['horseman_id'];
        $horseman=$horsemanmodel->where("horseman_id='$horseman_id'")->find();
        $this->assign('horseman',$horseman);
        //送衣骑士信息
        $deliver_horseman_id=$order['deliver_horseman_id'];
        $deliver_horseman=$horsemanmodel->where("horseman_id='{$deliver_horseman_id}'")->find();
        $this->assign('deliver_horseman',$deliver_horseman);
        
        $open_id=$_SESSION['huiyuan']['open_id'];
        if($order['status']>=2 && $order['status']<=5){
            if($open_id!=$horseman['open_id']){
                $this->error('您没有接到该订单','/Home/Horseman/index');
            }
        }elseif ($order['status']>=7 && $order['status']<=8) {
            if($open_id!=$deliver_horseman['open_id']){
                $this->error('您没有接到该订单');
            }
        }elseif($order['status']==10){
            $this->error('该订单已取消','/Home/Horseman/index');
        }elseif(!($order['status']==1||$order['status']==6)){
            $this->error('该订单已完成','/Home/Horseman/index');
        }
        
        
        
        $order_goodsmodel=D('Order_goods');
        $order_goods=$order_goodsmodel->where("order_id='$order_id'")->select();
        $order_price=0;
        foreach ($order_goods as $value) {
            $order_price+=$value['price']*$value['goods_number'];
        }
        $this->assign('order_price',$order_price);
        $this->assign('order_goods',$order_goods);
        $address=  unserialize($order['order_address']);
        $order['order_address']=$address;
        $this->assign('order',$order);
        
        //订单操作记录
        $order_actionmodel=D('Order_action');
        $order_action=$order_actionmodel->where("order_id='$order_id'")->order('log_time asc')->select();
        $this->assign('order_action',$order_action);
        
        
        $this->display('view');
    }
    //骑手接单
    public function order_taking() {
        $order_id=$_GET['order_id'];
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
            
            //发送模板消息给客户，骑士开始上门取衣
            $remark='点我，查看订单详情';
            $this->quyi_tixing_tem($order_id,$horseman,$remark);
        }
        $this->redirect('/Horseman/success_taking_page',array('order_id'=>$order_id));
    }
    public function success_taking_page() {
        $order_id=$_GET['order_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='{$order_id}'")->find();
        $horseman_open_id=$_SESSION['huiyuan']['open_id'];
        $horsemanmodel=D('Horseman');
        $horseman=$horsemanmodel->where("open_id='$horseman_open_id'")->find();
        if($horseman['horseman_id']!=$order['horseman_id']){
            $this->error('您没有接到该订单!','/Horseman/index');
        }
        $order['order_address']=  unserialize($order['order_address']);
        $this->assign('horseman',$horseman);
        $this->assign('order',$order);
        $this->assign('status','取衣');
        $this->display();
    }
    public function confirm_goods() {
        $order_id=$_GET['order_id'];
        $this->assign('order_id',$order_id);
        $ordermodel=D('Order');
        $horseman_id=$ordermodel->where("order_id='{$order_id}'")->getField('horseman_id');
        $horsemanmodel=D('Horseman');
        $horsemen_open_id=$horsemanmodel->where("horseman_id='$horseman_id'")->getField('open_id');
        $open_id=$_SESSION['huiyuan']['open_id'];
        if($horsemen_open_id!=$open_id){
            $this->error('您并没接取该订单,无法对其确认商品','/Home/Horseman/index');
            exit;
        }

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
        
        $this->display();
    }
    public function deliver_shop() {
        $order_id=$_GET['order_id'];
        $horsemanmodel=D('Horseman');
        $horseman_open_id=$_SESSION['huiyuan']['open_id'];
        $horseman=$horsemanmodel->where("open_id='$horseman_open_id'")->find();
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='{$order_id}'")->find();
        if($horseman['horseman_id']!=$order['horseman_id']){
            $this->error('您没有接取该订单','/Home/Horseman/index');
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
            $this->redirect('Horseman/success_deliver_shop_page',array('order_id'=>$open_id));
        }
    }
    public function success_deliver_shop_page() {
        $order_id=$_GET['order_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='{$order_id}'")->find();
        $horseman_open_id=$_SESSION['huiyuan']['open_id'];
        $horsemanmodel=D('Horseman');
        $horseman=$horsemanmodel->where("open_id='$horseman_open_id'")->find();
        if($horseman['horseman_id']!=$order['horseman_id']){
            $this->error('您没有接到该订单!','/Home/Horseman/index');
        }
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
        $this->assign('goods',$goods);
        $this->assign('horseman',$horseman);
        $this->assign('order',$order);
        $this->display();
    }
    //骑手 送衣接单
    public function order_taking_deliver() {
        $order_id=$_GET['order_id'];

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
            
            //发送模板消息给客户，骑士开始上门送衣
            $remark='点我，查看订单详情';
            $this->songyi_tixing_tem($order_id,$horseman,$remark);
        }
       $this->redirect('/Horseman/success_deliver_taking_page',array('order_id'=>$order_id));
    }
    public function success_deliver_taking_page() {
        $order_id=$_GET['order_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='{$order_id}'")->find();
        $horseman_open_id=$_SESSION['huiyuan']['open_id'];
        $horsemanmodel=D('Horseman');
        $horseman=$horsemanmodel->where("open_id='$horseman_open_id'")->find();
        if($horseman['horseman_id']!=$order['deliver_horseman_id']){
            $this->error('您没有接到该订单!','/Horseman/index');
        }
        $order['deliver_address']=  unserialize($order['deliver_address']);
        $this->assign('horseman',$horseman);
        $this->assign('order',$order);
        $this->assign('status','送衣');
        $this->display();
    }
    public function order_deliver() {
        $order_id=$_GET['order_id'];
        $this->assign('order_id',$order_id);
        $ordermodel=D('Order');
        $horseman_id=$ordermodel->where("order_id='{$order_id}'")->getField('deliver_horseman_id');
        $horsemanmodel=D('Horseman');
        $horseman=$horsemanmodel->where("horseman_id='$horseman_id'")->find();
        $horseman_open_id=$horseman['open_id'];
        $open_id=$_SESSION['huiyuan']['open_id'];
        if($horseman_open_id!=$open_id){
            $this->error('您并没接取该订单,无法对其确认送达','/Home/Horseman/index');
            exit;
        }
        $order=$ordermodel->where("order_id='{$order_id}'")->find();
        if($order['status']!=7){
            $this->error('该订单状态并非送取中..','/Home/Horseman/index');
        }
        $row=array(
            'status'=>8,
            'remind_pay_time'=>time()
        );
        $result=$ordermodel->where("order_id='{$order_id}'")->save($row);
        
        if($result){
            //订单动作
            $order_actionmodel=D ('Order_action');
            $row=array(
                'order_id'=>$order_id,
                'action_type'=>'horseman',
                'actionuser_id'=>$horseman['horseman_id'],
                'actionuser_name'=>$horseman['horseman_name'],
                'order_status' => 8,
                'pay_status'=>0,
                'log_time'=>time()
            );
            $result = $order_actionmodel->add($row);
        }
        if($result){
            // 发送模板消息给用户,请付款
            $remark='点我，马上付款';
            $this->deliver_tem($order_id, $remark);
            $this->redirect('Horseman/order_view',array('order_id'=>$order_id));
        }
        
        
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
    
    private function deliver_shop_tem($order_id,$open_id,$remark){
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
            'keyword5'=>array('value'=>($order['remark']?$order['remark']:'无'),"color"=>"#666"),
            'remark'=>array('value'=>$remark,"color"=>"#F90505")
        );
        $this->response_template($open_id, $template_id, $url, $arr_data);
    }
    private function taking_success_tem($order_id,$horseman_open_id,$remark){
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='$order_id'")->find();
        $address=  unserialize($order['order_address']);
        $template_id="PUE-zt-KqzrR73H1kTdHjVK-q-uaeFut4r9giZrzZJg";
        $url=U('Horseman/order_view',array('order_id'=>$order['order_id']));
        $arr_data=array(
            'first'=>array('value'=>"您已接单成功，马上出发吧","color"=>"#666"),
            'keyword1'=>array('value'=>date("m月d日 H:i",$order['appointment_time']).'--'.date("H:i",(int)$order['appointment_time']+3600),"color"=>"#666"),
            'keyword2'=>array('value'=>$address['location'].' '.$address['address'],"color"=>"#666"),
            'keyword3'=>array('value'=>$address['name'].' '.$address['mobile'],"color"=>"#666"),
            'keyword4'=>array('value'=>'衣物',"color"=>"#666"),
            'remark'=>array('value'=>$remark,"color"=>"#F90505")
        );
        $this->response_template($horseman_open_id, $template_id, $url, $arr_data);
    }
    private function quyi_tixing_tem($order_id,$horseman,$remark) {
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='$order_id'")->find();
        $user_id=$order['user_id'];
        $usersmodel=D('Users');
        $open_id=$usersmodel->where("user_id='{$user_id}'")->getField('open_id');
        $template_id="6KyF98DcVHNm2sLEOuh6y58b8VjWQaTfn4EIJhhuKiw";
        $url=U('Order/view',array('order_id'=>$order['order_id']));
        $arr_data=array(
            'first'=>array('value'=>"尊敬的用户，我们的物流人员已上路为您取衣","color"=>"#666"),
            'keyword1'=>array('value'=>$order['order_no'],"color"=>"#666"),//订单号
            'keyword2'=>array('value'=>date("m月d日 H:i",$order['appointment_time']).'--'.date("H:i",(int)$order['appointment_time']+3600),"color"=>"#666"),//取衣时间
            'keyword3'=>array('value'=>$horseman['horseman_name'],"color"=>"#666"),
            'keyword4'=>array('value'=>$horseman['mobile_phone'],"color"=>"#666"),
            'remark'=>array('value'=>$remark,"color"=>"#F90505")
        );
        $this->response_template($open_id, $template_id, $url, $arr_data);
    }
    
    private function songyi_tixing_tem($order_id,$horseman,$remark) {
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='$order_id'")->find();
        $user_id=$order['user_id'];
        $usersmodel=D('Users');
        $open_id=$usersmodel->where("user_id='{$user_id}'")->getField('open_id');
        $template_id="IQglAAHREHnOhTGLKOHstnivFndPsYMWXViGI3d2K9Y";
        $url=U('Order/view',array('order_id'=>$order['order_id']));
        $arr_data=array(
            'first'=>array('value'=>"尊敬的用户，我们的物流人员已上路为您送衣","color"=>"#666"),
            'keyword1'=>array('value'=>$order['order_no'],"color"=>"#666"),//订单号
            'keyword2'=>array('value'=>date("m月d日 H:i",$order['deliver_time']).'--'.date("H:i",(int)$order['deliver_time']+3600),"color"=>"#666"),//送衣时间
            'keyword3'=>array('value'=>$horseman['horseman_name'],"color"=>"#666"),
            'keyword4'=>array('value'=>$horseman['mobile_phone'],"color"=>"#666"),
            'remark'=>array('value'=>$remark,"color"=>"#F90505")
        );
        $this->response_template($open_id, $template_id, $url, $arr_data);
    }
    
    private function deliver_taking_success_tem($order_id,$horseman_open_id,$remark){
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
        $address=  unserialize($order['deliver_address']);
        $template_id="PUE-zt-KqzrR73H1kTdHjVK-q-uaeFut4r9giZrzZJg";
        $url=U('Horseman/order_view',array('order_id'=>$order['order_id']));
        $arr_data=array(
            'first'=>array('value'=>"您已接单成功，马上出发吧,请去洗衣店（".$order['shop_name']."）取衣送往用户处","color"=>"#666"),
            'keyword1'=>array('value'=>date("m月d日 H:i",$order['deliver_time']).'--'.date("H:i",(int)$order['deliver_time']+3600),"color"=>"#666"),
            'keyword2'=>array('value'=>$address['location'].' '.$address['address'],"color"=>"#666"),
            'keyword3'=>array('value'=>$address['name'].' '.$address['mobile'],"color"=>"#666"),
            'keyword4'=>array('value'=>$goods,"color"=>"#666"),
            'remark'=>array('value'=>$remark,"color"=>"#F90505")
        );
        $this->response_template($horseman_open_id, $template_id, $url, $arr_data);
    }


}