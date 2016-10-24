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
    
    public function news_xiajia() {
        $post=$_POST;
        if($post['check']!='xiajia'){
            exit;
        }
        $news_id=$post['news_id'];
        $newsmodel=D('News');
        $open_id=$_SESSION['wei_huiyuan']['open_id'];
        $arr_admin=array('oSI43woDNwqw6b_jBLpM2wPjFn_M','oSI43wkMT4fkU_DXrU7XfdE9krA0','oSI43wqsiGkFK2YaGsC34fgwHEL0');
        if(!in_array($open_id, $arr_admin)){
            $result=false;
            $this->ajaxReturn($result);
            exit();
        }
        $row=array(
                'is_delete' => 1
            );
        $result = $newsmodel->where("news_id=$news_id")->save($row);
        $this->ajaxReturn($result);
    }
    
    public function news_shangjia() {
        $post=$_POST;
        if($post['check']!='shangjia'){
            exit;
        }
        $news_id=$post['news_id'];
        $newsmodel=D('News');
        $open_id=$_SESSION['wei_huiyuan']['open_id'];
        $arr_admin=array('oSI43woDNwqw6b_jBLpM2wPjFn_M','oSI43wkMT4fkU_DXrU7XfdE9krA0','oSI43wqsiGkFK2YaGsC34fgwHEL0');
        if(!in_array($open_id, $arr_admin)){
            $result=false;
            $this->ajaxReturn($result);
            exit();
        }
        $row=array(
                'is_delete' => 0
            );
        $result = $newsmodel->where("news_id=$news_id")->save($row);
        $this->ajaxReturn($result);
    }
}


