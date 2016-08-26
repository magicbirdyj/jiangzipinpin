<?php
namespace Home\Controller;
use Home\Controller;
class MemberController extends FontEndController {
    public function index(){
        session('guanzhu',null); 
        $user_id=$_SESSION['wei_huiyuan']['user_id'];//获取会员id号
        $usersmodel=D('Users');
        if(!empty($user_id)||$user_id===0){
        $data=$usersmodel->where("user_id={$user_id}")->find();
        }
        $this->assign("touxiang_url",$data['head_url']);
        if(date("H" ,$data['reg_time'])<12){
            $day_time='上午好';
        }else if(date("H" ,$data['reg_time'])>=12&&date("H" ,$data['reg_time'])<20){
            $day_time='下午好';
        }else{
            $day_time='晚上好';
        }
        $this->assign("day_time",$day_time);
        $this->assign("userdata",$data);
        
        $ordermodel=D('Order');
         $status_count['all']=$ordermodel->where("user_id={$user_id} and deleted=0")->count();//获取全部订单条数
         $status_count['no_pay']=$ordermodel->where("user_id={$user_id} and pay_status=0 and deleted=0  and status<6")->count();//获取待付款条数
         $status_count['wait_tuan']=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=1 and deleted=0 and tuan_no<>0")->count();//获取待成团条数
         $status_count['daifahuo']=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=2 and deleted=0")->count();//获取待发货条数
         $status_count['daishouhuo']=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=3 and deleted=0")->count();//获取待收货条数
         $status_count['daipingjia']=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=4 and deleted=0")->count();//获取待评价条数
         $status_count['shouhou']=$ordermodel->where("user_id={$user_id} and pay_status>1 and deleted=0")->count();//获取售后条数
         $this->assign(status_count,$status_count);
         
        $sellectionmodel=D('Sellection');
        $status_count['sellection']=$sellectionmodel->where("user_id=$user_id")->count();
        
        
        $status_count['yipingjia']=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=5")->count();
        
        
        $this->assign(status_count,$status_count);
        
        $this->display('index');
    }
    
    

    public function order(){
        session('guanzhu',null); 
         $status=$_GET['status'];
         $this->assign('title','我的订单');
         $ordermodel=D('Order');
         $user_id=$_SESSION['wei_huiyuan']['user_id'];
         $status_count['all']=$ordermodel->where("user_id={$user_id}")->count();//获取全部订单条数
         $status_count['no_pay']=$ordermodel->where("user_id={$user_id} and pay_status=0")->count();//获取未付款条数
         $status_count['daiqueren']=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=1")->count();//获取待确认条数
         $status_count['daipingjia']=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=2")->count();//获取待评价条数
         $this->assign(status_count,$status_count);
         if(empty($status)){
             $selected['all']="selected='selected'";//选中下拉菜单的全部订单
             $this->assign(selected,$selected);
             $count=$ordermodel->where("user_id={$user_id}")->count();
             $this->assign(count,$count);
             $page=$this->get_page($count, 10);
             $page_foot=$page->show();//显示页脚信息
             $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.user_id={$user_id} and t1.goods_id=t2.goods_id")->field('t1.order_id,t1.goods_id,t1.goods_name,t1.server_day,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t2.price')->limit($page->firstRow.','.$page->listRows)->select();
             $this->assign('list',$list);
             $this->assign('page_foot',$page_foot);
         }else if($status==='no_pay'){
             $selected['no_pay']="selected='selected'";//选中下拉菜单的未付款
             $this->assign(selected,$selected);
             $selected['all']='selected';
             $count=$ordermodel->where("user_id={$user_id} and pay_status=0")->count();
             $page=$this->get_page($count, 10);
             $page_foot=$page->show();//显示页脚信息
             $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.user_id={$user_id} and t1.pay_status=0 and t1.goods_id=t2.goods_id")->field('t1.order_id,t1.goods_id,t1.goods_name,t1.server_day,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t2.price')->limit($page->firstRow.','.$page->listRows)->select();
             $this->assign('list',$list);
             $this->assign('page_foot',$page_foot);
         }else if($status==='daiqueren'){
             $selected['daiqueren']="selected='selected'";//选中下拉菜单的待确认
             $this->assign(selected,$selected);
             $count=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=1")->count();
             $page=$this->get_page($count, 10);
             $page_foot=$page->show();//显示页脚信息
             $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.user_id={$user_id} and t1.pay_status=1 and t1.status=1 and t1.goods_id=t2.goods_id")->field('t1.order_id,t1.goods_id,t1.goods_name,t1.server_day,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t2.price')->limit($page->firstRow.','.$page->listRows)->select();
             $this->assign('list',$list);
             $this->assign('page_foot',$page_foot);
         }else if($status==='daipingjia'){
             $selected['daipingjia']="selected='selected'";//选中下拉菜单的待评价
             $this->assign(selected,$selected);
             $count=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=2")->count();
             $page=$this->get_page($count, 10);
             $page_foot=$page->show();//显示页脚信息
             $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.user_id={$user_id} and t1.pay_status=1 and t1.status=2 and t1.goods_id=t2.goods_id")->field('t1.order_id,t1.goods_id,t1.goods_name,t1.server_day,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t2.price')->limit($page->firstRow.','.$page->listRows)->select();
             $this->assign('list',$list);
             $this->assign('page_foot',$page_foot);
         }
         
         
         
         $this->display('order');
    }
    
    

   
    //收藏列表
    public function sellection(){
        session('guanzhu',null); 
        $this->assign("title","一起网_我的收藏");
        $user_id=$_SESSION['wei_huiyuan']['user_id'];
        $sellectionmodel=D('Sellection');
        $count=$sellectionmodel->where("user_id=$user_id")->count();
        $page=$this->get_page($count, 10);
        $page_foot=$page->show();//显示页脚信息
        $this->assign('count',$count);
        $list=$sellectionmodel->table('m_sellection t1,m_goods t2')->where("t1.user_id=$user_id and t1.goods_id=t2.goods_id")->order('t1.add_time desc')->limit($page->firstRow.','.$page->listRows)->field('t1.sellection_id,t1.goods_id,t1.add_time,t2.goods_name,t2.goods_img,t2.tuan_price,t2.user_name,t2.tuan_number,t2.price')->select();
        $this->assign('list',$list);
        $this->assign('page_foot',$page_foot);
        $this->display('sellection');
    }
    //删除收藏
    public function sellection_del(){
        session('guanzhu',null); 
        $sellection_id=$_GET['sellection_id'];
        $sellectionmodel=D('Sellection');
        $user_id=$_SESSION['wei_huiyuan']['user_id'];
        $count=$sellectionmodel->where("sellection_id=$sellection_id and user_id=$user_id")->count();
        if($count==0){
            $this->error('非法操作',U($_SESSION['ref']),3);
            exit();
        }else{
            $sellectionmodel->where("sellection_id=$sellection_id")->delete();
        }
    }


    
    
   
    
