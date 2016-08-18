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
    
    public function lanrenhunli(){
        $combomodel=D('Admin_combo');
        $combo=$combomodel->select();
        $goodsmodel=D('Goods');
        foreach($combo as $key=>$value){
            $combo[$key]['content']=  unserialize($value['content']);
            foreach ($combo[$key]['content'] as $k=>$goods_id){
                $goods=$goodsmodel->table('m_category t1,m_goods t2,m_users t3')->where("t2.goods_id=$goods_id and t2.cat_id=t1.cat_id and t2.user_id=t3.user_id")->field('t2.goods_id,t2.area,t2.user_id,t2.goods_name,t2.price,t2.yuan_price,t2.goods_img,t2.comment_number,t1.cat_name,t3.user_name,t2.goods_id,t2.buy_number')->find();
                $combo[$key]['content'][$k]=$goods;
            }
        }
        $this->assign('combo',$combo);
        $this->display('lanrenhunli');
    }
}