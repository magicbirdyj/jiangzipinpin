<?php
namespace Home\Controller;
use  Home\Controller;
class AjaxloginController extends FontEndController {
    public function goods_xiajia() {
        $post=$_POST;
        if($post['check']!='xiajia'){
            exit;
        }
        $goods_id=$post['goods_id'];
        $goodsmodel=D('Goods');
        $open_id=$_SESSION['wei_huiyuan']['open_id'];
        $shopsmodel=D('Shops');
        $huiyuan_shop_id=$shopsmodel->where("open_id='$open_id'")->getField('shop_id');
        $shop_id=$goodsmodel->where("goods_id=$goods_id")->getField('shop_id');
        if($huiyuan_shop_id!=$shop_id){
            $result=false;
            $this->ajaxReturn($result);
            exit();
        }
        $row=array(
                'is_delete' => 1
            );
        $result = $goodsmodel->where("goods_id=$goods_id")->save($row);
        $this->ajaxReturn($result);
    }
    
    
    public function goods_shangjia() {
        $post=$_POST;
        if($post['check']!='shangjia'){
            exit;
        }
        $goods_id=$post['goods_id'];
        $goodsmodel=D('Goods');
        $open_id=$_SESSION['wei_huiyuan']['open_id'];
        $shopsmodel=D('Shops');
        $huiyuan_shop_id=$shopsmodel->where("open_id='$open_id'")->getField('shop_id');
        $shop_id=$goodsmodel->where("goods_id=$goods_id")->getField('shop_id');
        if($huiyuan_shop_id!=$shop_id){
            $result=false;
            $this->ajaxReturn($result);
            exit();
        }
        $row=array(
                'is_delete' => 0
            );
        $result = $goodsmodel->where("goods_id=$goods_id")->save($row);
        $this->ajaxReturn($result);
    }
}


