<?php
namespace Admin\Controller;
use Admin\Controller;
class ShopsmanageController extends FontEndController {
   
    public function index(){
        $shopsmodel=D('Shops');
        $count=$shopsmodel->count();
        $page=$this->get_page($count, 10);
        $page_foot=$page->show();//显示页脚信息
        $list=$shopsmodel->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page_foot',$page_foot);
        $this->display();
    }
    public function add_shop(){
       C('TOKEN_ON',false);
       $this->display();
    }

    
    public function release_check() {
        $post=$_POST;
        $post['created']=time();
        $shopsmodel=D('Shops');
        $result=$shopsmodel->add($post);
        if($result){
            $this->success('店铺注册成功!',U('Shopsmanage/index'),3);
        }else{
            $this->error('出错,注册不成功');
        }
    }
    
    public function title_ajax() {
        $data=$_POST;
        if($data['check']=='title_ajax'){
            $shop_name=$data['shop_name'];
            $shopsmodel=D('Shops');
            $count=$shopsmodel->where("shop_name='$shop_name'")->count();
            $this->ajaxReturn($count);
        }
        $this->ajaxReturn($shop_name);
    }
    
    


}