    public function daijinquan(){
        session('guanzhu',null); 
        $user_id=$_SESSION['wei_huiyuan']['user_id'];//获取会员id号
        $usersmodel=D('Users');
        if(empty($user_id)||$user_id===0){
            $this->error('用户ID不存在!');
        }
        

        //$this->get_daijinquan($user_id, '通用券', 5);
        //$this->get_daijinquan($user_id, '通用券', 8);
        //$this->get_daijinquan($user_id, '通用券', 10);
        //$this->get_daijinquan($user_id, '通用券', 15);
        //$this->get_daijinquan($user_id, '通用券', 20);
        //$this->get_daijinquan($user_id, '通用券', 30);
        $daijinquan=$usersmodel->where("user_id={$user_id}")->getField('daijinquan');
        $arr_daijinquan=  unserialize($daijinquan);
        $this->assign('arr_daijinquan',$arr_daijinquan);
        $this->display('daijinquan');
    }
    
   
    
   
    
   
    
    
    
    
    
   
    
    
    public function address_tiaozhuan() {
        $a=urlencode("http://m.jiangzipinpin.com/Home/Member/address_manage");
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx91953340c19f656e&redirect_uri=".$a."&response_type=code&scope=snsapi_base&state=1#wechat_redirect";
        header("Location:{$url}"); 
        exit();

    }
    public function address_manage(){
        /*
        vendor('wxp.lib.WxPay#Api');
        vendor('wxp.example.WxPay#JsApiPay');
        $tools = new \JsApiPay();
        $editAddress = $tools->GetEditAddressParameters();
        $this->assign('signPackage',$editAddress);
        $this->display();*/
        
        if(isset($_GET['code'])){
           
		
            
            $code=$_GET['code'];
            $wangye=$this->get_wangye($code);
            $access_token=$wangye['access_token'];
            
            //$this->s_access_token();
            //$access_token=S('access_token');
            
            $appid=APPID;
            $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $nonceStr=$this->createNonceStr(32);
            $timeStamp=time();
            $timeStamp="$timeStamp";
             $data = array();
		$data["appid"] =$appid;
		$data["url"] = $url;
		$data["timestamp"] = $timeStamp;
		$data["noncestr"] = $nonceStr;
		$data["accesstoken"] = $access_token;
		ksort($data);
                $params = $this->ToUrlParams($data);
                $addrSign = sha1($params);
		
		$afterData = array(
			"addrSign" => $addrSign,
			"signType" => "sha1",
			"scope" => "jsapi_address",
			"appId" => $appid,
			"timeStamp" => $data["timestamp"],
			"nonceStr" => $data["noncestr"]
		);
		$parameters = json_encode($afterData);
            
            $this->assign('signPackage',$parameters);
            $this->display();
        }
    }
    private function get_wangye($code){
       $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".APPID."&secret=".APPSECRET."&code=".$code."&grant_type=authorization_code" ;
       $res = file_get_contents($url); //获取文件内容或获取网络请求的内容
       $result = json_decode($res, true);//接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
       return $result;
  }
  public function ToUrlParams($urlObj)
	{
		$buff = "";
		foreach ($urlObj as $k => $v)
		{
			if($k != "sign"){
				$buff .= $k . "=" . $v . "&";
			}
		}
		
		$buff = trim($buff, "&");
		return $buff;
    }

    
    public function qiehuanzhuanghu(){
        session('guanzhu',null); 
        $usersmodel=D(Users);
        $list=$usersmodel->select();
        $this->assign('list',$list);
        $this->display();
    }
    public function login(){
        $user_id=$_GET['user_id'];
        $usersmodel=D('Users');
        $user=$usersmodel->where("user_id=$user_id")->find();
        $_SESSION['huiyuan']=array(
                'user_id'=>$user['user_id'],
                'user_name'=>$user['user_name'],
                'open_id'=>$user['open_id']
                 );
        $this->redirect('Index/index',0);
    }


            
}


