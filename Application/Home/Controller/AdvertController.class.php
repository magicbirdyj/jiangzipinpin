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
}