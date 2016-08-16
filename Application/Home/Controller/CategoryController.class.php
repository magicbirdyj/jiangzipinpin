<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Controller;
use Home\Controller;
class CategoryController extends FontEndController {
    public function index(){
        if(isset($_GET['cid'])){
            //获取所有分类
            $categorymodel=D('category');
            $cat_all=$categorymodel->field('cat_id,cat_name')->select();
            $this->assign('cat_all',$cat_all);
            
            $cat_id=$_GET['cid'];
            $cat_name=$categorymodel->where("cat_id=$cat_id")->getField("cat_name");
            if(!$cat_name){
                $this->error('未找到该分类');
            }
            $this->assign('cat_name',$cat_name);
            $this->assign("title","酱紫拼拼 ".$cat_name);
            $url['full']=$_SERVER['REQUEST_URI'];
            $url['url']=str_replace('.html', '',$url['full']);
            $this->assign("url",$url);
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
            //代金券url
            $get_cs['daijinquan']=$get;
            $get_cs['daijinquan']['daijinquan']='1';
            $get_cs['no_daijinquan']=$get;
            unset($get_cs['no_daijinquan']['daijinquan']);
            
           
            
  
            
            
            
            
            $this->assign('get_cs',$get_cs);//get_cs赋值给模板
            
           
            
            //把shuxing参数给分割成数组
            if($_GET['shuxing']!==null){
                $shuxing=explode('__',$_GET['shuxing']);
                $this->assign('shuxing',$shuxing);
                
                foreach ($shuxing as $key => $value) {
                    $shuxing_value=explode('-',$value);
                    $tiaojian['shuxing'][]=array('LIKE','%'.$shuxing_value[0].'\";s:'.strlen($shuxing_value[1]).':\"'.$shuxing_value[1].'%');
                }
            }
            
            
            $data_cat=$categorymodel->where("cat_id=$cat_id")->getField('shuxing');
            $arr_shuxing0=unserialize($data_cat);//得到反序列化属性数组
            $this->assign("arr_shuxing0",$arr_shuxing0);//给模板里面的$arr_shuxing0赋值// 手机端用 
            //$shuxing_count=count($arr_shuxing0);
            //$this->assign(shuxing_count,$shuxing_count);
            //$arr_shuxing=  array_chunk($arr_shuxing0, 2,true);
            //$this->assign("arr_shuxing",$arr_shuxing);//给模板里面的$arr_shuxing赋值
            
            
            $goodsmodel=D('Goods');
            if($_GET['tuan_number']!=null){
                $tiaojian['tuan_number']=array('eq',$_GET['tuan_number']);
            }
            
            if($_GET['daijinquan']==='1'){
                $tiaojian['daijinquan']='1';
            }
           
            
            $count=$goodsmodel->where($tiaojian)->where("cat_name='$cat_name' and is_delete=0")->count();

            
            //排序
            $order=$_GET['order'];
            if(empty($order)){ 
                $list=$goodsmodel->where($tiaojian)->where("cat_name='$cat_name' and is_delete=0")->field('price,tuan_number,goods_img_qita,goods_id,user_name,goods_name,tuan_price,yuan_price,goods_img,comment_number,score,buy_number,daijinquan')->order('daijinquan desc,buy_number desc,score desc,last_update desc')->select();
            }elseif($order==='number_desc'){
                $list=$goodsmodel->where($tiaojian)->where("cat_name='$cat_name' and is_delete=0")->field('price,tuan_number,goods_img_qita,goods_id,user_name,goods_name,tuan_price,yuan_price,goods_img,comment_number,score,buy_number,daijinquan')->order('buy_number desc,last_update desc')->select();
            }elseif($order==='price_desc'){
                $list=$goodsmodel->where($tiaojian)->where("cat_name='$cat_name' and is_delete=0")->field('price,tuan_number,goods_img_qita,goods_id,user_name,goods_name,tuan_price,yuan_price,goods_img,comment_number,score,buy_number,daijinquan')->order('tuan_price desc,last_update desc')->select();
            }elseif($order==='pinglun_desc'){
                $list=$goodsmodel->where($tiaojian)->where("cat_name='$cat_name' and is_delete=0")->field('price,tuan_number,goods_img_qita,goods_id,user_name,goods_name,tuan_price,yuan_price,goods_img,comment_number,score,buy_number,daijinquan')->order('score desc,last_update desc')->select();
            }elseif($order==='update_desc'){
                $list=$goodsmodel->where($tiaojian)->where("cat_name='$cat_name' and is_delete=0")->field('price,tuan_number,goods_img_qita,goods_id,user_name,goods_name,tuan_price,yuan_price,goods_img,comment_number,score,buy_number,daijinquan')->order('last_update desc')->select();
            }elseif($order==='price_asc'){
                $list=$goodsmodel->where($tiaojian)->where("cat_name='$cat_name' and is_delete=0")->field('price,tuan_number,goods_img_qita,goods_id,user_name,goods_name,tuan_price,yuan_price,goods_img,comment_number,score,buy_number,daijinquan')->order('tuan_price,last_update desc')->select();
            }
            
            //手机端
            $this->get_thumb($list);
            $this->assign('list',$list);
            
          
       //按团人数分的商品数量统计,应该去除$tiaojian里面的团购人数
        $tiaojian_count=$tiaojian;
        unset($tiaojian_count['tuan_number']);
        $arr_tuan_number=array('2','5','10');
        foreach ($arr_tuan_number as $value) {
            $tuan_number_where['tuan_number']=array('EQ',$value);
            $arr_count[$value]=$goodsmodel->where($tiaojian_count)->where("cat_name='$cat_name' and is_delete=0")->where($tuan_number_where)->count();
        }
        //按团人数分的商品数量统计
        $arr_count['tuan_number']=$goodsmodel->where($tiaojian_count)->where("cat_name='$cat_name' and is_delete=0")->count();
        
        //各种分类的商品数量,不要cat_name参数
        $tiaojian_count=$tiaojian;
        $tiaojian_count_noshuxing=$tiaojian_count;
        unset($tiaojian_count_noshuxing['shuxing']);
        $cat_allname=$categorymodel->getField('cat_name',true);
        foreach ($cat_allname as $value) {
            $cat_name_where['cat_name']=array('EQ',$value);
            if($cat_name==$value){
                $arr_count[$value]=$goodsmodel->where($tiaojian_count)->where("is_delete=0")->where($cat_name_where)->count();
            }else{
                $arr_count[$value]=$goodsmodel->where($tiaojian_count_noshuxing)->where("is_delete=0")->where($cat_name_where)->count();
            }
        }
       
            $this->assign('arr_count',$arr_count);
            $this->display(index);
        }else{
            $this->error('没有指定分类');
        }
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