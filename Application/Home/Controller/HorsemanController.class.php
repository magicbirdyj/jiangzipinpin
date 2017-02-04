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
    public function order() {
        $this->display('order');
    }
    public function order_view() {
        $order_id=$_GET['order_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='{$order_id}'")->find();
        if($order['horseman_id']!=0){
            $order=$ordermodel->table('m_order t1,m_horseman t2')->where("t1.order_id='{$order_id}' and t1.horseman_id=t2.horseman_id")->find();
        }
        if(!$order){
            $this->error('该订单号不存在或已经删除 ');
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
        
        //骑手信息
        $horsemanmodel=D('Horseman');
        $horseman_id=$order['horseman_id'];
        $horseman=$horsemanmodel->where("horseman_id='$horseman_id'")->find();
        $this->assign('horseman',$horseman);
        $this->display('view');
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
            $this->error('您并没接取该订单,无法对其确认商品',U('Horseman/order'));
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

    
    
    


}