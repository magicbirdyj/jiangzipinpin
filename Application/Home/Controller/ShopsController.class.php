<?php
namespace Home\Controller;
use Home\Controller;
class ShopsController extends FontEndController {
   
    public function index(){
        $status=$_GET['status'];
        $this->assign('canshu',$_GET['status']);
        $ordermodel=D('Order');
        $open_id=$_SESSION['huiyuan']['open_id'];
        $shopsmodel=D('Shops');
        $shop_id=$shopsmodel->where("open_id='{$open_id}'")->getField('shop_id');
        $status_count['all']=$ordermodel->where("shop_id='{$shop_id}' and deleted=0")->count();//获取所有条数
        $status_count['daishouqu']=$ordermodel->where("shop_id='{$shop_id}' and status=3 and deleted=0")->count();//获取待收取条数
        $status_count['finishing']=$ordermodel->where("shop_id='{$shop_id}' and status=4  and deleted=0")->count();//获取清洗中条数
        $status_count['clear_finished']=$ordermodel->where("shop_id='{$shop_id}' and status>=5  and deleted=0")->count();//获取清洗完成条数
        $this->assign(status_count,$status_count);
        $time=  time();
        $this->assign('time',$time);
        if(empty($status)){
            $list=$ordermodel->where("shop_id='{$shop_id}' and deleted=0")->select();
            $this->assign('list',$list);
        }else if($status==='daishouqu'){
             $list=$ordermodel->where("shop_id='{$shop_id}' and status=3 and deleted=0")->select();
             $this->assign('list',$list);
         }else if($status==='finishing'){
             $list=$ordermodel->where("shop_id='{$shop_id}' and status=4  and deleted=0")->select();
             $this->assign('list',$list);
         }else if($status==='clear_finished'){
             $list=$ordermodel->where("shop_id='{$shop_id}' and status>=5  and deleted=0")->select();
             $this->assign('list',$list);
         }
         $this->display();
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
        $ordermodel=D('Order');
         //进行令牌验证 
        if (!$ordermodel->autoCheckToken($_POST)){ 
            $this->redirect('Shops/success_shops_confirm_page');
            exit();
        }
        //获取图片URL,分割成数组
        if($post['goods_img']!==''){
            $arr_img=explode('+img+',$post['goods_img']);
            //移动文件 并且改变url
            foreach ($arr_img as &$value) {
                $today=substr($value,26,8);//获取到文件夹名  如20150101
                creat_file(UPLOAD.'image/shop_note/'.$today);//创建文件夹（如果存在不会创建）
                $img_url_thumb=$this->thumb($value, 500, 800);//thumb
                rename($img_url_thumb, str_replace('Public/Uploads/image/temp', UPLOAD.'image/shop_note',$value));//移动文件
                $value=str_replace('Public/Uploads/image/temp','Public/Uploads/image/shop_note',$value);  
                $value='/'.$value;
            }
            $str_img=serialize($arr_img);//序列化数组
        }
        $shop_id=$ordermodel->where("order_id='{$order_id}'")->getField('shop_id');
        $shopsmodel=D('Shops');
        $shop=$shopsmodel->where("shop_id='$shop_id'")->find();
        $open_id=$_SESSION['huiyuan']['open_id'];
        if($shop['open_id']!=$open_id){
            $this->error('骑手并没送达该订单到您工厂,无法对其确认商品',U('Shop/index'));
            exit;
        }

        //商店确认收到衣服
        $row=array(
            'shop_note'=>$post['pingjia_text'],
            'shop_img'=>$str_img,
            'status'=>4
        );
       $result=$ordermodel->where("order_id='{$order_id}'")->save($row);
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
       $this->assign('order_id',$order_id);
       $this->assign('确认收衣成功',$title);
       $this->assign('text',$post['pingjia_text']);
       $this->assign('arr_img',$arr_img);
       $this->redirect('Shops/success_shops_confirm_page');
    }
    
    public function success_shops_confirm_page() {
        $order_id=$_GET['order_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='{$order_id}'")->find();
        $open_id=$_SESSION['huiyuan']['open_id'];
        $shopsmodel=D('Shops');
        $shop_id=$shopsmodel->where("open_id='{$open_id}'")->getField('shop_id');
        if($order['shop_id']!=$shop_id){
            $this->error('您没有该订单权限','/Shops/index');
        }
        $order['shop_img']=  unserialize($order['shop_img']);
        $order['img_number']=count($order['shop_img']);
        $this->assign('order',$order);
        $this->display();
    }
    
    public function clear_complate() {
        $order_id=$_GET['order_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='{$order_id}'")->find();
        $shop_id=$order['shop_id'];
        $shopsmodel=D('Shops');
        $shop=$shopsmodel->where("shop_id='$shop_id'")->find();
        $open_id=$_SESSION['huiyuan']['open_id'];
        if($shop['open_id']!=$open_id||$order['status']!='4'){
            $this->error('您没有该订单或者该订单并不是清洗状态,无法对其确认清洗完成',U('Shop/index'));
            exit;
        }
        //发送模板消息给顾客，清洗完成
        $remark='点我，选择给您上门送衣时间';
        $this->clear_complate_tem($order_id,$remark);
        $row=array(
            'status'=>5,
            'remind_user_time'=>  time()
        );
        $result=$ordermodel->where("order_id='{$order_id}'")->save($row);
        if(!$result){
            $this->error('订单写入不成功',U('Shop/index'));
            exit;
        }else{
            //订单操作表
            $order_actionmodel=D('Order_action');
            $row=array(
                'order_id'=>$order_id,
                'action_type'=>'shop',
                'actionuser_id'=>$shop_id,
                'actionuser_name'=>$shop['shop_name'],
                'order_status' => 5,
                'pay_status'=>0,
                'log_time'=>time()
            );
            $result = $order_actionmodel->add($row);
        }
        if($result){
            $this->redirect('Shops/order_view',array('order_id'=>$order_id));
        }else{
            $this->error('订单操作表写入不成功',U('Shop/index'));
        }
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

    
    private function clear_complate_tem($order_id,$remark){
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='$order_id'")->find();
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
        $template_id="A1s_g4U-xAAqCxGKdeUnZgiluf7gy-HT-T3kbVCerK4";
        $url=U('Order/view',array('order_id'=>$order['order_id']));
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
    


}