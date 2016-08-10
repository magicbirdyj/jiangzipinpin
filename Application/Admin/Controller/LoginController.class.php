<?php
namespace Admin\Controller;
use  Admin\Controller;
class LoginController extends FontEndController {
    public function index(){
        $time=gettime();
        $_SESSION['login']=$time;
        $this->assign("title", "用户登录");
        $this->assign("time", $time);
        if($_GET['url_to']==='hunliren'){
            $this->assign("url_to", U('Login/chenggong',array('url_to'=>'hunliren')));
        }else if($_GET['url_to']==='Member'){
             $this->assign("url_to", U('Login/chenggong',array('url_to'=>'Member')));
        }else{
             $this->assign("url_to", U('Login/chenggong'));
        }
        $this->display('index');
    }

    public function quit(){
        unset($_SESSION['admin_huiyuan']);
        $index_url=U('Index/index');
        header ( "Location: {$index_url}" ); 
        exit();
    }
    
    public function login(){
        if($_POST['check']=='login'){
            $dlm=$_POST['shoujihao'];
            $mima =$_POST['mima'];
            if(is_feifa($dlm)||is_feifa($mima)){
                exit();
            }
            $usersmodel=D('Admin_user');
            $is_cunzai=$usersmodel->where("mobile_phone='{$dlm}'")->count();
            if($is_cunzai!=='0'){
                $salt=$usersmodel->where("mobile_phone='{$dlm}'")->getField('ad_salt');
                $mima_md5=md5($mima.$salt);
                $data=$usersmodel->where("mobile_phone='{$dlm}' and password='{$mima_md5}'")->count();

            }else{
                $data='-1';
            }
            $this->ajaxReturn($data);
            exit();
        }
    }

    public function chenggong() {
         if(!empty($_POST['hidden'])&&!empty($_SESSION['login'])){
             if($_POST['hidden']==$_SESSION['login']){
                 if(is_feifa($dlm)||is_feifa($mima)){
                     exit();
                 }
                $dlm=$_POST['shoujihao'];
                $usersmodel=D('Admin_user');
                $row=array(
                    'last_login'=>mktime(),
                    'last_ip'=>$_SERVER['REMOTE_ADDR']
                );
                $usersmodel->where("mobile_phone='{$dlm}'")->save($row);
                $id=$usersmodel->where("mobile_phone='{$dlm}'")->getField('user_id');
                $hym=$usersmodel->where("mobile_phone='{$dlm}'")->getField('user_name');
                $last_login=$usersmodel->where("mobile_phone='{$dlm}'")->getField('last_login');
                $_SESSION['admin_huiyuan']=array(
                    'user_id'=>$id,
                    'user_name'=>$hym,
                    'last_login'=>$last_login
                     );
  
                header("location:". U('index/index'));
                
                unset($_SESSION['login']);
                exit();
                }
                $this->error('非法进入，将转到登录页面',U('login/index'),3);
                exit();
         }
         $this->error('非法进入，将转到主页',U('login/index'),3);
         exit();
    }
}


