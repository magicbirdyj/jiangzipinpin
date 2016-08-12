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
    

    public function search(){
        $url['full']=$_SERVER['REQUEST_URI'];
        $url['full_teshu']=substr($url['full'],0,strpos($url['full'],'?')===FALSE?strlen($url['full']):strpos($url['full'],'?'));
        $url['houmian']=strstr($url['full'],'?');
        $url['url']=str_replace('.html', '',$url['full']);
        $url['teshu']=str_replace('.html', '',$url['full_teshu']);
        $this->assign("url",$url);
        $this->assign('get',$_GET);     
      
        if($_GET['sex']!=null and $_GET['form']!=null){//因为性别和形式是一行，所以当两个都空的时候，必须不显示该div
                $sex_and_form=1;
            }
        $this->assign('sex_and_form',$sex_and_form);
        if($_GET['cid']!=null){
            $tiaojian['t1.cat_id']=$_GET['cid'];
            //把shuxing参数给分割成数组
            if($_GET['shuxing']!==null){
                $shuxing=explode('+',$_GET['shuxing']);
                $this->assign('shuxing',$shuxing);
                
                foreach ($shuxing as $key => $value) {
                    $shuxing_value=explode('-',$value);
                    $tiaojian['shuxing'][]=array('LIKE','%'.$shuxing_value[0].'\";s:'.strlen($shuxing_value[1]).':\"'.$shuxing_value[1].'%');
                }
            }
            $categorymodel=D('category');
            $cat_name=$_GET['cat_name'];
            $data_cat=$categorymodel->where("cat_name=$cat_name")->getField('shuxing');
            $arr_shuxing0=unserialize($data_cat);//得到反序列化属性数组
            $arr_shuxing=  array_chunk($arr_shuxing0, 2,true);
            $this->assign("arr_shuxing",$arr_shuxing);//给模板里面的$arr_shuxing赋值
            }
        
            
            
            if($_GET['price']!=null){
                switch ($_GET['price']){
                    case '400元以下':
                        $tiaojian['price']=array('ELT',400);
                        break;
                    case '400-600元':
                        $tiaojian['price']=array('BETWEEN','400,600');
                        break;
                    case '600-800元':
                        $tiaojian['price']=array('BETWEEN','600,800');
                        break;
                    case '800-1000元':
                        $tiaojian['price']=array('BETWEEN','800,1000');
                        break;
                    case '1000元以上':
                        $tiaojian['price']=array('EGT',1000);
                        break;
                }
            }
            if($_GET['price_s']!=null or $_GET['price_b']!=null){
                $tiaojian['price']=array(array('EGT',$_GET['price_s']),array('ELT',$_GET['price_b']));
            }
        
        $sp_1=  str_replace(' ', '%', $_GET['sp']);
        $goodsmodel=D('Goods');
        $search['goods_name']=array('LIKE','%'.$sp_1.'%');
        $count=$goodsmodel->where($tiaojian)->where("is_delete=0")->where($search)->count();
        
        $page_iphone=$this->get_page_iphone($count, 12);
        $page_foot_iphone=$page_iphone->show();//显示页脚信息
        
        $list_iphone=$goodsmodel->where($tiaojian)->where("is_delete=0")->where($search)->limit($page_iphone->firstRow.','.$page_iphone->listRows)->order('last_update desc')->select();
        //手机端
        $this->assign('list_iphone',$list_iphone);
        $this->assign('page_foot_iphone',$page_foot_iphone);
        //获取搜索到的商品里面，所包含的所有分类
        unset($tiaojian['cat_name']); 
        $arr_cat_name=$goodsmodel->where($tiaojian)->where("is_delete=0")->where($search)->getField('cat_name',true);
        $arr_cat_name=array_unique($arr_cat_name);
        
        $arr_count[0]=$goodsmodel->where($tiaojian)->where("is_delete=0")->where($search)->count();
        foreach ($arr_cat_name as $value) {
            $cat_name_where['cat_name']=array('EQ',$value);
            $arr_count[$value]=$goodsmodel->where($tiaojian)->where("is_delete=0")->where($search)->where($cat_name_where)->count();
        }
        $this->assign('arr_count',$arr_count);
        $this->assign('arr_cat_name',$arr_cat_name);
        
        $this->display(search);
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