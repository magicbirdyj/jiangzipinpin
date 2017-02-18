<?php
namespace Home\Controller;
use Home\Controller;
class AdvertController extends FontEndController {
    public function advert(){
        $id=$_GET['id'];
        $advertmodel=D('admin_advert');
        $lunbo=$advertmodel->where("id='$id'")->field('xuhao,advert_desc')->find();
        $this->assign('lunbo',$lunbo);
        $this->display();
    }
    
    public function pintuan_liucheng(){
       
        $this->display();
    }
    
    public function fengxiang_choujiang() {
        C('TOKEN_ON',false);//取消表单令牌
         //首先必须获取关注状态
        if(!isset($_SESSION['guanzhu'])||$_SESSION['guanzhu']==''){
            header("location:". U("Login/index"));
            exit();
            //$this->error('关注信息为空');
        }
        $user_id=$_SESSION['huiyuan']['user_id'];
        $usersmodel=D('Users');
        $user=$usersmodel->where("user_id='{$user_id}'")->field('choujiang,fenxiang')->find();
        $this->assign('user',$user);
        $this->assign('guanzhu',$_SESSION['guanzhu']);
        $this->display();
    }
    
}