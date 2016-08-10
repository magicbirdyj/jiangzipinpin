<?php
namespace Admin\Controller;
use Admin\Controller;
class WebinforController extends FontEndController {
   
    public function index(){
        $informodel=D('Admin_infor');
        $date=$informodel->where("id=1")->find();
        $this->assign('date',$date);
        $this->display();
    }
    public function xiugai(){
        $row=$_POST;
        $informodel=D('Admin_infor');
        $informodel->where("id=1")->save($row);
        $url=U('Webinfor/index');
        header ( "Location: {$url}" ); 
    }
    
    
    public function company() {
        $companymodel=D('Admin_company');
        $name=$_GET['name'];
        $data=$companymodel->where("name='$name'")->find();
        $this->assign('data',$data);
        $this->display();
    }
    

    
    
     public function bianji_check(){
        $name=$_POST['name'];
        $content=$_POST['content'];
        $result=get_file($content);//得到编辑框里面的图片文件
         //遍历图片文件，并把图片文件从临时文件夹保存进正式文件夹,并把文件名存储到$file_name数组中
        foreach ($result[1] as $value){
            $today=substr($value,26,8);//获取到文件夹名  如20150101
            creat_file(UPLOAD.'image/admin/'.$today);//创建文件夹（如果存在不会创建）
            rename($value, str_replace('Public/Uploads/image/temp', UPLOAD.'image/admin', $value));//移动文件
        }
        $text=str_replace('Public/Uploads/image/temp', UPLOAD.'image/admin', $content);
        $advertmodel=D('Admin_company');
        $row=array(
            'text'=>$text,
            'add_user'=>$_SESSION['admin_huiyuan']['user_id'],
            'add_user_name'=>$_SESSION['admin_huiyuan']['user_name'],
            'edit_time'=>mktime()
        );
        $result1=$advertmodel->where("name='{$name}'")->save($row);
        if($result1!==false){
            $url=U("Webinfor/company","name=$name");
            header("location:$url");
            exit();
        }else{
            $this->error('更新数据库失败');
            exit();
        }
    }


}