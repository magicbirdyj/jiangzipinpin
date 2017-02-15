<?php
namespace Home\Controller;
use Home\Controller;
class IndexController extends FontEndController {
   
    public function index(){
        //首先必须获取关注状态
        if(!isset($_SESSION['guanzhu'])||$_SESSION['guanzhu']==''){
            header("location:". U("Login/index"));
            exit();
            //$this->error('关注信息为空');
        }
        C('TOKEN_ON',false);//取消表单令牌
        $advertmodel=D('Admin_advert');
        
        $lunbo=$advertmodel->where("position='轮播'")->field('img_url,url')->select();
       
        $this->assign('lunbo',$lunbo);
        $this->assign('guanzhu',$_SESSION['guanzhu']);
        $this->display();
    }
    


    
    public function get_new_order(){
        $time=  cookie('time');
        $ordermodel=D('Order');
        if((!cookie('new_order'))||cookie('new_order')==='a:0:{}'){
            $time=time();
            cookie('time',$time);
            if(!cookie('newest_order_id')){
                $new_order=$ordermodel->order('order_id desc')->field('order_id,user_id,created,order_address')->limit(6)->select();
                $str_new_order=  serialize($new_order);
                cookie('new_order',$str_new_order); 
                cookie('newest_order_id',$new_order[0]['order_id']);//记录最后一条order_id
            }else{
                $newest_order_id=  cookie('newest_order_id');
                $new_order=$ordermodel->where("order_id>$newest_order_id")->order('order_id desc')->field('order_id,user_id,created,order_address')->limit(6)->select();
                if(!$new_order[0]){
                    $this->ajaxReturn('0');exit();
                }
                $str_new_order=  serialize($new_order);
                cookie('new_order',$str_new_order);
                cookie('newest_order_id',$new_order[0]['order_id']);//记录最后一条order_id
            }
        }
        $arr_cookie=  unserialize(cookie('new_order'));
        $user=array_pop($arr_cookie);
        cookie('new_order',serialize($arr_cookie));
        $data=$this->get_user($user);
        $this->ajaxReturn($data);

    }
    
    
    
    private function get_user($new_order){
        $usersmodel=D('Users');
        $user_id=$new_order['user_id'];
        $order_address=$new_order['order_address'];
        $user=$usersmodel->where("user_id=$user_id")->field('user_name,head_url')->find();
        $arr_location=  explode(' ', $order_address);
        $location=$arr_location[1];
        $shijian=$this->shijian($new_order['created']);
        $data=array(
            'head_url'=>$user['head_url'],
            'text'=>'最新订单来自 '.$location.' 的 '.$user['user_name'].',  '.$shijian.'前'
        );
        return $data;
    }
    
    
    private function shijian($time){
        $second=time()-$time;
        if($second<60){
            $shijian=$second.'秒';
        }elseif($second<3600){
            $shijian=floor($second/60).'分钟';
        }elseif($second<86400){
            $shijian=floor($second/3600).'小时';
        }else{
            $shijian=floor($second/86400).'天';
        }
        return $shijian;
    }
    
    public function news_all(){
        
        $newsmodel=D('News');
        $list=$newsmodel->where("is_delete=0")->order('news_id desc')->select();

        $this->assign('list',$list);
       
        $this->display();
    }
    public function news() {
        $news_id=$_GET['news_id'];
        if(!$news_id){
            $this->error('找不到该文章');
        }
        $newsmodel=D('News');
        $news=$newsmodel->where("news_id=$news_id")->find();
        if(!$news){
            $this->error('找不到该文章');
        }
        $this->assign('news',$news);
        $js_content=preg_replace('/\n|\r/', " ", $news['news_content']);
        $js_content=mb_substr($js_content,0,50,'utf-8');
        $this->assign('js_content',$js_content);
        $this->display();
        //让文章的阅读次数加1
         $newsmodel->where("news_id='$news_id'")->setInc('read_count');
    }
    
    
    
    
    
}