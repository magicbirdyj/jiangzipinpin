<?php
namespace Home\Controller;
use  Home\Controller;
class LoginController extends FontEndController {
    public function index(){
        if(isset($_SESSION['huiyuan'])){
            $index_url=U('index/index');
            header ( "Location: {$index_url}" ); 
            exit();
        }
        if(is_weixin()){
            $a=urlencode("http://m.jiangzipinpin.com/Home/Login/weixin_login");
            $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx91953340c19f656e&redirect_uri=".$a."&response_type=code&scope=snsapi_base&state=1#wechat_redirect";
            header("Location:{$url}");
            exit();
        }else{
            $this->redirect('Login/weixin_login');
        }
    }

    public function wei_index(){
        if(isset($_SESSION['wei_huiyuan'])){
            $index_url=U('index/index');
            header ( "Location: {$index_url}" ); 
            exit();
        }
        if(is_weixin()){
            $a=urlencode("http://m.jiangzipinpin.com/Home/Login/wei_login");
            $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx91953340c19f656e&redirect_uri=".$a."&response_type=code&scope=snsapi_base&state=1#wechat_redirect";
            header("Location:{$url}");
            exit();
        }else{
            $this->redirect('Login/wei_login');
        }
    }
    
    
    public function weixin_login(){
        //获取微信用户信息并直接登陆
        if(isset($_GET['code'])){
            $code=$_GET['code'];
            $wangye=$this->get_wangye($code);
            $open_id=$wangye['openid'];
            $access_token=S('access_token');
            $userinfo=$this->get_userinfo($open_id,$access_token);
            $usersmodel=D('Users');
            $user_id=$usersmodel->where("open_id='$open_id'")->getField('user_id');
            $row=array(
                'open_id'=>"$open_id",
                'user_name'=>$userinfo['nickname'],
                'head_url'=>$userinfo['headimgurl']
            );
            if($userinfo['subscribe']==0){//未关注的情况
                if(!$user_id){//数据库没有信息，又未关注，提示错误
                    $this->error('您还未关注！请从首页进入','Index/index');
                }
                $row['user_id']=$user_id;
                $_SESSION['huiyuan']=$row;
            }else{
                $_SESSION['huiyuan']=$row;
                if(!$user_id){ 
                    $usersmodel->add($row);
                    $row['user_id']=$usersmodel->where("open_id='$open_id'")->getField('user_id');
                }else{
                    $usersmodel->where("user_id='$user_id'")->save($row);
                    $row['user_id']=$user_id;
                }
                $_SESSION['huiyuan']=$row;
            }
            if(isset($_SESSION['ref'])){
                header("location:". $_SESSION['ref']);
                exit();
            }else{
                header("location:". U('index/index'));
                exit();
            }
            
        }else{// 用于不是微信浏览器
            $usersmodel=D('Users');
            $user=$usersmodel->where("open_id='123456'")->field('user_id,user_name,open_id')->find();
            $_SESSION['huiyuan']=array(
            'user_id'=>$user['user_id'],
            'user_name'=>$user['user_name'],
            'open_id'=>"$open_id",
            'head_url'=>$use['head_url']
                );
            if(isset($_SESSION['ref'])){
                header("location:". $_SESSION['ref']);
                exit();
            }else{
                header("location:". U('index/index'));
                exit();
            }
        }
    }
    
    
    public function wei_login(){
        //获取微信用户信息并直接登陆
        if(isset($_GET['code'])){
            $code=$_GET['code'];
            $wangye=$this->get_wangye($code);
            $open_id=$wangye['openid'];
            $access_token=S('access_token');
            $userinfo=$this->get_userinfo($open_id,$access_token);
            $usersmodel=D('Users');
            $user_id=$usersmodel->where("open_id='$open_id'")->getField('user_id');
            $row=array(
                 'open_id'=>"$open_id"
                );
            if(!$user_id){
                $usersmodel->add($row);
                $row['user_id']=$usersmodel->where("open_id='$open_id'")->getField('user_id');
            }else{
                $row['user_id']=$user_id;
            }
            $_SESSION['wei_huiyuan']=$row;
            if($userinfo['subscribe']==0){
                //未关注，返回原页面并弹出关注页面
                $_SESSION['guanzhu']='weiguanzhu';
            }else{
                $_SESSION['guanzhu']='yiguanzhu'; 
            }
            if(isset($_SESSION['ref'])){
                header("location:". $_SESSION['ref']);
                exit();
            }else{
                header("location:". U('index/index'));
                exit();
            }
        }else{
            $usersmodel=D('Users');
            $user=$usersmodel->where("open_id='123456'")->field('user_id,user_name,open_id')->find();
            $_SESSION['wei_huiyuan']=array(
            'user_id'=>$user['user_id'],
            'open_id'=>"$open_id",
                );
            if(isset($_SESSION['ref'])){
                header("location:". $_SESSION['ref']);
                exit();
            }else{
                header("location:". U('index/index'));
                exit();
            }
        }
    }
    
    public function delete_wei_huiyuan() {
        session('wei_huiyuan',null); 
    }
    
    private function get_wangye($code){
       $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".APPID."&secret=".APPSECRET."&code=".$code."&grant_type=authorization_code" ;
       $res = file_get_contents($url); //获取文件内容或获取网络请求的内容
       $result = json_decode($res, true);//接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
       return $result;
  }
  
  private function get_userinfo($openid,$access_token){
       $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN" ;
       $res = file_get_contents($url); //获取文件内容或获取网络请求的内容
       $result = json_decode($res, true);//接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
       return $result;
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
        $user=$usersmodel->where("user_id=$user_id")->field('user_name,address,head_url')->find();
        $arr_address=  unserialize($user['address']);
        $address=$arr_address[$order_address];
        $arr_location=  explode(' ', $address['location']);
        $location=$arr_location[1];
        $shijian=$this->shijian($new_order['created']);
        $data=array(
            'head_url'=>$user['head_url'],
            'text'=>'最新订单来自 '.$location.' 的 '.$user['user_name'].',  '.$shijian.'前'
        );
        return $data;
    }
}


