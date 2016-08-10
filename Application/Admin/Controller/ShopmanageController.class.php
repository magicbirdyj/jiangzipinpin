<?php
namespace Admin\Controller;
use Admin\Controller;
class ShopmanageController extends FontEndController {
   
    public function fenleiyemian(){
        $categorymodel=D('Category');
        $data=$categorymodel->field('cat_name')->select();
        $this->assign('data',$data);
        //获取服务类型表单提交值
        if(!empty($_POST['server_content'])){
            $server_content=$_POST['server_content'];
        }else{
            $server_content=$data[0]['cat_name'];
        }
        $this->assign($server_content,'selected="selected"');
        $this->assign('server_content',$server_content);
        
        $cat_id=$categorymodel->where("cat_name='$server_content'")->getField('cat_id');
        $goodsmodel=D('Goods');
        $serch_name=$_POST['serch'];
        $this->assign('serch_name',$serch_name);
        if(!empty($serch_name)){
            $where['goods_name']=array('like',"%$serch_name%");
            $count=$goodsmodel->where($where)->where("cat_id={$cat_id} and is_delete=0")->count();
        }else{
            $count=$goodsmodel->where("cat_id={$cat_id} and is_delete=0")->count();
        }
        $page=$this->get_page($count, 10);
        $page_foot=$page->show();//显示页脚信息
        if(!empty($serch_name)){
            $where['goods_name']=array('like',"%$serch_name%");
            $list=$goodsmodel->where($where)->where("cat_id={$cat_id} and is_delete=0")->limit($page->firstRow.','.$page->listRows)->order('goods_id desc')->select();
        }else{
            $list=$goodsmodel->where("cat_id={$cat_id} and is_delete=0")->limit($page->firstRow.','.$page->listRows)->order('goods_id desc')->select();
        }
        $this->assign('list',$list);
        $this->assign('page_foot',$page_foot);
        $this->display();
    }
    public function shangpinyemian(){
        $categorymodel=D('Category');
        $data=$categorymodel->field('cat_name')->select();
        $this->assign('data',$data);
        //获取服务类型表单提交值
        if(!empty($_GET['server_content'])){
            $server_content=$_GET['server_content'];
        }else{
            $server_content=$data[0]['cat_name'];
        }
        $this->assign($server_content,'selected="selected"');
        $this->assign('server_content',$server_content);
        
        $cat_id=$categorymodel->where("cat_name='$server_content'")->getField('cat_id');
        $goodsmodel=D('Goods');
        $serch_name=$_GET['serch'];
        $this->assign('serch_name',$serch_name);
        if(!empty($serch_name)){
            $where['goods_name']=array('like',"%$serch_name%");
            $count=$goodsmodel->where($where)->where("cat_id={$cat_id} and is_delete=0")->count();
        }else{
            $count=$goodsmodel->where("cat_id={$cat_id} and is_delete=0")->count();
        }
        $page=$this->get_page($count, 10);
        $page_foot=$page->show();//显示页脚信息
        if(!empty($serch_name)){
            $where['goods_name']=array('like',"%$serch_name%");
            $list=$goodsmodel->where($where)->where("cat_id={$cat_id} and is_delete=0")->limit($page->firstRow.','.$page->listRows)->order('goods_id desc')->select();
        }else{
            $list=$goodsmodel->where("cat_id={$cat_id} and is_delete=0")->limit($page->firstRow.','.$page->listRows)->order('goods_id desc')->select();
        }
        $this->assign('list',$list);
        $this->assign('page_foot',$page_foot);
        $this->display();
    }

    public function chuchuan(){
        $leixin=$_GET['leixin'];
        $goods_id=$_GET['goods_id'];
        $index=$_GET['index'];
        $server=$_GET['server'];
        $categorymodel=D('Category');
        $cat_id=$categorymodel->where("cat_name='$server'")->getField('cat_id');
        $goodsmodel=D('Goods');
        //取消原来橱窗位置的商品
        if($leixin==='cat'){
            $data1['advert_cat_order']='100';
            $data['advert_cat_order']=(string)$index;
        }elseif($leixin==='shop'){
            $data1['advert_shop_order']='100';
            $data['advert_shop_order']=(string)$index;
        }
        $goodsmodel->where("advert_cat_order=$index and cat_id=$cat_id")->save($data1); 
        $goodsmodel->where("goods_id=$goods_id")->save($data);
    }

    
    
    


}