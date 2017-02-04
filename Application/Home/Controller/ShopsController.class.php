<?php
namespace Home\Controller;
use Home\Controller;
class ShopsController extends FontEndController {
   
    public function index(){
        $this->display('order');
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
            $order_price+=$value['cost_price']*$value['goods_number'];
        }
        $this->assign('order_price',$order_price);
        $this->assign('order_goods',$order_goods);
        $this->assign('order',$order);
        
        
        //骑手信息
        $horsemanmodel=D('Horseman');
        $horseman_id=$order['horseman_id'];
        $horseman=$horsemanmodel->where("horseman_id='$horseman_id'")->find();
        $this->assign('horseman',$horseman);
        $this->display('view');
    }
    public function shops_confirm() {
        $post=$_POST;
        $order_id=$post['order_id'];
        $this->assign('order_id',$order_id);
        $ordermodel=D('Order');
        $shop_id=$ordermodel->where("order_id='{$order_id}'")->getField('shop_id');
        $shopsmodel=D('Shops');
        $shop=$shopsmodel->where("shop_id='$shop_id'")->find();
        $open_id=$_SESSION['huiyuan']['open_id'];
        if($shop['open_id']!=$open_id){
            $this->error('骑手并没送达该订单到您工厂,无法对其确认商品',U('Shop/index'));
            exit;
        }
        
        //获取图片URL,分割成数组
        if($post['goods_img']!==''){
            $arr_img=explode('+img+',$post['goods_img']);
            //移动文件 并且改变url
            foreach ($arr_img as &$value) {
                $today=substr($value,26,8);//获取到文件夹名  如20150101
                creat_file(UPLOAD.'image/appraise/'.$today);//创建文件夹（如果存在不会创建）
                $img_url_thumb=$this->thumb($value, 500, 800);//thumb
                rename($img_url_thumb, str_replace('Public/Uploads/image/temp', UPLOAD.'image/appraise',$value));//移动文件
                $value=str_replace('Public/Uploads/image/temp','Public/Uploads/image/shop_note',$value);  
                $value='/'.$value;
            }
            $str_img=serialize($arr_img);//序列化数组
        }
        //商店确认收到衣服
        $row=array(
            'shop_note'=>$post['pingjia_text'],
            'shop_img'=>$str_img,
            'status'=>4
        );
       $result=$ordermodel->where("order_id='$order_id'")->save($row);
       if($result){
           //订单操作表
            $order_actionmodel=D('Order_action');
            $row=array(
                'order_id'=>$order_id,
                'action_type'=>'shop',
                'actionuser_id'=>$shop_id,
                'actionuser_name'=>$shop['shop_name'],
                'order_status' => 4,
                'pay_status'=>0,
                'log_time'=>time()
            );
            $result = $order_actionmodel->add($row);
       }
       if(!$result){
           $this->error('商家确认商品出错');
           exit;
       }
        $this->display('success');
    }
    
    private function thumb($url,$a,$b){
        $image = new \Think\Image(); 
        $index=strripos($url,"/");
        $img_url=substr($url,0,$index+1);
        $img_name=substr($url,$index+1); 
        $image->open($url);
        creat_file($img_url.'thumb');//创建文件夹（如果存在不会创建）
        $image->thumb($a, $b)->save($img_url.'thumb/'.$img_name);
        return $img_url.'thumb/'.$img_name;
    }

    
    
    


}