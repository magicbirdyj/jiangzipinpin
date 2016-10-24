<?php
namespace Admin\Controller;
use Admin\Controller;
class GoodsmanageController extends FontEndController {
   
    public function index(){
        $categorymodel=D('Category');
        $data=$categorymodel->where("pid<>0 and deleted=0")->field('cat_name,cat_id')->select();
        $this->assign('data',$data);
        //获取服务类型表单提交值
        if(!empty($_GET['server_content'])){
            $server_content=$_GET['server_content'];
        }else{
            $server_content=$data[0]['cat_id'];
        }
        $this->assign('server_content',$server_content);
        //$cat_id=$categorymodel->where("cat_name='$server_content'")->getField('cat_id');
        $goodsmodel=D('Goods');
        $serch_name=$_GET['serch'];
        $this->assign('serch_name',$serch_name);
        if(!empty($serch_name)){
            $where['goods_name']=array('like',"%$serch_name%");
            $count=$goodsmodel->where($where)->where("cat_id='{$server_content}' and is_delete=0")->count();
        }else{         
            $count=$goodsmodel->where("cat_id='{$server_content}' and is_delete=0")->count();
        }
        
        $page=$this->get_page($count, 10);
        $page_foot=$page->show();//显示页脚信息
        if(!empty($serch_name)){
            $where['goods_name']=array('like',"%$serch_name%");
            $list=$goodsmodel->where($where)->where("cat_id='{$server_content}'  and is_delete=0")->limit($page->firstRow.','.$page->listRows)->order('goods_id desc')->select();
        }else{
            $list=$goodsmodel->where("cat_id='{$server_content}' and is_delete=0")->limit($page->firstRow.','.$page->listRows)->order('goods_id desc')->select();
        }
        $this->assign('list',$list);
        $this->assign('page_foot',$page_foot);
        $this->display();
    }
    
    
    //编辑商品
    public function goods_editor(){
        //获取店铺列表
         $shopsmodel=D('Shops');
         $arr_shop=$shopsmodel->getField('shop_name',true);
         $this->assign('arr_shop',$arr_shop);
         //获取商品信息
        $goods_id=$_GET['goods_id'];
        $this->assign('goods_id',$goods_id);
        //获取商品服务类型
        $goodsmodel=D('Goods');
        $goods=$goodsmodel->where("goods_id=$goods_id")->find();//商品信息列表
        $goods['goods_img_qita']=unserialize($goods['goods_img_qita']);
        $this->assign('goods',$goods);
        $goods_sc=$goods['cat_name'];//获取服务类型
        $goods_shuxing=unserialize($goods['shuxing']);//得到商品属性
        //遍历商品属性数组，让$属性值='selected="selected"'
        foreach ($goods_shuxing as $key => $value) {
            if(is_numeric($value)){
                $this->assign($key.$value ,'selected="selected"');
            }else{
                $this->assign($value ,'selected="selected"');
            }
        }
        


        $categorymodel=D('Category');
        $arr_sc=$categorymodel->where("pid<>0 and deleted=0")->getField('cat_name',true);
        $this->assign("arr_sc",$arr_sc);
        
        
        //获取服务类型表单提交值
        if(!empty($_POST['sc_hidden'])&&$_POST['sc_hidden']==="server_content"){
            $server_content=$_POST['server_content'];
            $this->assign($server_content,'selected="selected"');
            $this->assign('server_content',$server_content);
        }else{
            $server_content=$goods_sc;
            $this->assign($server_content,'selected="selected"');
            $this->assign('server_content',$server_content);
        }

        $data_cat=$categorymodel->where("cat_name='$server_content'")->getField('shuxing');
        $arr_shuxing=unserialize($data_cat);//得到反序列化属性数组
        $this->assign("arr_shuxing",$arr_shuxing);//给模板里面的$arr_shuxing赋值

        //自选属性赋值
        $zixuan_shuxing=$goods['goods_shuxing'];
        $arr_zixuan_shuxing=unserialize($zixuan_shuxing);//得到反序列化属性数组
        $this->assign("arr_zixuan_shuxing",$arr_zixuan_shuxing);//给模板里面的$arr_shuxing赋值
        
        $this->display('goods_editor');
    }
    
