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
     protected function get_access_token(){
        $token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .APPID. "&secret=" .APPSECRET;
        $res = file_get_contents($token_access_url); //获取文件内容或获取网络请求的内容
        $result = json_decode($res, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
        $access_token = $result['access_token'];
        S('access_token',$access_token,7000);
    }
    protected function s_access_token() {
      //获取微信access_token
        $access_token=S('access_token');
        if(!$access_token){
            $this->get_access_token();
        }
  }
    //发送模板消息
    protected function response_template($open_id,$template_id,$url,$tem_data){
        $arr_data=array(
            'touser'=>$open_id,
            "template_id"=>$template_id,
            "url"=>"http://m.jiangzipinpin.com".$url,
            "data"=>$tem_data
        );
        $data=json_encode($arr_data,JSON_UNESCAPED_UNICODE);
        $this->s_access_token();
        $access_token=S('access_token');
        $MENU_URL="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $MENU_URL); 
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        $info = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Errno'.curl_error($ch);
        }
        curl_close($ch);

        //var_dump($info);
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
