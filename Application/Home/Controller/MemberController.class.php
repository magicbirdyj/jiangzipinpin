<?php
namespace Home\Controller;
use Home\Controller;
class MemberController extends FontEndController {
    public function index(){
        //是否有店铺
        $open_id=$_SESSION['wei_huiyuan']['open_id'];
        $shopsmodel=D('Shops');
        $is_shop=$shopsmodel->where("open_id='$open_id'")->count();
        $this->assign('is_shop',$is_shop);
        
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
        $status_count['daifahuo']=$ordermodel->where("user_id={$user_id} and pay_status=1 and (status=2 or (tuan_no=0 and status=1)) and deleted=0")->count();//获取待发货条数
        $status_count['daishouhuo']=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=3 and deleted=0")->count();//获取待收货条数
        $status_count['daipingjia']=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=4 and deleted=0")->count();//获取待评价条数
        $status_count['shouhou']=$ordermodel->where("user_id={$user_id} and pay_status>1 and deleted=0")->count();//获取售后条数
        
        
        //店铺订单
        if($is_shop){
            $shop_id=$shopsmodel->where("open_id='$open_id'")->getField('shop_id');
            $status_count['shop_all']=$ordermodel->where("shop_id={$shop_id} and deleted=0")->count();//获取全部订单条数
            $status_count['shop_daifahuo']=$ordermodel->where("shop_id={$shop_id} and pay_status=1 and status=1 and deleted=0")->count();//获取待发货条数
            $status_count['shop_shouhou']=$ordermodel->where("shop_id={$shop_id} and pay_status>1 and pay_status<4 and deleted=0")->count();//获取售后申请条数
            
            //所有已经上架的商品数量
            $goodsmodel=D('Goods');
            $goods_count=$goodsmodel->where("shop_id={$shop_id} and is_delete=0")->count();
            $this->assign('goods_count',$goods_count);
        }
        
        
         
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
        $user_id=$_SESSION['wei_huiyuan']['user_id'];
        $sellectionmodel=D('Sellection');
        $count=$sellectionmodel->where("user_id=$user_id")->count();
        $page=$this->get_page($count, 10);
        $page_foot=$page->show();//显示页脚信息
        $this->assign('count',$count);
        $list=$sellectionmodel->table('m_sellection t1,m_goods t2')->where("t1.user_id=$user_id and t1.goods_id=t2.goods_id")->order('t1.add_time desc')->limit($page->firstRow.','.$page->listRows)->field('t1.sellection_id,t1.goods_id,t1.add_time,t2.goods_name,t2.goods_img,t2.tuan_price,t2.shop_name,t2.tuan_number,t2.price')->select();
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

        $daijinquan=$usersmodel->where("user_id={$user_id}")->getField('daijinquan');
        $arr_daijinquan=  unserialize($daijinquan);
        $this->assign('arr_daijinquan',$arr_daijinquan);
        $this->display('daijinquan');
    }
    
   

    
    public function address_manage(){
        if(isset($_GET['code'])){
            $code=$_GET['code'];
            $parameters=$this->get_address_data($code);
            $this->assign('signPackage',$parameters);
            $usersmodel=D('Users');
            $open_id=$_SESSION['wei_huiyuan']['open_id'];
            $user=$usersmodel->where("open_id='$open_id'")->field("address,default_address")->find();
            
            if($user['address']!=''){
                $arr_address=  unserialize($user['address']);
            }else{
                $arr_address='';
            }
            $this->assign('arr_address',$arr_address);
            $this->assign('default_address',$user['default_address']);
            $this->assign('open_id',$open_id);
            $this->display();
        }

    }
    
   
    
    private function get_address_data($code){
            $wangye=$this->get_wangye($code);
            //同时相当于伪登陆
            $row=array(
                 'open_id'=>$wangye['openid'],
                );
            $_SESSION['wei_huiyuan']=$row;
            
            $access_token=$wangye['access_token'];//共享收货地址必须使用网页授权access_token
            
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
                return $parameters;
    }
    
    //设置默认地址 ajax用
    public function shezhi_moren_address(){
        $data=$_POST;
        if(($data['open_id']!=$_SESSION['wei_huiyuan']['open_id'])||$data['check']!='shezhi_moren'){
            exit;
        }
        $open_id=$data['open_id'];
        $item=$data['item'];
        $usersmodel=D('Users');
        $row=array('default_address'=>$item);
        $result=$usersmodel->where("open_id=$open_id")->save($row);
        $this->ajaxReturn($result);
    }
    
    
    //保存地址 ajax用
    public function save_or_add_address(){
        $data=$_POST;
        if(($data['open_id']!=$_SESSION['wei_huiyuan']['open_id'])||($data['check']!='save'&&$data['check']!='add')){
            exit;
        }
        $open_id=$data['open_id'];
        $usersmodel=D('Users');
        $address=$usersmodel->where("open_id='$open_id'")->getField('address');
        $arr_address=  unserialize($address);
        
        $arr_data=array(
            'name'=>$data['name'],
            'mobile'=>$data['mobile'],
            'location'=>$data['location'],
            'address'=>$data['address']
        );
        if($data['check']=='save'){
            $arr_address[(int)$data['id']]=$data;
        }elseif($data['check']=='add'){
            $arr_address[]=$data;
        }
        $address=  serialize($arr_address);
        $row=array('address'=>$address);
        $result=$usersmodel->where("open_id='$open_id'")->save($row);
        $this->ajaxReturn($result);
    }
    //删除地址 ajax用
    public function delete_address() {
        $data=$_POST;
        if(($data['open_id']!=$_SESSION['wei_huiyuan']['open_id'])||$data['check']!='del_address'){
            exit;
        }
        $open_id=$data['open_id'];
        $usersmodel=D('Users');
        $address=$usersmodel->where("open_id='$open_id'")->field('address,default_address')->find();
        $arr_address=  unserialize($address['address']);
        $length=count($arr_address);
        $int_id=(int)$data['id'];
        array_splice($arr_address,$int_id, 1);
        $address['address']=  serialize($arr_address);
        $row=array('address'=>$address['address']);
        if($int_id<=$address['default_address']){
            $row['default_address']=$address['default_address']-1;
        }
        $result=$usersmodel->where("open_id='$open_id'")->save($row);
        $this->ajaxReturn($row['default_address']);
    }
    private function get_wangye($code){
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".APPID."&secret=".APPSECRET."&code=".$code."&grant_type=authorization_code" ;
        $res = file_get_contents($url); //获取文件内容或获取网络请求的内容
        $result = json_decode($res, true);//接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
        //S('wangye_access_token',$result['access_token'],7000);
        return $result;
  }
  

  private function ToUrlParams($urlObj)
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

    /*
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
*/

            
}


