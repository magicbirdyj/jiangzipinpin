<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Controller;
use Home\Controller;
class ShopController extends FontEndController {
    public function index(){
        $shop_id=$_GET['shop_id'];
        
        $shopsmodel=D('Shops');
        $shop=$shopsmodel->where("shop_id=$shop_id")->find();
        $goodsmodel=D('Goods');
        $count=$goodsmodel->where("shop_id='$shop_id' and is_delete=0")->count();
        $shop['goods_number']=$count;
        $this->assign('shop',$shop);
        
        $get=$_GET;
            $this->assign('get',$get);//get赋值给模板
            //order的url
            $get_cs['order_moren']=$get;
            unset($get_cs['order_moren']['order']);
            
            $get_cs['order_xiaoliang']=$get;
            $get_cs['order_xiaoliang']['order']='number_desc';
            
            $get_cs['order_price_desc']=$get;
            $get_cs['order_price_desc']['order']='price_desc';
            $get_cs['order_price_asc']=$get;
            $get_cs['order_price_asc']['order']='price_asc';
            
            $get_cs['order_pinglun']=$get;
            $get_cs['order_pinglun']['order']='pinglun_desc';
            
            $get_cs['order_update']=$get;
            $get_cs['order_update']['order']='update_desc';
            
            //显示风格url
            $get_cs['fengge_0']=$get;
            unset($get_cs['fengge_0']['fengge']);
            $get_cs['fengge_1']=$get;
            $get_cs['fengge_1']['fengge']='1';
            
            
            
            $this->assign('get_cs',$get_cs);//get_cs赋值给模板
        //排序
        $order=$_GET['order'];
        if(empty($order)){ 
            $list=$goodsmodel->where("shop_id='$shop_id' and is_delete=0")->field('price,tuan_number,goods_img_qita,goods_id,shop_name,goods_name,tuan_price,yuan_price,goods_img,comment_number,score,buy_number,daijinquan')->order('daijinquan desc,buy_number desc,score desc,last_update desc')->select();
        }elseif($order==='number_desc'){
            $list=$goodsmodel->where("shop_id='$shop_id' and is_delete=0")->field('price,tuan_number,goods_img_qita,goods_id,shop_name,goods_name,tuan_price,yuan_price,goods_img,comment_number,score,buy_number,daijinquan')->order('buy_number desc,last_update desc')->select();
        }elseif($order==='price_desc'){
            $list=$goodsmodel->where("shop_id='$shop_id' and is_delete=0")->field('price,tuan_number,goods_img_qita,goods_id,shop_name,goods_name,tuan_price,yuan_price,goods_img,comment_number,score,buy_number,daijinquan')->order('tuan_price desc,last_update desc')->select();
        }elseif($order==='pinglun_desc'){
            $list=$goodsmodel->where("shop_id='$shop_id' and is_delete=0")->field('price,tuan_number,goods_img_qita,goods_id,shop_name,goods_name,tuan_price,yuan_price,goods_img,comment_number,score,buy_number,daijinquan')->order('score desc,last_update desc')->select();
        }elseif($order==='update_desc'){
            $list=$goodsmodel->where("shop_id='$shop_id' and is_delete=0")->field('price,tuan_number,goods_img_qita,goods_id,shop_name,goods_name,tuan_price,yuan_price,goods_img,comment_number,score,buy_number,daijinquan')->order('last_update desc')->select();
        }elseif($order==='price_asc'){
            $list=$goodsmodel->where("shop_id='$shop_id' and is_delete=0")->field('price,tuan_number,goods_img_qita,goods_id,shop_name,goods_name,tuan_price,yuan_price,goods_img,comment_number,score,buy_number,daijinquan')->order('tuan_price,last_update desc')->select();
        }
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