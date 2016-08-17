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
            $_SESSION['huiyuan']=$row;
            if(!$user_id){ 
                $usersmodel->add($row);
                $row['user_id']=$usersmodel->where("open_id='$open_id'")->getField('user_id');
            }else{
                $usersmodel->where("user_id='$user_id'")->save($row);
                $row['user_id']=$user_id;
            }
            $_SESSION['huiyuan']=$row;
            if(isset($_SESSION['ref'])){
                header("location:". U($_SESSION['ref']));
                exit();
            }else{
                header("location:". U('index/index'));
                exit();
            }
            
        }else{
            $usersmodel=D('Users');
            $user=$usersmodel->where("open_id='123456'")->field('user_id,user_name,open_id')->find();
            $_SESSION['huiyuan']=array(
            'user_id'=>$user['user_id'],
            'user_name'=>$user['user_name'],
            'open_id'=>"$open_id",
            'head_url'=>$use['head_url']
                );
            if(isset($_SESSION['ref'])){
                header("location:". U($_SESSION['ref']));
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
            var_dump($_SESSION['wei_huiyuan']);exit();
            if($userinfo['subscribe']==0){
                //未关注，返回原页面并弹出关注页面
                $_SESSION['guanzhu']='weiguanzhu';
                //查看页面是否有$_SESSION  guanzhu='weiguanzhu'  有的话，弹出关注框(给js用)
                $this->assign('guanzhu',$_SESSION['guanzhu']);
                
            }else{
                $_SESSION['guanzhu']='yiguanzhu'; 
                //查看页面是否有$_SESSION  guanzhu='weiguanzhu'  有的话，弹出关注框(给js用)
                $this->assign('guanzhu',$_SESSION['guanzhu']);
            }
            if(isset($_SESSION['ref'])){
                header("location:". U($_SESSION['ref']));
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
                header("location:". U($_SESSION['ref']));
                exit();
            }else{
                header("location:". U('index/index'));
                exit();
            }
        }
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
}