    public function bianji_check(){
        $goods_id=$_GET['goods_id'];
        $goodsmodel=D('Goods');
        $goods=$goodsmodel->where("goods_id=$goods_id")->find();//商品信息列表
        $arr_goods_img_qita_yuan=  unserialize($goods['goods_img_qita']);
        
        $content=$_POST;//获取提交的内容
        if($content['shop']==''){
            $this->error('没选择店铺');
        }
        $shop_name=$content['shop'];
        $shopmodel=D('Shops');
        $shop_id=$shopmodel->where("shop_name='$shop_name'")->getField('shop_id');
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
            if(strchr($value,'temp')){
                $today=substr($value,26,8);//获取到文件夹名  如20150101
                creat_file(UPLOAD.'image/goods/'.$today);//创建文件夹（如果存在不会创建
                creat_file(UPLOAD.'image/goods/'.$today.'/thumb');//创建文件夹（如果存在不会创建
                $img_url_thumb=$this->thumb($value, 750, 400);//thumb
                rename($img_url_thumb, str_replace('Public/Uploads/image/temp', UPLOAD.'image/goods',$value));//移动文件
                $value=str_replace('Public/Uploads/image/temp','Public/Uploads/image/goods',$value);  
                $value='/'.$value;
            }else{
                $value='/'.$value;
            }
            
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
            $this->error('价格为空或者不规范,请输入如100.00');
            exit();
        }
        if(!is_price($content['yuan_price'])){
            $this->error('原价为空或者不规范,请输入如100.00');
            exit();
        }
         if(!is_price($content['fanxian'])){
            $this->error('乐享红包为空或者不合规范');
            exit();
        }
        $user_id=$_SESSION['admin_huiyuan']['user_id'];//获取发布商品的管理员id号
        $admin_usermodel=D(Admin_user);
        $fabu_name=$admin_usermodel->where("user_id={$user_id}")->getField('user_name');
        
        
        
       
        
