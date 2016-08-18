<?php

namespace Home\Controller;

use Think\Controller;

class FontEndController extends Controller {

    function __construct() {
        parent::__construct();
        
        header("content-type:text/html;charset=utf-8"); 
        
        //判断是否需要记录当前url 数组内必须首字母大写
        $noref=array('Index/search_m','Index/search','Goods/page','Index/menu','Order/yanzheng_zfmm','Order/queren_success','Goods/zhifu','Goods/pinglun','Member/cart_del','Member/goods_del','Goods/jiance_pay','Goods/getUniqueOrderNo','Goods/notifyweixin','Goods/notify','Goods/gmcg_wx','Goods/sellection_join','Buy/getQRPHP','Member/xiugai_zhifumima','Member/xiugai_zhifumima_check','Member/xiugai_zhifumima_success','Member/xiugai_mima','Member/xiugai_mima_check','Member/xiugai_mima_success','Member/getCode','Order/new_order');
        $noref_contorller=array('Zhuce','Login','Buy');
        if(!in_array(CONTROLLER_NAME.'/'.ACTION_NAME, $noref)&&!in_array(CONTROLLER_NAME, $noref_contorller)){
            $_SESSION['ref']=  str_replace('.html', '',$_SERVER['REQUEST_URI']);
        }
        
        //需要关注登录的控制器或者方法
        $login_contorller = array();//需要登录的控制器
        $login=array('Goods/pinglun','Goods/dandu_buy','Goods/kaituan_buy','Goods/cantuan_buy','Goods/dandu_buy_success','Goods/kaituan_success','Goods/cantuan_success()','Goods/zhifu()','Goods/alipay','Goods/weixin_zhijiezhifu','Goods/notifyweixin','Goods/gmcg_wx','Goods/jiance_pay','Goods/sellection_join','Goods/pinglun','Goods/pinglun');//需要登录的方法
        if (in_array(CONTROLLER_NAME, $login_contorller)||in_array(CONTROLLER_NAME.'/'.ACTION_NAME, $login)) {
            if (!isset($_SESSION['huiyuan']) || $_SESSION['huiyuan'] == '') {
                header("location:". U("Login/index"));
                exit();
            }
        }
        
        //用于未关注登陆未成功返回登陆前页面的记录url
        //if(!in_array(CONTROLLER_NAME.'/'.ACTION_NAME, $noref)&&!in_array(CONTROLLER_NAME, $noref_contorller)){
            //$_SESSION['before_login_ref']= str_replace('.html', '',$_SERVER['REQUEST_URI']);
        //}
        //
        
        
        //需要无关注伪登陆的控制器或者方式
        $wei_login_contorller = array('Member','Order');//需要登录的控制器
        $wei_login=array('Goods/index','Goods/pintuan_info');
        if (in_array(CONTROLLER_NAME, $wei_login_contorller)||in_array(CONTROLLER_NAME.'/'.ACTION_NAME, $wei_login)){
            if (!isset($_SESSION['wei_huiyuan']) || $_SESSION['wei_huiyuan'] == '') {
                header("location:". U("Login/wei_index"));
                exit();
            }
        }
        
        
        $this->assign("date",date('Y'));//给日期赋值 
        $informodel=D('Admin_infor');
        $webinfor=$informodel->where("id=1")->find();
        $this->assign("copy",$webinfor['copy']);//给备案号赋值
        $this->assign("title",$webinfor['web_name']);//给标题赋值
        $this->assign("keywords",$webinfor['key_word']);//给关键字赋值
        $this->assign("description",$webinfor['description']);//给描述赋值
        
        //给menu页面中的最近浏览赋值
        $arr_goodsid=  array_reverse(cookie('distory_goods_id'));
        if(!empty($arr_goodsid)){
            $goodsmodel=D('Goods');
            foreach ($arr_goodsid as $v){
                if(is_shuzi($v)){
                    $distory_goods[]=$goodsmodel->where("goods_id=$v")->field('goods_id,goods_name,yuan_price,price,goods_img')->find();
                }else{
                    echo '发生错误，商品id为：'.$v;
                    cookie('distory_goods_id',null);
                }
            }
            $this->assign('distory_goods',$distory_goods);
        }
        
        
        
        //$ismobile = checkmobile();//检查客户端是否是手机
        if($_SERVER['HTTP_HOST']==='m.jiangzipinpin.com'||$_SERVER['HTTP_HOST']==='m.myguopin.com'){
            C("DEFAULT_THEME", "Mobile");//默认模板主题名称
            C("TMPL_CACHE_PREFIX", "mb");//模板缓存前缀标志
            $this->assign("title",$webinfor['web_name']);//给标题赋值
        }
        
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
    //手机端 get_page
    public function get_page_iphone($count,$page_size){
        $page=new \Think\Page($count,$page_size);//创建一个page类  参数1是数据总条数，参数2是一页显示的条数
        $page->rollPage=3;
        $page->setConfig('header','<span class="rows">共 %TOTAL_PAGE% 页</span>');
        $page->setConfig('prev','<上一页');
        $page->setConfig('next','下一页>');
        $page->setConfig('theme', '%UP_PAGE% %LINK_PAGE% %DOWN_PAGE%');
        return $page;
    }
    
    protected function get_access_token(){
        $token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .APPID. "&secret=" .APPSECRET;
        $res = file_get_contents($token_access_url); //获取文件内容或获取网络请求的内容
        $result = json_decode($res, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
        $access_token = $result['access_token'];
        S('access_token',$access_token,7000);
    }
    
    protected function get_jsapi_ticket($access_token){
        $jsapi_ticket_url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=" . $access_token . "&type=jsapi" ;
        $res = file_get_contents($jsapi_ticket_url); //获取文件内容或获取网络请求的内容
        $result = json_decode($res, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
        $jsapi_ticket = $result['ticket'];
        S('jsapi_ticket',$jsapi_ticket);
    }
    
    
    protected function get_wx_config($jsapi_ticket){
        $url = "http://".$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI];
        $timestamp = time();
        $nonceStr = $this->createNonceStr();
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapi_ticket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signature = sha1($string);
        $wx_config = array(
                "appId"     =>APPID,
                "nonceStr"  => $nonceStr,
                "timestamp" => $timestamp,
                "url"=>$url,
                "signature" => $signature
                );
        return $wx_config;
    }
    
    
    protected function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }
  
  protected function get_weixin_config(){
      //获取微信access_token
        $access_token=S('access_token');
        if(!$access_token){
            $this->get_access_token();
            $access_token=S('access_token');
        }
        $this->get_jsapi_ticket($access_token);
        $jsapi_ticket=S('jsapi_ticket');
        if(!$jsapi_ticket){
            $this->get_access_token();
            $access_token=S('access_token');
            $this->get_jsapi_ticket($access_token);
            $jsapi_ticket=S('jsapi_ticket');
        }
        $wx_config=$this->get_wx_config($jsapi_ticket);
        $this->assign('wx_config',$wx_config); 
        //var_dump($wx_config);
  }
  
  protected function get_daijinquan($user_id,$type,$sum){
      $tm=time();
      $guoqi=strtotime(date('Y-d-m 23:59:59',($tm+345600)));
      $youxiaoqi=date('Y.m.d',$tm).'-'.date('Y.m.d',($tm+345600));
      $usersmodel=D('Users');
      $daijinquan=$usersmodel->where("user_id=$user_id")->getField('daijinquan');
      if($daijinquan!=''){
          $arr_daijinquan=  unserialize($daijinquan);
      }
      $arr_daijinquan[]=array(
          'type'=>$type,
          'sum'=>$sum,
          'youxiaoqi'=>$youxiaoqi,
          'guoqi'=>$guoqi
          );
      
      
      //对多维数组按照‘sum’排序
       foreach ($arr_daijinquan as $key => $value) {
            $paixu[$key] = $value['sum'];
        }
      array_multisort($paixu,$arr_daijinquan);

      $new_daijinquan=  serialize($arr_daijinquan);
      $row=array(
          'daijinquan'=>$new_daijinquan
      );
      $result=$usersmodel->where("user_id=$user_id")->save($row);
      return $result;
  }





}