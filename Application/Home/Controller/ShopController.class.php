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
    
    public function editor() {
        //先判断是否注册了商家
        $shopsmodel=D('Shops');
        $open_id=$_SESSION['huiyuan']['open_id'];
        $count=$shopsmodel->where("open_id='$open_id'")->count();
        if($count=='0'){
            header("location:". U("Zhuceshop/index"));
                exit();
        }else{
            $shop=$shopsmodel->where("open_id='$open_id'")->find();
            if($shop['head_url']==''){
                header("location:". U("Zhuceshop/zhuce4"));
                exit();
            }
        }

        $categorymodel=D('Category');
        $cate_0=$categorymodel->where("pid=0 and deleted=0")->field('cat_id,cat_name')->select();
        $this->assign('cate_0',$cate_0);
        foreach ($cate_0 as $key => $value) {
            $pid=$value['cat_id'];
            $cate_1[]=$categorymodel->where("pid=$pid and deleted=0")->field('cat_id,cat_name')->select();
        }
        $this->assign('cate_1',$cate_1);
        
        $shop['address']=  unserialize($shop['address']);
        $this->assign('shop',$shop);
        
        // 默认category的大类
        $default_cat_id=$shop['default_cat_id'];
        $default_cat_0=$categorymodel->where("cat_id='$default_cat_id'")->getField('pid');
        $default_cat_0=$categorymodel->where("cat_id='$default_cat_0'")->getField('cat_name');
        $this->assign('default_cat_0',$default_cat_0);
        $this->display();
       
        
    }
    
    public function editor_check(){
        //先判断是否注册了商家
        $shopsmodel=D('Shops');
        $open_id=$_SESSION['huiyuan']['open_id'];
        $count=$shopsmodel->where("open_id='$open_id'")->count();
        if($count=='0'){
            header("location:". U("Zhuceshop/index"));
                exit();
        }else{
            $shop=$shopsmodel->where("open_id='$open_id'")->find();
            if($shop['head_url']==''){
                header("location:". U("Zhuceshop/zhuce4"));
                exit();
            }
        }
        
        
        $content=$_POST;//获取提交的内容
        
        if($content['member_file_touxiang']===''){
            $this->error('未上传店铺logo');
            exit();
        }
        if(strstr($content['member_file_touxiang'], "undefined")!==false){
            $this->error('店铺logo未上传成功');
            exit();
        }
        
        
        $head_url=$content['member_file_touxiang'];//获取
        if(strchr($head_url,'temp')){
            //移动文件 并且改变url
            $today=substr($_POST['member_file_touxiang'],26,8);//获取到文件夹名  如20150101
            creat_file(UPLOAD.'image/member/'.$today);//创建文件夹（如果存在不会创建）
            rename($_POST['member_file_touxiang'], str_replace('Public/Uploads/image/temp', UPLOAD.'image/member',str_replace('thumb/','',$_POST['member_file_touxiang'])));//移动文件
            $head_url='/'.str_replace('Public/Uploads/image/temp', UPLOAD.'image/member',str_replace('thumb/','',$_POST['member_file_touxiang']));
        }
       
 
        $shop_form=intval($_POST['radio_fuwuxingshi']);//获取服务形式
        //当服务形式为公司，至少必须上传3个图片文件，否则提示并且返回
       //if($serverform===2){
            //if(count($file_info)<3){
                //$this->error('有选现未选择文件');
                //exit();
            //}
        //}
        
        $province=$_POST['address_province'];//获取省份
        //如果没选择省份，提示并退出
        if($province==='请选择省市'||empty($province)){
            $this->error('未选择所在省市');
            exit();
        }else{//获取城市和县城
            $city=$_POST['address_city'];
            $county=$_POST['address_county'];
        }
        $address=$_POST['address_juti'];//获取详细地址

        $qq=$_POST['contact_qq'];//获取QQ号码
       
        $shop_introduce=$_POST['shop_introduce'];//获取店铺介绍
       $default_cat_id=$_POST['cate_1'];//获取分类cat_id
        //如果没选择分类，提示并退出
        if($default_cat_id==='请选择分类'||empty($default_cat_id)){
            $this->error('未选择分类');
            exit();
        }
        
        
        
        //服务内容未选择时，提示并退出
        if(empty($qq)||empty($address)||empty($shop_introduce)){
            $this->error('有内容未填写');
            exit();
        }
       
        //任何文本框如果含有非法字符，提示并退出
        if(is_feifa($weixin)||is_feifa($address)||is_feifa($shop_introduce)){
            $this->error('有内容含有非法字符');
            exit();
        }

        $arr_address=array();
        $arr_address['province']=$province;
        $arr_address['city']=$city;
        $arr_address['county']=$county;
        $arr_address['address']=$address;
        //准备需要写进数据库的数组
        $row=array(
            'head_url'=>$head_url,
            'shop_form'=>$shop_form,
            'address'=>  serialize($arr_address),
            'qq'=>$qq,
            'default_cat_id'=>$default_cat_id,
            'shop_introduce'=>$shop_introduce,
            'last_login'=>  mktime()
        );
       
        //写入数据库
      
        $result=$shopsmodel->where("open_id='{$open_id}'")->save($row);
        if($result!==false){
            header("location:". U("Member/index"));
            exit();
        }else{
            $this->error('更新数据库失败');
            exit();
        }
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
    
    
    
    
    public function bianji_goods() {
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
        
        $this->assign('shop',$shop);
        
        //获取商品信息
        $goods_id=$_GET['goods_id'];
        if(!$goods_id){$this->error('没有商品id');}
        $goodsmodel=D('Goods');
        $goods=$goodsmodel->where("goods_id=$goods_id")->find();
        if($goods['shop_id']!=$shop['shop_id']){$this->error('您没有该商品');}
        $goods['goods_img_qita']=  unserialize($goods['goods_img_qita']);
        $goods['shuxing']=unserialize($goods['shuxing']);
        $this->assign('goods',$goods);
        $default_cat_id=$goods['cat_id'];
        $default_cat_0=$categorymodel->where("cat_id='$default_cat_id'")->getField('pid');
        $this->assign('default_cat_0',$default_cat_0);
        $this->display();
    }
    
    public function bianji_check(){
        $goods_id=$_GET['goods_id'];
        $goodsmodel=D('Goods');
        $goods=$goodsmodel->where("goods_id=$goods_id")->find();//商品信息列表
        $arr_goods_img_qita_yuan=  unserialize($goods['goods_img_qita']);
        
        
        $content=$_POST;//获取提交的内容
        $open_id=$_SESSION['huiyuan']['open_id'];
        $shopmodel=D('Shops');
        $shop=$shopmodel->where("open_id='$open_id'")->field('shop_name,shop_id')->find();
        if($content['goods_img']===''){
            $this->error('未选择商品图片');
            exit();
        }
        if(strstr($content['goods_img'], "undefined")!==false){
            $this->error('有未上传成功的商品图片');
            exit();
        }
        // 获取展示图片并thumb(250, 250)再移动
        $goods_zhanshitu=$content['goods_zhanshitu'];//获取
        if(strchr($goods_zhanshitu,'temp')){
            $goods_zhanshitu_thumb=$this->thumb($goods_zhanshitu, 250, 250);//thumb
            //移动到正式文件夹
            $today=substr($goods_zhanshitu,26,8);//获取到文件夹名  如20150101
            creat_file(UPLOAD.'image/goods/'.$today);//创建文件夹（如果存在不会创建
            rename($goods_zhanshitu_thumb, str_replace('Public/Uploads/image/temp', UPLOAD.'image/goods',$goods_zhanshitu));//移动文件
            $goods_zhanshitu='/'.str_replace('Public/Uploads/image/temp', UPLOAD.'image/goods',$goods_zhanshitu);
        }
        //获取商品图片URL,分割成数组
        $arr_goods_img=explode('+img+',$content['goods_img']);
         if(strchr($arr_goods_img[0],'temp')){
            //获取第一张图片并thumb(435, 232)再移动
            $today=substr($arr_goods_img[0],26,8);//获取到文件夹名  如20150101
            creat_file(UPLOAD.'image/goods/'.$today);//创建文件夹（如果存在不会创建
            creat_file(UPLOAD.'image/goods/'.$today.'/thumb');//创建文件夹（如果存在不会创建
            $value=$this->thumb($arr_goods_img[0], 435, 232);//thumb
            rename($value, str_replace('Public/Uploads/image/temp', UPLOAD.'image/goods',$value));//移动文件
        }else{
            if($arr_goods_img_qita_yuan[0]!=$arr_goods_img[0]){
                $today=substr($arr_goods_img[0],26,8);//获取到文件夹名  如20150101
                creat_file(UPLOAD.'image/goods/'.$today);//创建文件夹（如果存在不会创建
                creat_file(UPLOAD.'image/goods/'.$today.'/thumb');//创建文件夹（如果存在不会创建
                $value=$this->thumb($arr_goods_img[0], 435, 232);//thumb
            }
        }
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
        $result_add=$goodsmodel->where("goods_id=$goods_id")->save($row);;
        if($result_add){
            $this->success('商品编辑成功',U('Shop/goods'),3);
        }
    }
    
    
    
    
    
    
    
    
    public function order(){
        $open_id=$_SESSION['huiyuan']['open_id'];
        $shopsmodel=D('Shops');
        $is_shop=$shopsmodel->where("open_id='$open_id'")->count();
        if(!$is_shop){
            $this->error('您没有注册店铺！');
        }
        $shop_id=$shopsmodel->where("open_id='$open_id'")->getField('shop_id');
        
        $status=$_GET['status'];
        $this->assign('canshu',$_GET['status']);
        $ordermodel=D('Order');
        $status_count['all']=$ordermodel->where("shop_id={$shop_id} and deleted=0")->count();//获取全部订单条数
        $status_count['no_pay']=$ordermodel->where("shop_id={$shop_id} and pay_status=0 and deleted=0  and status<6")->count();//获取未付款条数
        $status_count['daifahuo']=$ordermodel->where("shop_id={$shop_id} and pay_status=1 and status=1 and deleted=0")->count();//获取待发货条数
        $status_count['daishouhuo']=$ordermodel->where("shop_id={$shop_id} and pay_status=1 and status=3 and deleted=0")->count();//获取待收货条数
        $status_count['daipingjia']=$ordermodel->where("shop_id={$shop_id} and pay_status=1 and status=4 and deleted=0")->count();//获取待评价条数
        $status_count['shouhou']=$ordermodel->where("shop_id={$shop_id} and pay_status>1 and pay_status<4 and deleted=0")->count();//获取售后申请条数
         $this->assign(status_count,$status_count);
         $time=  time();
         $this->assign('time',$time);
         if(empty($status)){
            
             $count=$ordermodel->where("shop_id={$shop_id} and deleted=0")->count();
             $this->assign(count,$count);
             $page=$this->get_page($count, 10);
             $page_foot=$page->show();//显示页脚信息
             $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.deleted=0 and t1.shop_id={$shop_id} and t1.goods_id=t2.goods_id")->order('t1.created desc')->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t1.price,t1.dues,t1.tuan_no,t1.tuan_number,t1.fenxiang')->limit($page->firstRow.','.$page->listRows)->select();
             
             $this->assign('list',$list);
             $this->assign('page_foot',$page_foot);
         }else if($status==='no_pay'){
            
             $count=$ordermodel->where("shop_id={$shop_id} and pay_status=0 and deleted=0  and status<6")->count();
             $page=$this->get_page($count, 10);
             $page_foot=$page->show();//显示页脚信息
             $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.deleted=0 and t1.shop_id={$shop_id} and t1.pay_status=0  and t1.status<6 and t1.goods_id=t2.goods_id")->order('t1.created desc')->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t1.price,t1.dues,t1.tuan_no,t1.tuan_number,t1.fenxiang')->limit($page->firstRow.','.$page->listRows)->select();
             
             $this->assign('list',$list);
             $this->assign('page_foot',$page_foot);
         }else if($status==='daifahuo'){
           
             $count=$ordermodel->where("shop_id={$shop_id} and pay_status=1 and (status=2 or (tuan_no=0 and status=1)) and deleted=0")->count();
             $page=$this->get_page($count, 10);
             $page_foot=$page->show();//显示页脚信息
             $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.deleted=0 and t1.shop_id={$shop_id} and t1.pay_status=1 and (t1.status=2 or (t1.tuan_no=0 and t1.status=1)) and t1.goods_id=t2.goods_id")->order('t1.created desc')->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t1.price,t1.dues,t1.tuan_no,t1.tuan_number,t1.fenxiang')->limit($page->firstRow.','.$page->listRows)->select();
             $this->assign('list',$list);
             $this->assign('page_foot',$page_foot);
         }else if($status==='daishouhuo'){
           
             $count=$ordermodel->where("shop_id={$shop_id} and pay_status=1 and status=3 and deleted=0")->count();
             $page=$this->get_page($count, 10);
             $page_foot=$page->show();//显示页脚信息
             $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.deleted=0 and t1.shop_id={$shop_id} and t1.pay_status=1 and t1.status=3 and t1.goods_id=t2.goods_id")->order('t1.created desc')->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t1.price,t1.dues,t1.tuan_no,t1.tuan_number,t1.fenxiang')->limit($page->firstRow.','.$page->listRows)->select();
             $this->assign('list',$list);
             $this->assign('page_foot',$page_foot);
         }else if($status==='daipingjia'){
            
             $count=$ordermodel->where("shop_id={$shop_id} and pay_status=1 and status=4 and deleted=0")->count();
             $page=$this->get_page($count, 10);
             $page_foot=$page->show();//显示页脚信息
             $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.deleted=0 and t1.shop_id={$shop_id} and t1.pay_status=1 and t1.status=4 and t1.goods_id=t2.goods_id")->order('t1.created desc')->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t1.price,t1.dues,t1.tuan_no,t1.tuan_number,t1.fenxiang')->limit($page->firstRow.','.$page->listRows)->select();
             $this->assign('list',$list);
             $this->assign('page_foot',$page_foot);
         }else if($status==='shouhou'){
             
             $count=$ordermodel->where("shop_id={$shop_id} and pay_status>1 and deleted=0")->count();
             $page=$this->get_page($count, 10);
             $page_foot=$page->show();//显示页脚信息
             $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.deleted=0 and t1.shop_id={$shop_id} and t1.pay_status>1 and t1.goods_id=t2.goods_id")->order('t1.created desc')->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t1.price,t1.dues,t1.tuan_no,t1.tuan_number,t1.fenxiang')->limit($page->firstRow.','.$page->listRows)->select();
             $this->assign('list',$list);
             $this->assign('page_foot',$page_foot);
         }
         
         
         session('guanzhu',null); 
         $this->display();
    }
    
    public function goods(){
        $open_id=$_SESSION['huiyuan']['open_id'];
        $shopsmodel=D('Shops');
        $is_shop=$shopsmodel->where("open_id='$open_id'")->count();
        if(!$is_shop){
            $this->error('您没有注册店铺！');
        }
        $shop_id=$shopsmodel->where("open_id='$open_id'")->getField('shop_id');
        $goodsmodel=D('Goods');
        $status=$_GET['status'];
        $this->assign('canshu',$status);
        $status_count['0']=$goodsmodel->where("shop_id={$shop_id} and is_delete=0")->count();//获取上架商品条数
        $status_count['1']=$goodsmodel->where("shop_id={$shop_id} and is_delete=1")->count();//获取下架商品条数
        $this->assign('status_count',$status_count);
        if($status==='1'){
             //$count=$goodsmodel->where("shop_id={$shop_id} and is_delete=1")->count();//获取下架商品条数
             //$this->assign(count,$count);
             $list=$goodsmodel->where("shop_id='{$shop_id}' and is_delete=1")->order('last_update desc')->select();
             $this->assign('list',$list);
         }else{
             //$count=$goodsmodel->where("shop_id={$shop_id} and is_delete=0")->count();//获取上架商品条数
             //$this->assign(count,$count);
             $list=$goodsmodel->where("shop_id={$shop_id} and is_delete=0")->select();
             $this->assign('list',$list);
             
         }
        $this->display();
    }
    
    public function view_order(){
        $open_id=$_SESSION['huiyuan']['open_id'];
        $shopsmodel=D('Shops');
        $shop_id=$shopsmodel->where("open_id='$open_id'")->getField('shop_id');
        $order_id=$_GET['order_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->table('m_order t1,m_goods t2')->where("t1.order_id='{$order_id}' and  t1.goods_id=t2.goods_id and t1.deleted=0")->field('t1.user_id,t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.shop_name,t1.status,t1.pay_status,t1.created,t1.updated,t2.goods_img,t1.price,t1.dues,t1.order_address,t1.buy_number,t1.tuan_no,t1.tuan_number,t1.shop_id')->find();
        if(!$order){
            $this->error('该订单号不存在或已经删除 ');
        }
        
        if($order['shop_id']===$shop_id){
            $this->assign('order',$order);
            $this->display();
        }else{
            $this->error('您不存在该订单 ','/Home/Shop/order');
        }
    }
     public function view_wuliu() {
        $open_id=$_SESSION['huiyuan']['open_id'];
        $Shopsmodel=D('Shops');
        $shop_id=$Shopsmodel->where("open_id='$open_id'")->getField('shop_id');
        $order_id=$_GET['order_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->table('m_order t1,m_goods t2')->where("t1.order_id='{$order_id}' and  t1.goods_id=t2.goods_id")->field('t1.order_no,t1.user_id,t1.goods_name,t1.shop_name,t2.goods_img,t1.price,t1.buy_number,t1.dues,t1.kuaidi,t1.shop_id')->find();
        if($order['shop_id']===$shop_id){
            $this->assign('order',$order);
            $wuliu=  unserialize($order['kuaidi']);
            $this->assign('wuliu',$wuliu);
            if($wuliu['fangshi']=='2'){
                $wuliu_info=$this->getOrderTracesByJson($order['order_no'],$wuliu['company_bianma'],$wuliu['no']);
                $arr_wuliu=json_decode($wuliu_info,true);
                $wuliu_guiji=$arr_wuliu['Traces'];
                krsort($wuliu_guiji);
                $this->assign('wuliu_guiji',$wuliu_guiji);
            }elseif($wuliu['fangshi']=='1'){
                
            }
            $this->display();
        }else{
            $this->error('该订单不存在','/Home/Shop/order');
        }
    }
    
    public function fahuo(){
        if(!$_GET['order_id']){
            $this->error('订单号获取失败！');
        }
        $order_id=$_GET['order_id'];
        $this->assign('order_id',$order_id);
        $this->display();
    }
    public function fahuo_check(){
        $post=$_POST;
        if(!$post['order_id']){
            $this->error('订单号获取失败！');
        }
        $order_id=$post['order_id'];
        $ordermodel=D('Order');
        if($post['fangshi']=='1'){
            $data=array(
                'fangshi'=>'1',
                'qishou_name'=>$post['qishou_name'],
                'qishou_mobile'=>$post['qishou_mobile']
            );
        }elseif($post['fangshi']=='2'){
            $data=array(
                'fangshi'=>'2',
                'company'=>$post['kuaidi_company'],
                'company_bianma'=>$post['kuaidi_bianma'],
                'no'=>$post['kuaidi_no']
            );
        }
        
        $row=  array(
            'kuaidi'=>  serialize($data),
            'status'=>'3',
            'updated'=>  time()
        );
        $result_add=$ordermodel->where("order_id=$order_id")->save($row);
        if($result_add){
            $this-> fahuo_tep_success($order_id);//  发送消息给团员
            $this->redirect('Shop/view_order',array('order_id'=>$order_id));
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
    
    
    
    private function fahuo_tep_success($order_id){
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id=$order_id")->find();
        $kuaidi=  unserialize($order['kuaidi']);
        if($kuaidi['fangshi']=='1'){
            $keyword1='（同城）骑手：'.$kuaidi['qishou_name'];
            $keyword2='（同城）骑手电话：'.$kuaidi['qishou_mobile'];
        }else{
             $keyword1=$kuaidi['company'];
              $keyword2=$kuaidi['no'];
        }
        $user_id=$order['user_id'];
        $usersmodel=D('Users');
        $open_id=$usersmodel->where("user_id=$user_id")->getField('open_id');
        $template_id="RDphvvFI8o8yTMi5ItXCCMl-JFZvLXTfvNErqjVBcRM";
        $goods_id=$order['goods_id'];
        $url=U('Home/Order/view_wuliu',array('order_id'=>$order_id));
        $arr_data=array(
            'first'=>array('value'=>"您好，您购买的商品：".$order["goods_name"]." 已经启程，讲马上到达您的身边！","color"=>"#666"),
            'keyword1'=>array('value'=>$keyword1,"color"=>"#666"),
            'keyword2'=>array('value'=>$keyword2,"color"=>"#666"),
            'keyword3'=>array('value'=>$order["goods_name"],"color"=>"#666"),
            'keyword4'=>array('value'=>$order['buy_number'],"color"=>"#666"),
            'remark'=>array('value'=>"点我，查看物流详细信息","color"=>"#F90505")
        );
        $this->response_template($open_id, $template_id, $url, $arr_data);
    }
    
    
     /**
    * Json方式 查询订单物流轨迹
    */
    private function getOrderTracesByJson($OrderCode,$ShipperCode,$LogisticCode){
	$requestData= "{'OrderCode':'$OrderCode','ShipperCode':'$ShipperCode','LogisticCode':'$LogisticCode'}";
	$datas = array(
            'EBusinessID' => EB_ID,
            'RequestType' => '1002',
            'RequestData' => urlencode($requestData) ,
            'DataType' => '2',
        );
        $datas['DataSign'] = $this->encrypt($requestData, EB_AppKey);
	$result=$this->sendPost(EB_ReqURL, $datas);	
	
	//根据公司业务处理返回的信息......
	
	return $result;
    }
     /**
    *  post提交数据 
    * @param  string $url 请求Url
    * @param  array $datas 提交的数据 
    * @return url响应返回的html
    */
    private function sendPost($url, $datas) {
        $postdata = http_build_query($datas);    
        $options = array(    
            'http' => array(    
                'method' => 'POST',    
                'header' => 'Content-type:application/x-www-form-urlencoded',    
                'content' => $postdata,    
                'timeout' => 15 * 60 // 超时时间（单位:s）    
            )    
        );    
        $context = stream_context_create($options);    
        $result = file_get_contents($url, false, $context);             
        return $result;    
    }
     /**
     * 电商Sign签名生成
    * @param data 内容   
    * @param appkey Appkey
    * @return DataSign签名
    */
    private function encrypt($data, $appkey) {
        return urlencode(base64_encode(md5($data.$appkey)));
    }
}