        $result=get_file($content['content']);//得到编辑框里面的图片文件
        //遍历图片文件，并把图片文件从临时文件夹保存进正式文件夹,并把文件名存储到$file_name数组中
        foreach ($result[1] as $value){
            $today=substr($value,26,8);//获取到文件夹名  如20150101
            creat_file(UPLOAD.'image/goods/'.$today);//创建文件夹（如果存在不会创建）
            $a=copy($value, str_replace('Public/Uploads/image/temp', UPLOAD.'image/goods', $value));
        }
        $goods_desc=str_replace('Public/Uploads/image/temp', UPLOAD.'image/goods', $content['content']);
        $goods_desc=  replace_a($goods_desc);
        $goods_desc=str_replace('<embed','<iframe',$goods_desc);//把flash 的embed标签改成 iframe标签 
        $goods_desc=str_replace('/>','></iframe>',$goods_desc);//把flash 的embed标签改成 iframe标签 
        //得到商品分类id
        $categorymodel=D('Category');
        $server_content=$content['server_content'];
        $data_category=$categorymodel->where("cat_name='{$server_content}'")->find();
        $cat_id=$data_category['cat_id'];
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
            'cat_name'=>$server_content,//分类名
            'fabu_name'=>$fabu_name,     //发布者姓名
            'shop_id'=>$shop_id,
            'shop_name'=>"$shop_name",//所属店铺
            'goods_name'=>$content['title'],//商品名称
            'goods_jianjie'=>$content['goods_jianjie'],//商品简介
            'units'=>$content['units'],//商品单位重量
            'yuan_price'=>$content['yuan_price'],//原价
            'price'=>$content['price'],//乐享价
            'fanxian'=>$content['fanxian'],//乐享红包
            'fahuo_day'=>$content['select_fahuo'],//发货天数
            'shuxing'=>$str_shuxing,//属性
            'goods_shuxing'=>$str_zx_shuxing,//商品可选属性
            'goods_img'=>$goods_zhanshitu,//商品图片
            'goods_img_qita'=>$str_goods_img,//被序列化的其它图片
            'daijinquan'=>$content['radio_daijinquan'],
            'goods_desc'=>$goods_desc,//商品描述
            'last_update'=>time()            //更新时间
        );
        $result_add=$goodsmodel->where("goods_id=$goods_id")->save($row);
        if($result_add){
            $this->success('商品编辑成功！',U('Goodsmanage/index'),3);
        }
    }
    
    //下架商品
    public function goods_del(){
        $goods_id=$_POST['goods_id'];
        $goodsmodel=D('Goods');
        //$user_id=$_SESSION['huiyuan']['user_id'];
        $data['is_delete']=1;
        $goodsmodel->where("goods_id=$goods_id")->save($data);
    }
    
    //商品排序改变
    public function goods_order(){
        $goods_id=$_POST['goods_id'];
        $order=$_POST['order'];
        $goodsmodel=D('Goods');
        //$user_id=$_SESSION['huiyuan']['user_id'];
        $data['sort_order']=$order;
        $goodsmodel->where("goods_id=$goods_id")->save($data);
    }

    
    
    
    
     public function release_goods(){
         
         //获取店铺列表
         $shopsmodel=D('Shops');
         $arr_shop=$shopsmodel->getField('shop_name',true);
         $this->assign('arr_shop',$arr_shop);
        //获取该会员基本信息
        $categorymodel=D('Category');
        $arr_sc=$categorymodel->where("pid<>0 and deleted=0")->getField('cat_name',true);
        $this->assign("arr_sc",$arr_sc);
        
        //如果服务形式为个人，隐藏性别单选radio
        if($data['server_form']==='0'){
            $this->assign("css",'display: none;');
        }else{
            $this->assign("css",'');
        }
        //获取服务类型表单提交值
        if(!empty($_POST['server_content'])){
        //if(!empty($_POST['sc_hidden'])&&$_POST['sc_hidden']==="server_content"){
            $server_content=$_POST['server_content'];
            $this->assign($server_content,'selected="selected"');
            $this->assign('server_content',$server_content);
        }else{
            $server_content=$arr_sc[0];
            $this->assign('server_content',$server_content);
        }
        $data_cat=$categorymodel->where("cat_name='$server_content'")->getField('shuxing');
        $arr_shuxing=unserialize($data_cat);//得到反序列化属性数组
        $this->assign("arr_shuxing",$arr_shuxing);//给模板里面的$arr_shuxing赋值
        //var_dump($arr_shuxing);
        $this->display('release_goods');
    }
    
    
    public function release_check(){
        $content=$_POST;//获取提交的内容
        if($content['shop']==''){
            $this->error('没选择店铺');
        }
        $shop_name=$content['shop'];
        $shopmodel=D('Shops');
        $shop_id=$shopmodel->where("shop_name='$shop_name'")->getField('shop_id');
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
            $this->error('原价为空或者不合规范');
            exit();
        }
        if(!is_price($content['fanxian'])){
            $this->error('乐享红包为空或者不合规范');
            exit();
        }
        
        $user_id=$_SESSION['admin_huiyuan']['user_id'];//获取发布商品的管理员id号
        $admin_usermodel=D(Admin_user);
        $fabu_name=$admin_usermodel->where("user_id={$user_id}")->getField('user_name');



        
        
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
        
        $server_content=$content['server_content'];
        $categorymodel=D('Category');
        $data_category=$categorymodel->where("cat_name='{$server_content}'")->find();
        $cat_id=$data_category['cat_id'];
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
            'cat_name'=>$server_content,//分类名
            'fabu_name'=>$fabu_name,     //发布者姓名
            'shop_id'=>$shop_id,
            'shop_name'=>$shop_name,//所属店铺
            'goods_name'=>$content['title'],//商品名称
            'goods_jianjie'=>$content['goods_jianjie'],//商品简介
            'units'=>$content['units'],//商品单位重量
            'yuan_price'=>$content['yuan_price'],//原价
            'price'=>$content['price'],//单购价
            'fanxian'=>$content['fanxian'],
            'fahuo_day'=>$content['select_fahuo'],//发货天数
            'shuxing'=>$str_shuxing,//属性
            'goods_img'=>$goods_zhanshitu,//商品图片
            'goods_img_qita'=>$str_goods_img,//被序列化的其它图片
            'daijinquan'=>$content['radio_daijinquan'],
            'goods_desc'=>$goods_desc,//商品描述
            'goods_shuxing'=>$str_zx_shuxing,//商品可选属性
            'add_time'=>time(),             //添加时间
            'last_update'=>time()            //更新时间初始等于添加时间
        );
        $result_add=$goodsmodel->add($row);
        if($result_add){
            $this->success('恭喜您，商品发布成功了',U('Goodsmanage/index'),3);
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
    

    



}