<?php
namespace Admin\Controller;
use Admin\Controller;
class OrdermanageController extends FontEndController {
   
    public function index(){
        $ordermodel=D('Order');
        $count=$ordermodel->where("deleted=0")->count();
        $page=$this->get_page($count, 10);
        $page_foot=$page->show();//显示页脚信息
        $list=$ordermodel->table('m_order t1,m_users t2')->where("t1.user_id=t2.user_id and t1.deleted=0")->limit($page->firstRow.','.$page->listRows)->order('t1.order_id desc')->select();
        
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
        if(!$_POST['order_id']){
            $this->error('订单号获取失败！');
        }
        $order_id=$_POST['order_id'];
        $ordermodel=D('Order');
        $kuaidi=array(
            'company'=>$_POST['kuaidi_company'],
            'no'=>$_POST['kuaidi_no']
            );
        $row=  array(
            'kuaidi'=>  serialize($kuaidi),
            'status'=>'3'
        );
        $result_add=$ordermodel->where("order_id=$order_id")->save($row);
        if($result_add){
            $this->success('商品发货成功！',U('Ordermanage/index'),2);
        }
    }
    
    

    



}