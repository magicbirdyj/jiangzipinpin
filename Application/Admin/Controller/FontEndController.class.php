<?php

namespace Admin\Controller;

use Think\Controller;

class FontEndController extends Controller {

    function __construct() {
        parent::__construct();
        header("content-type:text/html;charset=utf-8"); 
        //权限判断 数组内必须首字母大写
        $nologin = array("Zhuce",'Login');
        if (!in_array(CONTROLLER_NAME, $nologin)) {
            if (!isset($_SESSION['admin_huiyuan']) || $_SESSION['admin_huiyuan'] == '') {
                $_SESSION['ref']=CONTROLLER_NAME.'/'.ACTION_NAME;
                header("location:". U("Login/index"));
            }
        }
        
         
        $this->assign("date",date('Y'));//给日期赋值 
        $informodel=D('Admin_infor');
        $webinfor=$informodel->where("id=1")->find();
        $this->assign("copy",$webinfor['copy']);//给备案号赋值
        $this->assign("title",$webinfor['web_name']);//给标题赋值
        $this->assign("keywords",$webinfor['key_word']);//给关键字赋值
        $this->assign("description",$webinfor['description']);//给描述赋值
        $ismobile = ismobile();//检查客户端是否是手机
        if ($ismobile) {
            C("DEFAULT_THEME", "Mobile");
            C("TMPL_CACHE_PREFIX", "mb");
        }
        $this->assign("ismobile", $ismobile);
    }
    
    public function upload($path){
    $config=array(
        'maxSize'=> 5242880,//上传文件最大值5M
        'rootPath'=>UPLOAD,
        'savePath'=> $path,
        'saveName'=>'getname',
        'exts'=> array('jpg', 'gif', 'png', 'jpeg','bmp','swf'),
        'autoSub'=> true,
        'subName'=>array('date','Ymd')
    );
    $upload = new \Think\Upload($config);// 实例化上传类
    $info   =   $upload->upload();
    if(!$info) {
        //$this->error($upload->getError());
        $a[0]='error';
        $a[1]=$upload->getError();
        return $a;
    }else{// 上传成功,返回文件信息
        $a[0]='success';
        $a[1]=$info;
        return $a;
        }
    }
    
    
    public function get_page($count,$page_size){
        $page=new \Think\Page($count,$page_size);//创建一个page类  参数1是数据总条数，参数2是一页显示的条数
        $page->setConfig('header','<span class="rows">共 %TOTAL_PAGE% 页</span>');
        $page->setConfig('prev','<上一页');
        $page->setConfig('next','下一页>');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        return $page;
    }

}
