<?php
namespace Home\Controller;
use  Home\Controller;
class LoginController extends FontEndController {
    public function index(){
        if(isset($_SESSION['huiyuan'])&&isset($_SESSION['guanzhu'])){
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

    
    
    
    public function weixin_login(){
        //获取微信用户信息并直接登陆
        if(isset($_GET['code'])){
            $code=$_GET['code'];
            $wangye=$this->get_wangye($code);
            $open_id=$wangye['openid'];
            //获取微信access_token
            $this->s_access_token();
            $access_token=S('access_token');
            
            $userinfo=$this->get_userinfo($open_id,$access_token);
            $usersmodel=D('Users');
            $user_id=$usersmodel->where("open_id='$open_id'")->getField('user_id');
            $row=array(
                'open_id'=>"$open_id",
                'user_name'=>$userinfo['nickname'],
                'sex'=>$userinfo['sex'],
                'head_url'=>$userinfo['headimgurl']
            );
            if($userinfo['subscribe']===0){//未关注的情况
                if(!$user_id){//数据库没有信息，又未关注，转到首页
                    $this->redirect('Index/index');
                }
                $row['user_id']=$user_id;
                $_SESSION['huiyuan']=$row;
                 //未关注，返回原页面并弹出关注页面
                $_SESSION['guanzhu']='weiguanzhu';
            }else if($userinfo['subscribe']===1){
                $_SESSION['guanzhu']='yiguanzhu';
                
                if(!$user_id){ 
                    $row_shujuku=$row;
                    $row_shujuku['reg_time']=time();
                    $row_shujuku['last_ip']=$_SERVER["REMOTE_ADDR"];
                    $usersmodel->add($row_shujuku);
                    $row['user_id']=$usersmodel->where("open_id='$open_id'")->getField('user_id');
                }else{
                    $row_shujuku=$row;
                    $row_shujuku['last_login']=time();
                    $row_shujuku['last_ip']=$_SERVER["REMOTE_ADDR"];
                    $usersmodel->where("user_id='$user_id'")->save($row_shujuku);
                    $row['user_id']=$user_id;
                }
                $_SESSION['huiyuan']=$row;
            }else{
                var_dump('code： '.$code);
                var_dump('wangye： '.$wangye);
                var_dump('access_token： '.$access_token);
                var_dump('userinfo ： '.$userinfo);
                echo '出现该错误，请和管理员联系报错 13574506835 谢谢';
                exit;
            }
            if(isset($_SESSION['ref'])){
                header("location:". $_SESSION['ref']);
                exit();
            }else{
                header("location:". U('index/index'));
                exit();
            }
            
        }else{// 用于不是微信浏览器
             if(is_weixin()){
                 echo '错误，微信浏览器却没得到code';
                 exit;
             }
            $usersmodel=D('Users');
            $user=$usersmodel->where("open_id='oSI43woDNwqw6b_jBLpM2wPjFn_M'")->field('user_id,user_name,open_id')->find();
            $row['last_login']=time();
            $row['last_ip']=$_SERVER["REMOTE_ADDR"];
            $usersmodel->where("open_id='oSI43woDNwqw6b_jBLpM2wPjFn_M'")->save($row);
            $_SESSION['huiyuan']=array(
            'user_id'=>$user['user_id'],
            'user_name'=>$user['user_name'],
            'open_id'=>$user['open_id'],
            'head_url'=>$user['head_url']
                );
            $_SESSION['guanzhu']='yiguanzhu';
            //var_dump('请从微信打开');exit;
            if(isset($_SESSION['ref'])){
                header("location:". $_SESSION['ref']);
                exit();
            }else{
                header("location:". U('index/index'));
                exit();
            }
        }
    }
    
    
    
    
    // 删除session guanzhu   给js的ajax用
    public function delete_guanzhu() {
        session('guanzhu',null); 
    }
    
    //把url存入数据库，给js的ajax用
    public function save_url_ajax(){
        $url=$_POST['url'];
        $this->save_url($url);
        $this->ajaxReturn($url);
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


