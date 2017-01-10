<?php
namespace Admin\Controller;
use Admin\Controller;
class UsersmanageController extends FontEndController {
   
    public function index(){
        $usersmodel=D('Users');
        $count=$usersmodel->count();
        $page=$this->get_page($count, 10);
        $page_foot=$page->show();//显示页脚信息
        $list=$usersmodel->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page_foot',$page_foot);
        $this->display('index');
    }
    

    public function become_horseman() {
        $open_id=$_SESSION['huiyuan']['open_id'];
        $horsemanmodel=D('Horseman');
        $horseman=$horsemanmodel->where("open_id='$open_id'")->find();
        if($horseman){
            header("location:". $_SESSION['ref']);
            exit();
        }
        $this->display();
    }
    
    


}