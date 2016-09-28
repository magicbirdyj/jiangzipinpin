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
    
    
    
    public function release_goods() {
        $open_id=$_SESSION['huiyuan']['open_id'];
        $shopsmodel=D('Shops');
        $shop=$shopsmodel->where("open_id='$open_id'")->find();
        if($shop['head_url']==''){
            $this->redirect('Zhuceshop/zhuce4');
        }
        $categorymodel=D('Category');
        $cate_0=$categorymodel->where("pid=0 and deleted=0")->field('cat_id,cat_name')->select();
        $this->assign('cate_0',$cate_0);
        foreach ($cate_0 as $key => $value) {
            $pid=$value['cat_id'];
            $cate_1[]=$categorymodel->where("pid=$pid and deleted=0")->field('cat_id,cat_name')->select();
        }
        $this->assign('cate_1',$cate_1);
        // 默认category的大类
        $default_cat_id=$shop['default_cat_id'];
        $default_cat_0=$categorymodel->where("cat_id='$default_cat_id'")->getField('pid');
        $this->assign('default_cat_0',$default_cat_0);
        $this->assign('shop',$shop);
        $this->display();
    }
    public function release_check(){
        $content=$_POST;//获取提交的内容
        $open_id=$_SESSION['huiyuan']['open_id'];
        $shopmodel=D('Shops');
        $shop=$shopmodel->where("open_id='$open_id'")->field('shop_name,shop_id')->find();
        if(empty($content['goods_img'])||empty($content['goods_zhanshitu'])){
            $this->error('未选择展示图片或者商品图片');
            exit();
        }
        if(strstr($content['goods_img'], "undefined")!==false||strstr($content['goods_zhanshitu'], "undefined")!==false){
            $this->error('有未上传成功的展示图片或商品图片');
            exit();
        }
        // 获取展示图片并thumb(250, 250)再移动
        $goods_zhanshitu=$content['goods_zhanshitu'];//获取
        $goods_zhanshitu_thumb=$this->thumb($goods_zhanshitu, 250, 250);//thumb
        //移动到正式文件夹
        $today=substr($goods_zhanshitu,26,8);//获取到文件夹名  如20150101
        creat_file(UPLOAD.'image/goods/'.$today);//创建文件夹（如果存在不会创建
        rename($goods_zhanshitu_thumb, str_replace('Public/Uploads/image/temp', UPLOAD.'image/goods',$goods_zhanshitu));//移动文件
        $goods_zhanshitu='/'.str_replace('Public/Uploads/image/temp', UPLOAD.'image/goods',$goods_zhanshitu);
        
        //获取商品图片URL,分割成数组
        $arr_goods_img=explode('+img+',$content['goods_img']);
        //获取第一张图片并thumb(435, 232)再移动
            $today=substr($arr_goods_img[0],26,8);//获取到文件夹名  如20150101
            creat_file(UPLOAD.'image/goods/'.$today);//创建文件夹（如果存在不会创建
            creat_file(UPLOAD.'image/goods/'.$today.'/thumb');//创建文件夹（如果存在不会创建
            $value=$this->thumb($arr_goods_img[0], 435, 232);//thumb
            rename($value, str_replace('Public/Uploads/image/temp', UPLOAD.'image/goods',$value));//移动文件
        //获取每张图片并thumb(750, 400)再移动,直接改变数组的值
        foreach ($arr_goods_img as &$value) {
            $today=substr($value,26,8);//获取到文件夹名  如20150101
            creat_file(UPLOAD.'image/goods/'.$today);//创建文件夹（如果存在不会创建
            creat_file(UPLOAD.'image/goods/'.$today.'/thumb');//创建文件夹（如果存在不会创建
            $img_url_thumb=$this->thumb($value, 750, 400);//thumb
            rename($img_url_thumb, str_replace('Public/Uploads/image/temp', UPLOAD.'image/goods',$value));//移动文件
            $value=str_replace('Public/Uploads/image/temp','Public/Uploads/image/goods',$value);  
            $value='/'.$value;
        }

        
        
       //商品图片数组序列化
       $str_goods_img=serialize($arr_goods_img);

        if($content['title']==''||is_feifa($content['title'])){
            $this->error('商品标题为空或者含有非法字符');
            exit();
        }
        if($content['goods_jianjie']==''||is_feifa($content['title'])){
            $this->error('商品简介为空或者含有非法字符');
            exit();
        }
        if($content['units']==''||is_feifa($content['units'])){
            $this->error('商品单位重量为空或者含有非法字符');
            exit();
        }
        if(!is_price($content['price'])){
            $this->error('价格为空或者不合规范');
            exit();
        }
        if(!is_price($content['yuan_price'])){
            $this->error('原价为空或者不合规范0');
            exit();
        }
       
        
        
        $result=get_file($content['content']);//得到编辑框里面的图片文件
        //遍历图片文件，并把图片文件从临时文件夹保存进正式文件夹,并把文件名存储到$file_name数组中
        foreach ($result[1] as $value){
            $today=substr($value,26,8);//获取到文件夹名  如20150101
            creat_file(UPLOAD.'image/goods/'.$today);//创建文件夹（如果存在不会创建）
            rename($value, str_replace('Public/Uploads/image/temp', UPLOAD.'image/goods', $value));//移动文件
        }
        $goods_desc=str_replace('Public/Uploads/image/temp', UPLOAD.'image/goods', $content['content']);
        $goods_desc=  replace_a($goods_desc);//取消其它网站的超级链接
        $goods_desc=str_replace('<embed','<iframe',$goods_desc);//把flash 的embed标签改成 iframe标签 
        $goods_desc=str_replace('/>','></iframe>',$goods_desc);//把flash 的embed标签改成 iframe标签 
        //得到商品分类id
        
        $cat_id=$content['cate_1'];
        $categorymodel=D('Category');
        $data_category=$categorymodel->where("cat_id='{$cat_id}'")->find();
        $data_cat=unserialize($data_category['shuxing']);//得到分类的属性,并反序列化成数组
         $data_cat_keys=array_keys($data_cat);//获取属性键名,保存到数组
         //拼凑出属性数组 并序列化
        foreach ($data_cat_keys as $key=>$value){
             $arr_shuxing["$value"]=$content['shuxing'][$key];
         }
        $str_shuxing=serialize($arr_shuxing);
        
        //获取商品可选属性（如果有）
        $zx_shuxing=$content['zx_shuxing'];
        if($zx_shuxing){
           $zx_shuxingzhi=$content['zx_shuxingzhi'];
            $i=0;
            $new_arr=array();
            foreach ($zx_shuxingzhi as  $value) {
            $key=$zx_shuxing[$i];
            $new_arr[$key]=$value;
            $i++;
            }
            $str_zx_shuxing=serialize($new_arr);
            
        }else{
            $str_zx_shuxing='';
        }
        
        
        
        //保存商品信息，把商品信息写入数据库
        $goodsmodel=D('Goods');
        $row=array(
            'cat_id'=>$cat_id,
            'cat_name'=>$data_category['cat_name'],//分类名
            'shop_id'=>$shop['shop_id'],
            'shop_name'=>$shop['shop_name'],//所属店铺
            'goods_name'=>$content['title'],//商品名称
            'goods_jianjie'=>$content['goods_jianjie'],//商品简介
            'units'=>$content['units'],//商品单位重量
            'yuan_price'=>$content['yuan_price'],//原价
            'price'=>$content['price'],//单购价
            'shuxing'=>$str_shuxing,//属性
            'goods_img'=>$goods_zhanshitu,//商品图片
            'goods_img_qita'=>$str_goods_img,//被序列化的其它图片
            'goods_desc'=>$goods_desc,//商品描述
            'goods_shuxing'=>$str_zx_shuxing,//商品可选属性
            'add_time'=>time(),             //添加时间
            'last_update'=>time()            //更新时间初始等于添加时间
        );
        $result_add=$goodsmodel->add($row);
        if($result_add){
            $this->success('恭喜您，商品发布成功了',U('Member/index'),3);
        }
    }
    
    
     public function file_jia(){
        $name=$_GET['name'];
        $width=$_GET['width'];
        $height=$_GET['height'];
        $file_info=$this->upload('image/temp/');//获取上传文件信息
        if($file_info[0]==='error'){
            $data=array(
                'result'=>'error',
                'error'=>$file_info[1]
            );
            $this->ajaxReturn($data,'JSON');
            exit();

        }
        //获取图片URL
        $data=array();
        
        $data['src']=UPLOAD.$file_info[1][$name]['savepath'].$file_info[1][$name]['savename'];
        $data['src_thumb']=$this->thumb($data['src'],$width,$height);//创建图片的缩略图
        $this->ajaxReturn($data,'JSON');
    }
        
    private function thumb($url,$a,$b){
        $image = new \Think\Image(); 
        $index=strripos($url,"/");
        $img_url=substr($url,0,$index+1);
        $img_name=substr($url,$index+1); 
        $image->open($url);
        creat_file($img_url.'thumb');//创建文件夹（如果存在不会创建）
        $image->thumb($a, $b,\Think\Image::IMAGE_THUMB_CENTER)->save($img_url.'thumb/'.$img_name);
        return $img_url.'thumb/'.$img_name;
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