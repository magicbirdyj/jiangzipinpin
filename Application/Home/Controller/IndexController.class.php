<?php
namespace Home\Controller;
use Home\Controller;
class IndexController extends FontEndController {
   
    public function index(){
        $advertmodel=D('admin_advert');
        $lunbo=$advertmodel->where("position='轮播'")->field('xuhao,img_url,url')->select();
        $this->assign('lunbo',$lunbo);
        $goodsmodel=D('Goods');
        $list=$goodsmodel->select();
        $this->get_thumb($list);
        $this->assign('list',$list);
        $this->display();
    }
    

    
     
private function get_thumb(&$arr){
        foreach ($arr as &$value) {
            $arr_goods_img_qita=  unserialize($value['goods_img_qita']);
            $index=strripos($arr_goods_img_qita[0],"/");
            $img_url=substr($arr_goods_img_qita[0],0,$index+1);
            $img_name=substr($arr_goods_img_qita[0],$index+1);
            $value['goods_img_qita_0']=$img_url.'thumb/'.$img_name;
        }
    }
}