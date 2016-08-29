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
            $cat_id=$_GET['cid'];
            $this->assign('cat_id',$cat_id);
            $categorymodel=D('category');
            $cat=$categorymodel->where("cat_id=$cat_id")->field("cat_name,pid")->find();
            $cat_name=$cat['cat_name'];
            if(!$cat_name){
                $this->error('未找到该分类');
            }
            $this->assign('cat_name',$cat_name);
            //获取和该二级分类有相同pid的所有二级分类
            $pid=$cat['pid'];
            if($pid==0){
               $cat_all=$categorymodel->where("pid=$cat_id")->field('cat_id,cat_name')->select();
               //找到该大类下的所有子分类
               $all_cat_id=$categorymodel->where("pid=$cat_id")->getField('cat_id',true);
               $tiaojian['cat_id']=array('in',$all_cat_id);
               //父类名字就是自己（已经是一级分类）
               $this->assign('p_cat_name',$cat_name);
               //父类id就是自己的id
               $pid=$cat_id;
            }else{
                $cat_all=$categorymodel->where("pid=$pid")->field('cat_id,cat_name')->select();
                $all_cat_id=$categorymodel->where("pid=$pid")->getField('cat_id',true);
                $tiaojian['cat_id']=array('eq',$cat_id);
                 //获取父类名字
                $p_cat_name=$categorymodel->where("cat_id=$pid")->getField('cat_name');
                $this->assign('p_cat_name',$p_cat_name);
            }
            
            $this->assign('cat_all',$cat_all);
            $this->assign('pid',$pid);
            
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
            //显示风格url
            $get_cs['fengge_0']=$get;
            unset($get_cs['fengge_0']['fengge']);
            $get_cs['fengge_1']=$get;
            $get_cs['fengge_1']['fengge']='1';
           
            
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
                $list=$goodsmodel->where($tiaojian)->where("is_delete=0")->field('price,tuan_number,goods_img_qita,goods_id,shop_name,goods_name,tuan_price,yuan_price,goods_img,comment_number,score,buy_number,daijinquan')->order('daijinquan desc,buy_number desc,score desc,last_update desc')->select();
            }elseif($order==='number_desc'){
                $list=$goodsmodel->where($tiaojian)->where("is_delete=0")->field('price,tuan_number,goods_img_qita,goods_id,shop_name,goods_name,tuan_price,yuan_price,goods_img,comment_number,score,buy_number,daijinquan')->order('buy_number desc,last_update desc')->select();
            }elseif($order==='price_desc'){
                $list=$goodsmodel->where($tiaojian)->where("is_delete=0")->field('price,tuan_number,goods_img_qita,goods_id,shop_name,goods_name,tuan_price,yuan_price,goods_img,comment_number,score,buy_number,daijinquan')->order('tuan_price desc,last_update desc')->select();
            }elseif($order==='pinglun_desc'){
                $list=$goodsmodel->where($tiaojian)->where("is_delete=0")->field('price,tuan_number,goods_img_qita,goods_id,shop_name,goods_name,tuan_price,yuan_price,goods_img,comment_number,score,buy_number,daijinquan')->order('score desc,last_update desc')->select();
            }elseif($order==='update_desc'){
                $list=$goodsmodel->where($tiaojian)->where("is_delete=0")->field('price,tuan_number,goods_img_qita,goods_id,shop_name,goods_name,tuan_price,yuan_price,goods_img,comment_number,score,buy_number,daijinquan')->order('last_update desc')->select();
            }elseif($order==='price_asc'){
                $list=$goodsmodel->where($tiaojian)->where("is_delete=0")->field('price,tuan_number,goods_img_qita,goods_id,shop_name,goods_name,tuan_price,yuan_price,goods_img,comment_number,score,buy_number,daijinquan')->order('tuan_price,last_update desc')->select();
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
        
        //各种分类的商品数量,不要cat_id参数
        $tiaojian_count=$tiaojian;
        $tiaojian_count_noshuxing=$tiaojian_count;
        unset($tiaojian_count_noshuxing['shuxing']);
        
        
        foreach ($all_cat_id as $value) {
            $cat_id_where['cat_id']=array('EQ',$value);
            if($cat_id==$value){
                $arr_count_cat[$value]=$goodsmodel->where($tiaojian_count)->where("is_delete=0")->where($cat_id_where)->count();
            }else{
                //统计其它分类，不能再要属性分类 因为属性不相同
                $arr_count_cat[$value]=$goodsmodel->where($tiaojian_count_noshuxing)->where("is_delete=0")->where($cat_id_where)->count();
            }
        }
        //一级分类的数量 同样不要属性参数
        $cat_id_where['cat_id']=array('in',$all_cat_id);
        $arr_count_cat[$pid]=$goodsmodel->where($tiaojian_count_noshuxing)->where("is_delete=0")->where( $cat_id_where)->count();
        
            $this->assign('arr_count',$arr_count);
            $this->assign('arr_count_cat',$arr_count_cat);
            $this->display(index);
        }else{
            $this->error('没有指定分类');
        }
    }
    
    
    public function one_buy() {
        $goodsmobile=D('Goods');
        $list=$goodsmobile->where("1yuangou=1 and is_delete=0")->field('price,tuan_number,goods_img_qita,goods_id,shop_name,goods_name,tuan_price,yuan_price,goods_img,comment_number,score,buy_number,daijinquan')->select();
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