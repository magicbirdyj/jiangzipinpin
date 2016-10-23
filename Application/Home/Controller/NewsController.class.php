<?php
namespace Home\Controller;
use Home\Controller;
class NewsController extends FontEndController {
    public function index(){
        $open_id=$_SESSION['huiyuan']['open_id'];
        $arr_admin=array('oSI43woDNwqw6b_jBLpM2wPjFn_M','oSI43wkMT4fkU_DXrU7XfdE9krA0','oSI43wqsiGkFK2YaGsC34fgwHEL0');
        if(!in_array($open_id, $arr_admin)){
            $this->error('您没有权限!');
        }
        $newsmodel=D('News');
       
        $status=$_GET['status'];
        $this->assign('canshu',$status);
        $status_count['0']=$newsmodel->where("is_delete=0")->count();//获取上架商品条数
        $status_count['1']=$newsmodel->where("is_delete=1")->count();//获取下架商品条数
        $this->assign('status_count',$status_count);
        if($status==='1'){
             $list=$newsmodel->where("is_delete=1")->order('news_id desc')->select();
         }else{
             $list=$newsmodel->where("is_delete=0")->order('news_id desc')->select(); 
         }
        $this->assign('list',$list);
       
        $this->display();
    }
    
    
    public function text() {
        $news_id=$_GET['news_id'];
        if(!$news_id){
            $this->error('找不到该文章');
        }
        $newsmodel=D('News');
        $news=$newsmodel->where("news_id=$news_id")->find();
        
        $this->assign('news',$news);
        $this->display();
    }
    

 public function release_news(){
     $this->display();
 }
 
 
 public function release_check(){
        $content=$_POST;//获取提交的内容
        $newsmodel=D('News');
        if(empty($content['goods_zhanshitu'])){
            $this->error('未选择文章图片');
            exit();
        }
        if(strstr($content['goods_zhanshitu'], "undefined")!==false){
            $this->error('有未上传成功的图片');
            exit();
        }
        // 获取展示图片并thumb(250, 250)再移动
        $goods_zhanshitu=$content['goods_zhanshitu'];//获取
        $goods_zhanshitu_thumb=$this->thumb($goods_zhanshitu, 900, 500);//thumb
        //移动到正式文件夹
        $today=substr($goods_zhanshitu,26,8);//获取到文件夹名  如20150101
        creat_file(UPLOAD.'image/news/'.$today);//创建文件夹（如果存在不会创建
        rename($goods_zhanshitu_thumb, str_replace('Public/Uploads/image/temp', UPLOAD.'image/news',$goods_zhanshitu));//移动文件
        $goods_zhanshitu='/'.str_replace('Public/Uploads/image/temp', UPLOAD.'image/news',$goods_zhanshitu);
        
        

        
        
       

        if($content['title']==''||is_feifa($content['title'])){
            $this->error('文章标题为空或者含有非法字符');
            exit();
        }
       
        
        $fabu_open_id=$_SESSION['huiyuan']['open_id'];//获取发布商品的管理员id号




        
        
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
        
        
        
        
        
        //保存商品信息，把商品信息写入数据库
        $row=array(
            'fabu_open_id'=>$fabu_open_id,     //发布者姓名
            'news_name'=>$content['title'],//商品名称
            'img'=>$goods_zhanshitu,//商品图片
            'news_content'=>$goods_desc,//商品描述
            'created'=>time(),             //添加时间
            'updata'=>time()            //更新时间初始等于添加时间
        );
        $result_add=$newsmodel->add($row);
        if($result_add){
            $this->success('恭喜您，文章发布成功了',U('News/index'),3);
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