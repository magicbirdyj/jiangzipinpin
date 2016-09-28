<?php
namespace Admin\Controller;
use Admin\Controller;
class OrdermanageController extends FontEndController {
   
    public function index(){
        $ordermodel=D('Order');
        $status=$_GET['status'];
        if($status=='1'){
            $count=$ordermodel->where("pay_status=0 and deleted=0 and status <>7")->count();
            $page=$this->get_page($count, 10);
            $page_foot=$page->show();//显示页脚信息
            $list=$ordermodel->table('m_order t1,m_users t2')->where("t1.pay_status=0 and t1.user_id=t2.user_id and t1.deleted=0 and t1.status <>7")->limit($page->firstRow.','.$page->listRows)->order('t1.order_id desc')->select();
        }elseif($status=='2'){
            $count=$ordermodel->where("tuan_no=0 and status=1 and pay_status=1 and deleted=0")->count();
            $page=$this->get_page($count, 10);
            $page_foot=$page->show();//显示页脚信息
            $list=$ordermodel->table('m_order t1,m_users t2')->where("t1.tuan_no=0 and t1.user_id=t2.user_id and t1.status=1 and t1.pay_status=1 and t1.deleted=0")->limit($page->firstRow.','.$page->listRows)->order('t1.order_id desc')->select();
        }elseif($status=='3'){
            $count=$ordermodel->where("status=3 and deleted=0")->count();
            $page=$this->get_page($count, 10);
            $page_foot=$page->show();//显示页脚信息
            $list=$ordermodel->table('m_order t1,m_users t2')->where("t1.status=3 and t1.user_id=t2.user_id and t1.deleted=0")->limit($page->firstRow.','.$page->listRows)->order('t1.order_id desc')->select();
        }elseif($status=='4'){
            $count=$ordermodel->where("status=4 and deleted=0")->count();
            $page=$this->get_page($count, 10);
            $page_foot=$page->show();//显示页脚信息
            $list=$ordermodel->table('m_order t1,m_users t2')->where("t1.status=4 and t1.user_id=t2.user_id and t1.deleted=0")->limit($page->firstRow.','.$page->listRows)->order('t1.order_id desc')->select();
        }elseif(!$status){
            $count=$ordermodel->where("deleted=0")->count();
            $page=$this->get_page($count, 10);
            $page_foot=$page->show();//显示页脚信息
            $list=$ordermodel->table('m_order t1,m_users t2')->where("t1.user_id=t2.user_id and t1.deleted=0")->limit($page->firstRow.','.$page->listRows)->order('t1.order_id desc')->select();
        }
        $this->assign('status',$status);
        $this->assign('list',$list);
        $this->assign('page_foot',$page_foot);
        $this->display();
    }
    
    public function fahuo(){
        if(!$_GET['order_id']){
            $this->error('订单号获取失败！');
        }
        $order_id=$_GET['order_id'];
        $this->assign('order_id',$order_id);
        $this->display();
    }
    
    public function fahuo_check(){
        $post=$_POST;
        if(!$post['order_id']){
            $this->error('订单号获取失败！');
        }
        $order_id=$post['order_id'];
        $ordermodel=D('Order');
        if($post['fangshi']=='1'){
            $data=array(
                'fangshi'=>'1',
                'qishou_name'=>$post['qishou_name'],
                'qishou_mobile'=>$post['qishou_mobile']
            );
        }elseif($post['fangshi']=='2'){
            $data=array(
                'fangshi'=>'2',
                'company'=>$post['kuaidi_company'],
                'company_bianma'=>$post['kuaidi_bianma'],
                'no'=>$post['kuaidi_no']
            );
        }
        
        $row=  array(
            'kuaidi'=>  serialize($data),
            'status'=>'3'
        );
        $result_add=$ordermodel->where("order_id=$order_id")->save($row);
        if($result_add){
            $this-> fahuo_tep_success($order_id);//  发送消息给团员
            $this->success('商品发货成功！',U('Ordermanage/index'),2);
        }
    }
    
    

    private function fahuo_tep_success($order_id){
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id=$order_id")->find();
        $kuaidi=  unserialize($order['kuaidi']);
        if($kuaidi['fangshi']=='1'){
            $keyword1='（同城）骑手：'.$kuaidi['qishou_name'];
            $keyword2='（同城）骑手电话：'.$kuaidi['qishou_mobile'];
        }else{
             $keyword1=$kuaidi['company'];
              $keyword2=$kuaidi['no'];
        }
        $user_id=$order['user_id'];
        $usersmodel=D('Users');
        $open_id=$usersmodel->where("user_id=$user_id")->getField('open_id');
        $template_id="RDphvvFI8o8yTMi5ItXCCMl-JFZvLXTfvNErqjVBcRM";
        $goods_id=$order['goods_id'];
        $url=U('Home/Order/view_wuliu',array('order_id'=>$order_id));
        $arr_data=array(
            'first'=>array('value'=>"您好，您购买的商品：".$order["goods_name"]." 已经启程，讲马上到达您的身边！","color"=>"#666"),
            'keyword1'=>array('value'=>$keyword1,"color"=>"#666"),
            'keyword2'=>array('value'=>$keyword2,"color"=>"#666"),
            'keyword3'=>array('value'=>$order["goods_name"],"color"=>"#666"),
            'keyword4'=>array('value'=>$order['buy_number'],"color"=>"#666"),
            'remark'=>array('value'=>"点我，查看物流详细信息","color"=>"#F90505")
        );
        $this->response_template($open_id, $template_id, $url, $arr_data);
    }



}