<?php

namespace Home\Controller;

use Home\Controller;

class GoodsController extends FontEndController {
    public function index() {
        //首先必须获取关注状态
        if (isset($_SESSION['huiyuan']) &&$_SESSION['huiyuan'] != '') {
                $_SESSION['wei_huiyuan']=$_SESSION['huiyuan'];
                }
        if (!isset($_SESSION['wei_huiyuan']) || $_SESSION['wei_huiyuan'] == ''||!isset($_SESSION['guanzhu'])||$_SESSION['guanzhu']=='') {
            header("location:". U("Login/wei_index"));
            exit();
        }
        
        
        if(!isset($_SESSION['guanzhu'])||$_SESSION['guanzhu']==''){
            $this->error('关注信息为空');
        }
        C('TOKEN_ON',false);//取消表单令牌
        
        $goods_id = $_GET['goods_id'];
        if(!$goods_id){
            $this->error('该商品不存在！', '/Home/Index/index');
        }
        $this->assign('goods_id', $goods_id);
        $goodsmodel = D('Goods');
        $goods = $goodsmodel->where("goods_id='$goods_id'")->field('goods_id,goods_name,goods_jianjie,price,yuan_price,tuan_price,goods_img,goods_img_qita,goods_desc,comment_number,shuxing,score,cat_name,shop_id,shop_name,daijinquan,1yuangou,choujiang,is_delete,buy_number,tuan_number,goods_shuxing')->find();
        if($goods['is_delete']==='1'||!$goods){
            $this->error('该商品不存在！', '/Home/Index/index');
        }
        //获取到店铺信息
        $shopsmodel=D('Shops');
        $shop_id=$goods['shop_id'];
        $shop=$shopsmodel->where("shop_id=$shop_id")->field('shop_id,qq,head_url,tel,sale_number,status')->find();
        $this->assign('shop',$shop);
        //把价格后面无意义的0去掉
        $goods['price']= floatval($goods['price']);
        $goods['yuan_price']= floatval($goods['yuan_price']);
        $goods['tuan_price']= floatval($goods['tuan_price']);

        //把商品id赋值给cookie 并且永久保存.
        if (is_shuzi($goods_id)) {
            $arr_goods_id = cookie('distory_goods_id') == '' ? array() : cookie('distory_goods_id');
            $is_in = in_array($goods_id, $arr_goods_id);
            if ($is_in === false) {
                if (count($arr_goods_id) > 10) {
                    array_shift($arr_goods_id);
                }
                array_push($arr_goods_id, $goods_id);
                cookie('distory_goods_id', $arr_goods_id, 2419200); //保存到cookie中一个月
            }
        } else {
            $this->error('发生错误：商品id不正确!', 'Index/index');
        }

        $goods['url']['url'] = urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        $goods['url']['goods_name'] = urlencode('酱紫拼拼-' . $goods['cat_name'] . '-' . $goods['goods_name']);
        $goods['url']['goods_img'] = urlencode('http://www.pingogo.net' . $goods['goods_img']);
        $goods['url']['summary'] = urlencode('酱紫拼拼，拼实惠，拼乐趣。' . '-' . $goods['goods_name']);
        $this->assign('goods', $goods);
        //获取该商品的团长信息(最早的2个团)
        $ordermodel=D('Order');
        $end=time()-86400;
        $goods_tuan=$ordermodel->table('m_order t1,m_users t2')->where("t1.goods_id=$goods_id and t1.identity=1 and t1.user_id=t2.user_id and t1.created>$end and t1.status=1 and pay_status=1")->field('t2.head_url,t1.order_id,t2.user_name,t1.created,t2.address,t1.order_address,t1.tuan_no,t1.goods_id,t1.tuan_number')->order('t1.created')->limit(2)->select();
        if($goods_tuan[0]){
            foreach ($goods_tuan as $key=>$value) {
                $tuan_no=$value['tuan_no'];
                $count=$ordermodel->where("tuan_no=$tuan_no and pay_status>0")->count();
                $tuan_number=$value['tuan_number'];
                $goods_tuan[$key]['count']=$tuan_number-$count;
            }
        }else{
            $goods_tuan=NULL;
        }
        $this->assign('goods_tuan',$goods_tuan);
        $img_qita = unserialize($goods['goods_img_qita']); //获取其它展示图数组
        $this->assign('img_qita', $img_qita);
        $shuxing = unserialize($goods['shuxing']); //获取商品属性数组
        $this->assign('shuxing', $shuxing);
        //获取具体分项目评分
        $pingfen = $ordermodel->where("goods_id={$goods_id}")->getField('pingfen', true);
        foreach ($pingfen as $value) {
            $value = unserialize($value);
            $pingfen0+=$value[0];
            $pingfen1+=$value[1];
            $pingfen2+=$value[2];
        }
        $pingfen_fl[] = number_format($pingfen0 / count($pingfen), 1);
        $pingfen_fl[] = number_format($pingfen1 / count($pingfen), 1);
        $pingfen_fl[] = number_format($pingfen2 / count($pingfen), 1);
        $this->assign('pingfen_fl', $pingfen_fl);
       
        

        //获取广告商品列表
        //$guanggao = $goodsmodel->where("cat_id={$goods['cat_id']}")->order('advert_shop_order')->limit(12)->field('goods_id,goods_name,goods_img,price,buy_number')->select();
        //$this->assign('guanggao', $guanggao);


        //找出该商品是否被用户收藏了
        $sellectionmodel = D('Sellection');
        
        $user_id = $_SESSION['huiyuan']?$_SESSION['huiyuan']['user_id']:$_SESSION['wei_huiyuan']['user_id'];
        
        $is_sellect = $sellectionmodel->where("goods_id=$goods_id and user_id=$user_id")->find();
        $sellection_count = $sellectionmodel->where("user_id=$user_id")->count();
        $this->assign('sellection_count', $sellection_count);
        
        $this->assign('is_sellect', $is_sellect);
        //该商品被收藏了多少次
        //$sellection_count = $sellectionmodel->where("goods_id=$goods_id")->count();
        //$this->assign('sellection_count', $sellection_count);
        
        //商品自选属性
        $arr_zx_shuxing=  unserialize($goods['goods_shuxing']);
        $this->assign('zx_shuxing',$arr_zx_shuxing);

        $this->assign("title", "酱紫拼拼—". $goods['goods_name']); //给标题赋值

         
         //1元购的商品，如果用户已经获取过该商品购买资格，不能再开团或者参团
         if($goods['1yuangou']==1||$goods['choujiang']==1){
            $choujiang=$ordermodel->where("user_id=$user_id and goods_id=$goods_id and choujiang=1")->count();
            if($choujiang>0){
                $this->assign('is_get','yijing_get');//分配变量给JS用 对已经获取过该活动商品的用户 开团按钮失效
            }
         }
          //查看页面是否有$_SESSION  guanzhu='weiguanzhu'  有的话，弹出关注框(给js用)
          $this->assign('guanzhu',$_SESSION['guanzhu']);
          //如果未关注，把$_SESSION['ref']  写入数据表
          
          //获得评论list
          $list_pinglun=$this->get_pinglun($goods_id);
          $this->assign('list_pinglun',$list_pinglun);
          
          if($_SESSION['guanzhu']=='weiguanzhu'){
               $this->save_url(substr($_SESSION['ref'],0,strpos($_SESSION['ref'],'?')));
          }
          session('guanzhu',null); 
          $this->display('index');
          //让商品的点击次数加1
         $goodsmodel->where("goods_id='$goods_id'")->setInc('click_count');
    }

    public function get_pinglun($goods_id) {
        $ordermodel = D('Order');
        $list_pinglun = $ordermodel->table('m_order t1,m_users t2')->where("t1.goods_id={$goods_id} and t1.user_id=t2.user_id and t1.status=5")->field('t1.updated,t1.score,t1.appraise_img,t1.appraise,t1.appraise_img,t2.user_name,t2.head_url')->order('t1.updated desc')->select();
        //遍历数组，把img字段反序列化
        foreach ($list_pinglun as &$value) {
            $value['appraise_img'] = unserialize($value['appraise_img']);
        }
        return $list_pinglun;
    }

    public function page() {
        $goods_id = $_GET['goods_id'];
        $goodsmodel = D('Goods');
        //$goods=$goodsmodel->table('m_goods t1,m_users t2,m_category t3')->where("t1.user_id=t2.user_id and t1.goods_id=$goods_id and t1.cat_id=t3.cat_id")->field('t1.goods_id,t1.area,t1.goods_name,t1.price,t1.yuan_price,t1.goods_img,t1.goods_img_qita,t1.goods_sex,t1.goods_desc,t1.comment_number,t1.shuxing,t3.cat_name,t2.user_name,t1.user_id,t2.weixin,t2.qq,t2.mobile_phone,t2.email')->find();
        $goods = $goodsmodel->where("goods_id=$goods_id")->field('user_id')->find();
        $user_id = $goods['user_id'];
        $count = $goodsmodel->where("user_id=$user_id and is_delete=0")->count();
        $page = $this->get_page($count, 5);
        $page_foot = $page->show(); //显示页脚信息
        $goods_qita = $goodsmodel->table('m_goods t1,m_category t2')->where("t1.cat_id=t2.cat_id and t1.user_id=$user_id  and t1.is_delete=0")->limit($page->firstRow . ',' . $page->listRows)->order('t1.last_update desc')->field('t2.cat_name,t1.goods_name,t1.price,t1.yuan_price,t1.goods_id,t1.buy_number')->select();
        $data['li'] = $goods_qita;
        $data['page_foot'] = $page_foot;
        $this->ajaxReturn($data);
    }

    public function dandu_buy() {
        if(isset($_GET['code'])){//微信地址接口
            $code=$_GET['code'];
            $parameters=$this->get_address_data($code);
            $this->assign('signPackage',$parameters);
            $open_id=$_SESSION['wei_huiyuan']['open_id'];
            $this->assign('open_id',$open_id);
           
        }//微信地址接口
        $user_id=$_SESSION['huiyuan']['user_id'];
        $usersmodel=D('Users');
        $address=$usersmodel->where("user_id=$user_id")->field('address,default_address,daijinquan')->find();
        if($address['address']!=''){
                $arr_address=  unserialize($user['address']);
            }else{
                $arr_address='';
            }
        $this->assign('arr_address',$arr_address);
        $default=$address['default_address'];
        
        $default_address=$arr_address[$default];
        $this->assign('default_Address',$default_address);
        $goods_id=$_GET['goods_id'];
        if($_GET['zx_shuxing']){
            $zx_shuxing=$_GET['zx_shuxing'];
            $this->assign('zx_shuxing',$zx_shuxing);
        }
        $goodsmodel=D('Goods');
        $goods=$goodsmodel->where("goods_id=$goods_id")->find();
        $goods['ky_daijinquan']=0;
        $this->assign('goods',$goods);
        //用户代金券
        $arr_daijinquan=  unserialize($address['daijinquan']);
        $time=  time();
        if($arr_daijinquan){
            foreach ($arr_daijinquan as $value) {
                if($value['guoqi']>$time){
                    $youxiao_daijinquan[]=$value;
                }
            }
        }
        $this->assign('youxiao_daijinquan',$youxiao_daijinquan);
        $this->display();
    }
    public function kaituan_buy() {
        $user_id=$_SESSION['huiyuan']['user_id'];
        $goods_id=$_GET['goods_id'];
        if(!$goods_id){
            $this->error("商品ID不存在");
        }
        //1元购的商品，如果用户已经获取过该商品购买资格，不能再开团或者参团
        $ordermodel=D('Order');
        $choujiang=$ordermodel->where("user_id=$user_id and goods_id=$goods_id and choujiang=1")->count();
        if($choujiang>0){
            $this->error("您已经成功获取过该活动商品，无法再重复参加活动");
        }
        
        $usersmodel=D('Users');
        $address=$usersmodel->where("user_id=$user_id")->field('address,default_address,daijinquan')->find();
        $arr_address=  unserialize($address['address']);
        $default=$address['default_address'];
        $default_address=$arr_address[$default];
        $this->assign('default_Address',$default_address);
        
        
        if($_GET['zx_shuxing']){
            $zx_shuxing=$_GET['zx_shuxing'];
            $this->assign('zx_shuxing',$zx_shuxing);
        }
        $goodsmodel=D('Goods');
        $goods=$goodsmodel->where("goods_id=$goods_id")->find();
        $this->assign('goods',$goods);
        //用户代金券
        $arr_daijinquan=  unserialize($address['daijinquan']);
        $time=  time();
        if($arr_daijinquan){
            foreach ($arr_daijinquan as $value) {
                if($value['guoqi']>$time){
                    $youxiao_daijinquan[]=$value;
                }
            }
        }
        $this->assign('youxiao_daijinquan',$youxiao_daijinquan);
        $this->display();
    }
    public function cantuan_buy() {
        $user_id=$_SESSION['huiyuan']['user_id'];
        $tuan_no=$_GET['tuan_no'];
        if(!$tuan_no){
            $this->error("参团订单ID不存在");
        }
        //1元购的商品，如果用户已经获取过该商品购买资格，不能再开团或者参团
        $ordermodel=D(Order);
        $order=$ordermodel->where("order_id=$tuan_no and deleted=0 and status=1")->find();
        if(!$order){
            $this->redirect('Goods/pintuan_info',array('tuan_no'=>$tuan_no));
            exit;
        }
        $goods_id=$order['goods_id'];
        $choujiang=$ordermodel->where("user_id=$user_id and goods_id=$goods_id and choujiang=1")->count();
        if($choujiang>0){
            $this->error("您已经购买成功过该活动商品，无法再重复参加活动");
        }
        
        
        if($_GET['zx_shuxing']){
            $zx_shuxing=$_GET['zx_shuxing'];
            $this->assign('zx_shuxing',$zx_shuxing);
        }
        
        $usersmodel=D('Users');
        $address=$usersmodel->where("user_id=$user_id")->field('address,default_address,daijinquan')->find();
        $arr_address=  unserialize($address['address']);
        $default=$address['default_address'];
        $default_address=$arr_address[$default];
        $this->assign('default_Address',$default_address);
        
        ;
        
        
        $cunzai_order=$ordermodel->where("tuan_no=$tuan_no and user_id=$user_id and status='1' and deleted='0'")->field('order_id,pay_status')->find();
        if($cunzai_order&&$cunzai_order['pay_status']==0){
            $this->redirect('Goods/zhifu',array('order_id'=>$cunzai_order['order_id']));
        }elseif($cunzai_order){
            $this->error('您已经参加该团',$_SESSION['ref']);
        }
        
        $goodsmodel=D('Goods');
        $goods=$goodsmodel->where("goods_id=$goods_id")->find();
        $goods['tuan_price']=$order['price'];
        $goods['ky_daijinquan']=0;
        $goods['tuan_no']=$tuan_no;
        $this->assign('goods',$goods);
        //用户代金券
        $arr_daijinquan=  unserialize($address['daijinquan']);
        $time=  time();
        if($arr_daijinquan){
            foreach ($arr_daijinquan as $value) {
                if($value['guoqi']>$time){
                    $youxiao_daijinquan[]=$value;
                }
            }
        }
        $this->assign('youxiao_daijinquan',$youxiao_daijinquan);
        $this->display();
    }
    public function pintuan_info(){
        //首先必须获取关注状态
        if (isset($_SESSION['huiyuan']) &&$_SESSION['huiyuan'] != '') {
                $_SESSION['wei_huiyuan']=$_SESSION['huiyuan'];
                }
        if (!isset($_SESSION['wei_huiyuan']) || $_SESSION['wei_huiyuan'] == ''||!isset($_SESSION['guanzhu'])||$_SESSION['guanzhu']=='') {
            header("location:". U("Login/wei_index"));
            exit();
        }
        
        
        $this->assign('title','拼团详情');
        $this->assign('is_ztcg','ddct');//组团状态
        $tuan_no=$_GET['tuan_no'];
        if(!$tuan_no){
            $this->error("参团订单ID不存在");
        }
        $this->assign('tuan_no',$tuan_no);
        $user_id=$_SESSION['wei_huiyuan']['user_id'];
        
         //1元购的商品，如果用户已经获取过该商品购买资格，不能再开团或者参团
        $ordermodel=D(Order);
        $order=$ordermodel->where("order_id=$tuan_no and deleted=0")->find();
        if(!$order){
            $this->error('该团不存在');
        }
        $goods_id=$order['goods_id'];
        $goodsmodel=D('Goods');
        $goods=$goodsmodel->where("goods_id=$goods_id")->find();
        if($goods['1yuangou']==1||$goods['choujiang']==1){
            $choujiang=$ordermodel->where("user_id=$user_id and goods_id=$goods_id and choujiang=1")->count();
            //如果组团成功过该活动商品的团购，但是未获奖，也无法再参团 只能重新开团
            $tiaojian['status']=array('between','2,5');
            $is_ctcg=$ordermodel->where("user_id=$user_id and goods_id=$goods_id and identity=0 and choujiang=0")->where($tiaojian)->count();
        }else{
            $choujiang=0;
            $is_ctcg=0;
        }
        // 把抽奖assign 页面判断 如果大于0 将不再显示参团按钮 而是现实您已经成功购买过该活动商品，返回按钮
        $this->assign('choujiang',$choujiang);
        $this->assign('is_ctcg',$is_ctcg);

        $cunzai_order=$ordermodel->where("tuan_no=$tuan_no and user_id=$user_id  and status='1' and deleted='0'")->field('order_id,pay_status')->find();
        if($cunzai_order&&$cunzai_order['pay_status']==0){
            $this->redirect('Goods/zhifu',array('order_id'=>$cunzai_order['order_id']),0);//已经参加该团 未付款
            exit();
        }elseif($cunzai_order){
            $this->redirect('Goods/gmcg_wx',array('order_id'=>$cunzai_order['order_id']),0);//已经参加该团 并且支付成功
            exit();
        }
        if($order['pay_status']!='1'){
            $this->error('该团购因团长未付款，无法参团');
        }
        
        
        $goods['tuan_number']=$order['tuan_number'];//几人团以订单为准
        $tuanzhang_id=$order['user_id'];
        $usersmodel=D('Users');
        $tuanzhang=$usersmodel->where("user_id=$tuanzhang_id")->field('head_url,user_name')->find();
        $goods['tuanzhang_head_url']=$tuanzhang['head_url'];
        $goods['tuanzhang_user_name']=$tuanzhang['user_name'];    
        $goods['tuanzhang_created']=$ordermodel->where("order_id=$tuan_no")->getField("created");
        $tuanyuan=$ordermodel->table('m_order t1,m_users t2')->where("t1.user_id=t2.user_id and t1.tuan_no=$tuan_no and t1.identity=0 and t1.pay_status>0")->field('t2.head_url,t2.user_name,t1.created')->select();
        if(!$tuanyuan[0]){
            $tuanyuan_head_url=NULL;
        }
        $this->assign('tuanyuan',$tuanyuan);
        $this->assign('tuanyuan_count',count($tuanyuan));
        $goods['count']=$ordermodel->where("tuan_no=$tuan_no and pay_status>0")->count();
        if($goods['tuan_number']<=$goods['count']){
            //组团成功
            $this->assign('is_ztcg','ztcg');
        }else{
            if($order['status']=='6'){
                //组团失败
                $this->assign('is_ztcg','ztsb'); 
            }else{
                $time=  time();
                if($time-(int)$goods['tuanzhang_created']>=86400){
                    //组团失败
                    $this->assign('is_ztcg','ztsb');
                }
            }
        }
        $this->assign('goods', $goods);
        

        $arr_zx_shuxing=  unserialize($goods['goods_shuxing']);
         
        
        
        //查看页面是否有$_SESSION  guanzhu='weiguanzhu'  有的话，弹出关注框(给js用)
        $this->assign('guanzhu',$_SESSION['guanzhu']);
        //如果未关注，把$_SESSION['ref']  写入数据表
          
        if($_SESSION['guanzhu']=='weiguanzhu'){
            $this->save_url(substr($_SESSION['ref'],0,strpos($_SESSION['ref'],'?')));
        }
        session('guanzhu',null); 
        $this->display();
    }
    
    public function dandu_buy_success(){
        $ordermodel = D('Order');
        // 手动进行令牌验证 
        if (!$ordermodel->autoCheckToken($_POST)){ 
            if($_COOKIE['order_id']){
                $order_id=$_COOKIE['order_id'];//一个小时内重复提交订单，进入支付页面
                $this->redirect('Goods/zhifu',"order_id=$order_id");
            }else{
                $this->error('不能重复提交订单',U('Order/index'));
            }
            exit();
        }
        $user_id = $_SESSION['huiyuan']['user_id'];
        $goods_id = $_POST['goods_id'];
        $price=$_POST['price'];
        $ky_daijinquan=$_POST['ky_daijinquan'];
        $dues=$_POST['dues'];
        $order_address=$_POST['order_address'];
        if($_POST['zx_shuxing']){
            $zx_shuxing=$_POST['zx_shuxing'];
        }else{
            $zx_shuxing="";
        }
        $buy_number=$_POST['buy_number'];
        $goodsmodel = D('Goods');
        $goods=$goodsmodel->where("goods_id=$goods_id")->find();

        $row = array(
            'user_id' => $user_id,
            "order_no" => $this->getUniqueOrderNo(),
            'goods_id' => $goods_id,
            'buy_number'=>$buy_number,
            'zx_shuxing'=>$zx_shuxing,
            'shop_name' => $goods['shop_name'],
            'goods_name' => $goods['goods_name'],
            'order_fahuo_day'=>$goods['fahuo_day'],
            'status' => 1, //生成订单
            'pay_status' => 0, //支付状态为未支付
            'created' => mktime(),
            'updated' => mktime(),
            'price' => $price,
            'daijinquan'=>ky_daijinquan,
            'dues'=>$dues,
            'order_address'=>$order_address
        );
        $result = $ordermodel->add($row); //订单信息写入数据库order表
            if(!$result){
                $this->error('订单提交失败，请重新提交', $_SERVER['HTTP_REFERER'], 3);
            }
            //如果用了代金券 数据库中删除该代金券
            if($ky_daijinquan!=0){
                $shanchu_daijinquan=$this->use_daijinquan($user_id, $ky_daijinquan);
                if(!$shanchu_daijinquan){
                    $this->error('跟新代金券出错!');
                }
            }
            cookie('order_id',$result,36000);
            $this->redirect('Goods/zhifu',array('order_id'=>$result));
        
    }

    public function kaituan_success(){
        $ordermodel = D('Order');
        // 手动进行令牌验证 
        if (!$ordermodel->autoCheckToken($_POST)){ 
            if($_COOKIE['order_id']){
                $order_id=$_COOKIE['order_id'];//一个小时内重复提交订单，进入支付页面
                $this->redirect('Goods/zhifu',"order_id=$order_id");
            }else{
                $this->error('不能重复提交订单',U('Order/index'));
            }
            exit();
        }
        $user_id = $_SESSION['huiyuan']['user_id'];
        $goods_id = $_POST['goods_id'];
        
        
        
        //1元购的商品，如果用户已经获取过该商品购买资格，不能再开团或者参团
        $choujiang=$ordermodel->where("user_id=$user_id and goods_id=$goods_id and choujiang=1")->count();
        if($choujiang>0){
            $this->error("您已经成功获取过该活动商品，无法再重复参加活动");
        }
        
        $price=$_POST['price'];
        $ky_daijinquan=$_POST['ky_daijinquan'];
        $dues=$_POST['dues'];
        $order_address=$_POST['order_address'];
        if($_POST['zx_shuxing']){
            $zx_shuxing=$_POST['zx_shuxing'];
        }else{
            $zx_shuxing="";
        }
        $buy_number=$_POST['buy_number'];
        $goodsmodel = D('Goods');
        $goods=$goodsmodel->where("goods_id=$goods_id")->find();
        

        $row = array(
            'user_id' => $user_id,
            "order_no" => $this->getUniqueOrderNo(),
            'goods_id' => $goods_id,
            'buy_number'=>$buy_number,
            'zx_shuxing'=>$zx_shuxing,
            'tuan_number'=>$goods['tuan_number'],
            'order_fahuo_day'=>$goods['fahuo_day'],
            'identity'=>1,
            'shop_name' => $goods['shop_name'],
            'goods_name' => $goods['goods_name'],
            'status' => 1, //生成订单
            'pay_status' => 0, //支付状态为未支付
            'created' => mktime(),
            'updated' => mktime(),
            'price' => $price,
            'daijinquan'=>ky_daijinquan,
            'dues'=>$dues,
            'order_address'=>$order_address
        );
        $result = $ordermodel->add($row); //订单信息写入数据库order表
        
        if ($result) {
            $row=array(
                'tuan_no'=>$result
            );
            $save=$ordermodel->where("order_id=$result")->save($row);
            if(!$save){
                $this->error('订单提交失败，请重新提交', $_SERVER['HTTP_REFERER'], 3);
            }
            //如果用了代金券 数据库中删除该代金券
            if($ky_daijinquan!=0){
                $shanchu_daijinquan=$this->use_daijinquan($user_id, $ky_daijinquan);
                if(!$shanchu_daijinquan){
                    $this->error('跟新代金券出错!');
                }
            }

            cookie('order_id',$result,36000);
            $this->redirect('Goods/zhifu',array('order_id'=>$result));
        } else {
            $this->error('订单提交失败，请重新提交', $_SERVER['HTTP_REFERER'], 3);
        }
    }
    public function cantuan_success(){
        $ordermodel = D('Order');
        // 手动进行令牌验证 
        if (!$ordermodel->autoCheckToken($_POST)){ 
            if($_COOKIE['order_id']){
                $order_id=$_COOKIE['order_id'];//一个小时内重复提交订单，进入支付页面
                $this->redirect('Goods/zhifu',"order_id=$order_id");
            }else{
                $this->error('不能重复提交订单',U('Order/index'));
            }
            exit();
        }
        $user_id = $_SESSION['huiyuan']['user_id'];
        $tuan_no=$_POST['tuan_no'];
        $order=$ordermodel->where("order_id=$tuan_no")->find();
        
        
        //如果组团成功过该活动商品的团购，就无法再参团 
        $goods_id=$order['goods_id'];
        $goodsmodel=D('Goods');
        $goods=$goodsmodel->where("goods_id=$goods_id")->find();
        if($goods['1yuangou']==1||$goods['choujiang']==1){
            ///如果组团成功过该活动商品的团购，就无法再参团 
            $tiaojian['status']=array('between','2,5');
            $is_ctcg=$ordermodel->where("user_id=$user_id and goods_id=$goods_id")->where($tiaojian)->count();
            if($is_ctcg>0){
                $this->error('您已经组团成功过该商品，无法重复参加活动。');
            }
        }
        
        
        $ky_daijinquan=$_POST['ky_daijinquan'];
        $dues=$_POST['dues'];
        $order_address=$_POST['order_address'];
        $buy_number=$_POST['buy_number'];
        if($_POST['zx_shuxing']){
            $zx_shuxing=$_POST['zx_shuxing'];
        }else{
            $zx_shuxing="";
        }
      
        

        $row = array(
            'user_id' => $user_id,
            "order_no" => $this->getUniqueOrderNo(),
            'goods_id' => $order['goods_id'],
            'zx_shuxing'=>$zx_shuxing,
             'buy_number'=>$buy_number,
            'tuan_number'=>$order['tuan_number'],
            'order_fahuo_day'=>$order['order_fahuo_day'],
            'tuan_no'=>$tuan_no,
            'identity'=>0,
            'shop_name' => $order['shop_name'],
            'goods_name' => $order['goods_name'],
            'status' => 1, //生成订单
            'pay_status' => 0, //支付状态为未支付
            'created' => mktime(),
            'updated' => mktime(),
            'price' => $order['price'],
            'daijinquan'=>ky_daijinquan,
            'dues'=>$dues,
            'order_address'=>$order_address
        );
        $result = $ordermodel->add($row); //订单信息写入数据库order表
        
        if ($result) {
            //如果用了代金券 数据库中删除该代金券
            if($ky_daijinquan!=0){
                $shanchu_daijinquan=$this->use_daijinquan($user_id, $ky_daijinquan);
                if(!$shanchu_daijinquan){
                    $this->error('跟新代金券出错!');
                }
            }
            cookie('order_id',$result,36000);
            $this->redirect('Goods/zhifu',array('order_id'=>$result));
            
        } else {
            $this->error('订单提交失败，请重新提交', $_SERVER['HTTP_REFERER'], 3);
        }
    }

    public function zhifu() {
        $user_id = $_SESSION['huiyuan']['user_id'];
        $order_id = $_GET['order_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='{$order_id}'")->find();
        $order_user_id = $order['user_id']; //登录用户无该订单权限
        if ($order_user_id != $user_id) {//登录用户无该订单权限
            $this->error('您没有该订单权限');
        }
        if($order['status']!=1||$order['deleted']==1){
            $this->error('该订单状态已无法付款');
        }
        if($order['pay_status']!=0){
            $this->error('该订单已经付款');
        }
        $goods_id=$order['goods_id'];
        $goodsmodel=D(Goods);
        $goods_delete=$goodsmodel->where("goods_id=$goods_id")->getField('is_delete');
        if($goods_delete==1){
            $this->error('该商品已经下架');
        }
        $tuan_no=$order['tuan_no'];
        if($tuan_no!=0){
            $created=$ordermodel->where("order_id=$tuan_no")->getField('created');
            $count=$ordermodel->where("tuan_no=$tuan_no and pay_status >0")->count();
            if(($created+86400)<  time()||$count>=$order['tuan_number']){
                $row=array(
                    'status'=>7//取消订单
                );
                $ordermodel->where("order_id=$order_id")->save($row);
                $this->error('该团购已过期或者已成团,无法再付款',$_SESSION['ref'],2);
            }

        }
        
        $this->assign('order',$order);
       
        $this->alipay($order_id);
       
    }

    /**
     * 生成唯一的订单号 会查询订单表来保证唯一性
     * 
     */
    private function getUniqueOrderNo() {
        $code = getname();
        $OrderModel = D("Order");
        $res = $OrderModel->where("order_no='{$code}' and deleted=0")->find();
        if ($res) {
            $this->getUniqueOrderNo();
        }
        return $code;
    }

    //生成微信支付订单
    private function alipay($order_id) {
        $ordermodel = D('Order');
        $order = $ordermodel->where("order_id=$order_id and deleted=0 ")->find();
        //微信
        $user_id=$order['user_id'];
        $usersmodel=D('Users');
        $open_id=$usersmodel->where("user_id=$user_id")->getField('open_id');
        $paydata=array(
            'body'=>sprintf("酱紫拼拼：商铺名：%s 商品名：%s",  mb_substr($order['shop_name'], 0, 10, 'utf-8'),  mb_substr($order['goods_name'], 0, 25, 'utf-8')),
            'total_fee'=>$order['dues'],
            'notify'=>PAY_HOST . U("Goods/notifyweixin"),
            'shop_name'=>$order['shop_name'],
            'order_no'=>$order['order_no'],
            'goods_id'=>$order['goods_id'],
            'open_id'=>$open_id,
            'goods_name'=> $order['goods_name'],
            'order_id'=>$order_id
        );
        if(is_weixin()){//如果是微信浏览器 直接公众号支付，否则 扫一扫支付
            $this->weixin_zhijiezhifu($paydata);
        }else{
            $this->weixin_saomazhifu($paydata);
        } 

    }
    
    private function weixin_zhijiezhifu($paydata){
            vendor('wxp.native'); //引入第三方类库
            $orderInput = new \WxPayUnifiedOrder();
            $orderInput->SetBody($paydata['body']);
            $orderInput->SetAttach($paydata['shop_name']);
            $orderInput->SetOut_trade_no($paydata['order_no']);
            $orderInput->SetTotal_fee($paydata['total_fee'] * 100);
            $orderInput->SetGoods_tag($paydata['shop_name']);
            $orderInput->SetNotify_url($paydata['notify']);
            $orderInput->SetTrade_type("JSAPI");
            $orderInput->SetOpenid($paydata['open_id']);//必须为登录
            $orderInfo = \WxPayApi::unifiedOrder($orderInput, 300);

            if (is_array($orderInfo) && $orderInfo['result_code'] == 'SUCCESS') {
                $jsapi = new \WxPayJsApiPay();
                $jsapi->SetAppid($orderInfo["appid"]);
                $timeStamp = time();
                $timeStamp = "$timeStamp";
                $jsapi->SetTimeStamp($timeStamp);
                $jsapi->SetNonceStr(\WxPayApi::getNonceStr());
                $jsapi->SetPackage("prepay_id=" . $orderInfo['prepay_id']);
                $jsapi->SetSignType("MD5");
                $jsapi->SetPaySign($jsapi->MakeSign());
                $parameters = $jsapi->GetValues();
            } else {
                $this->error("下单失败" . $orderInfo['return_msg']);
            }
            
            $this->assign('paydata',$paydata);
            $this->assign("parameters", json_encode($parameters));
            $this->display('zhifu');
    }
    
    

    /**
     * 微信支付的 异步回调
     * 
     */
    public function notifyweixin(){
        vendor('wxp.notify'); //引入第三方类库
        $notify = new \PayNotifyCallBack();
        $notify->Handle(false);
        $returnPay = $notify->getPayReturn();
        if (!$returnPay || $returnPay[""]) {
            echo "fail";
        }
        if (array_key_exists("return_code", $returnPay) && array_key_exists("result_code", $returnPay) && $returnPay["return_code"] == "SUCCESS" && $returnPay["result_code"] == "SUCCESS") {
            $ordermodel = D('Order');
            $order = $ordermodel->where("order_no='{$returnPay["out_trade_no"]}' and deleted=0 ")->find();
            //验证交易金额是否为订单的金额;
            if (!empty($returnPay['total_fee'])) {
                if ($returnPay['total_fee'] != $order['dues'] * 100) {
                    file_put_contents('./index.txt',$returnPay['total_fee'],FILE_APPEND);
                    file_put_contents('./index.txt',$order['dues'],FILE_APPEND);
                    echo "fail";
                }
            } 
            $order_id = $order['order_id'];
            $row = array(
                'pay_status' => 1, //支付状态为支付
                'updated' => time(),
                "pay_type" => 1,
                "trade_no" => $returnPay['transaction_id'],
                "pay_info" => serialize($returnPay)
            );
            if (!$ordermodel->where("order_id=$order_id")->save($row)) {
                echo "fail";
            }
            
            //订单或者团购订单成功再加商品购买数量
            echo "success";
        }
    }

  

    

 
    
    
    
    public function gmcg_wx(){
        $this->get_weixin_config();
        $this->assign('title','付款成功');
        $this->assign('is_ztcg','ddct');//组团状态为等待成团
        $order_id=$_GET['order_id'];
        $user_id=$_SESSION['huiyuan']['user_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='{$order_id}' and deleted=0")->find();
        $this->assign('order', $order);
        if($user_id!=$order['user_id']){
            $this->error('您没有该订单！',U('Order/index'),3);
        }
        if($order['pay_status']!='1'){
            $this->error('未付款成功,将返回付款页面',U('Goods/zhifu',"order_id=$order_id"));
        }
        
        
        $goods_id=$order['goods_id'];
        $goodsmodel=D('Goods');
        $goods=$goodsmodel->where("goods_id=$goods_id")->find();
        $tuan_no=$order['tuan_no'];
        $this->assign('tuan_no',$tuan_no);
        if($tuan_no==0){
            $remark="恭喜您，购买成功,我们将尽快把商品送到您的手上，请注意关注";
            $this->pintuan_success_tep($order_id,$remark);//给会员发送消息，购买成功，等待发货
            $buy_number=$ordermodel->where("order_id=$order_id")->getField('buy_number');
            $goodsmodel->where("goods_id=$goods_id")->setInc('buy_number',(int)$buy_number);//商品的购买次数加
            $shopsmodel->where("shop_id=$shop_id")->setInc('sale_number',(int)$buy_number);//店铺的购买次数加
            $this->assign('goods', $goods);
            $this->display('gmcg_dandu');
            exit();
        }
        $goods['count']=$ordermodel->where("tuan_no=$tuan_no and pay_status>0")->count();
        $goods['tuan_number']=$order['tuan_number'];//为了值需要assign给goods
        
        $tuanzhang_id=$ordermodel->where("tuan_no=$tuan_no and identity=1")->getField('user_id');
        $usersmodel=D('Users');
        $tuanzhang=$usersmodel->where("user_id=$tuanzhang_id")->field('head_url,user_name')->find();
        $goods['tuanzhang_head_url']=$tuanzhang['head_url'];
        $goods['tuanzhang_user_name']=$tuanzhang['user_name'];    
        $goods['tuanzhang_created']=$ordermodel->where("order_id=$tuan_no")->getField("created");
        $shopsmodel=D('Shops');
        $shop_id=$goods['shop_id'];
        
        
         
        //刚组团成功 把逻辑走一 遍    如果组团成功的逻辑已经走完一遍（即status不等于1）了 不再重复走
        if($goods['count']>=$order['tuan_number']&&$order['status']==1){
           $this->assign('is_ztcg','ztcg');//给JS判断是否组团成功
           
           
           //如果是抽奖活动，随机抽
           
           //如果是抽奖活动，随机抽取一个获取购买资格 
           $choujiang_count=$ordermodel->where("tuan_no=$tuan_no and choujiang=1")->count();
           if($goods['choujiang']==1){
               $rand=  mt_rand(0, $goods['count']-2);
               $arr_order_id=$ordermodel->where("tuan_no=$tuan_no and pay_status>0 and status=1 and identity=0")->getField('order_id',true);
               $rand_order_id=$arr_order_id[$rand];
               $row=array(
                   'choujiang'=>1
               );
               
               $ordermodel->where("order_id=$rand_order_id")->save($row);//抽中的人获取资格
               $ordermodel->where("order_id=$tuan_no")->save($row);//团长获取资格
               //给未被抽中的其它团员退款 并发送退款模板消息
               foreach ($arr_order_id as $value) {
                   if($value!=$rand_order_id){
                       $this->refund($value);
                       //给未被抽中的其它团员 发送88元代金券
                       $weihuojiang_user_id=$ordermodel->where("order_id=$value")->getField('user_id');
                       $this->get_88_daijinquan($weihuojiang_user_id);
                       //发动模板消息 通知代金券到帐
                       $this->send_dainjinquan_tep($value);
                   }
               }
               
               
               //给被抽中的团员发送拼团获奖成功消息模板
               $remark="恭喜您，拼团购买的1元购商品,已被抽中,我们将尽快把商品送到您的手上，请注意关注";
               $this->pintuan_success_tep($rand_order_id,$remark);
               //给团长发送信息
               $remark="恭喜您，开团购买的1元购商品已经成团,做为团长，您100%获奖，我们将尽快把商品送到您的手上，请注意关注";
               $this->pintuan_success_tep($tuan_no,$remark);
               
               
               $goodsmodel->where("goods_id=$goods_id")->setInc('buy_number',(int)$goods['count']);//商品的购买次数加团购人数               
               $shopsmodel->where("shop_id=$shop_id")->setInc('sale_number',(int)$goods['count']);//店铺的购买次数加团购人数
           }else{
               //不是活动的商品  给成团的团长和团员发送消息，成团成功，等待发货
                $arr_order_id=$ordermodel->where("tuan_no=$tuan_no and pay_status>0 and status=1")->getField('order_id',true);
                $remark="恭喜您，拼团的商品已经成团,我们将尽快把商品送到您的手上，请注意关注";
                foreach ($arr_order_id as $value) {
                    $this->pintuan_success_tep($value,$remark);//不是活动的商品  给成团的团长和团员发送消息，成团成功，等待发货
                }
                //每个团员购买数量 都需要给商品的购买次数增加
                $arr_buy_number=$ordermodel->where("tuan_no=$tuan_no and pay_status>0")->getField('buy_number',true);
                foreach ($arr_buy_number as $value) {
                    $goodsmodel->where("goods_id=$goods_id")->setInc('buy_number',(int)$value);//商品的购买次数加
                    $shopsmodel->where("shop_id=$shop_id")->setInc('sale_number',(int)$value);//店铺的购买次数加
                }
            }
           
        //给该团所有订单的status改为2
           $row=array(
               'status'=>2
           );          
           $ordermodel->where("tuan_no=$tuan_no and pay_status>0")->save($row);
        }
        //组团成功的代码到此为止
        
        
        
        
        $tuanyuan=$ordermodel->table('m_order t1,m_users t2')->where("t1.user_id=t2.user_id and t1.tuan_no=$tuan_no and t1.identity=0 and t1.pay_status>0")->field('t2.head_url,t2.user_name,t1.created')->select();
        if(!$tuanyuan[0]){
            $tuanyuan=NULL;
        }
        $this->assign('tuanyuan',$tuanyuan);
        $this->assign('tuanyuan_count',count($tuanyuan));
        $this->assign('goods', $goods);
        if($order['status']=='6'){
            $this->assign('is_ztcg','ztsb');//给JS判断是否组团成功
            $this->display('gmcg');
            exit();
        }else{
            $time=  time();
            if($time-(int)$goods['tuanzhang_created']>=86400){
                $this->assign('is_ztcg','ztsb');//给JS判断是否组团成功
            }
        }
        
        
        $user_name=$usersmodel->where("user_id=$user_id")->getField('user_name');
        $this->assign('user_name',$user_name);
        $this->display('gmcg');

    }
    

    
    
    
    
    public function jiance_pay(){
        if($_POST['check']==='wx_zhifu'){
            $order_id=$_POST['order_id'];
            $ordermodel=D('Order');
            $pay_status=$ordermodel->where("order_id=$order_id")->getField('pay_status');
            $this->ajaxReturn($pay_status);
        }
    }



    public function sellection_join() {
        if ($_POST['check'] !== 'sellection_join') {
            exit();
        }
        $user_id = $_SESSION['huiyuan']['user_id'];
        $goods_id = $_POST['goods_id'];
        $sellectionmodel = D('Sellection');
        $count = $sellectionmodel->where("user_id=$user_id and goods_id=$goods_id")->count();
        if ($count != '0') {
            exit();
        }
        $row = array(
            'user_id' => $user_id,
            'goods_id' => $goods_id,
            'add_time' => mktime()
        );
        $result = $sellectionmodel->add($row); //信息写入数据库
        if ($result) {
            $data = '1';
        } else {
            $data = '-1';
        }
        $this->ajaxReturn($data);
        exit();
    }
    
    
    
    
    private function pintuan_fail($tuan_no){
        $ordermodel=D('Order');
        $data['status']=6;
        $ordermodel->where("tuan_no=$tuan_no and status<7")->save($data);
    }






     
    
    private function use_daijinquan($user_id,$ky_daijinquan){
        $usersmodel=D('Users');
        $daijinquan=$usersmodel->where("user_id=$user_id")->getField('daijinquan');
        $arr=  unserialize($daijinquan);
        foreach ($arr as $key => $value) {
            if($value['sum']==$ky_daijinquan){
                array_splice($arr, $key, 1);
                break;;
            }
        }
        $new_daijinquan=  serialize($arr);
        $row=array(
            'daijinquan'=>$new_daijinquan
        );
        $result=$usersmodel->where("user_id=$user_id")->save($row);
        return $result;
    }
    
    
    
    private function weixin_saomazhifu(){
        $this->display('bendi_zhifu');
    }
    public function bendi_zhifu(){
         $order_id = $_GET['order_id'];
            $row = array(
                'pay_status' => 1, //支付状态为支付
                'updated' => time(),
                "pay_type" => 1
            );
            $ordermodel=D('Order');
            if (!$ordermodel->where("order_id=$order_id")->save($row)) {
                $this->error('支付失败');
            }
            $this->redirect('Goods/gmcg_wx',array('order_id'=>$order_id),0);
    }
    
    
    
    private function refund($order_id) {
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id=$order_id")->find();
        if($order['pay_status']!=1&&$order['pay_status']!=2){
            $this->error('该订单未付款或者正在申请换货或者已经退款成功,无法退款');
        }
        vendor('wxp.native'); //引入第三方类库
            $refundInput = new \WxPayRefund();
            $refundInput->SetTransaction_id($order['trade_no']);
            $refundInput->SetOut_refund_no($order['order_no']);
            $refundInput->SetOut_trade_no($order['order_no']);
            $refundInput->SetTotal_fee($order['dues'] * 100);
            $refundInput->SetRefund_fee($order['dues'] * 100);
            $refundInput->SetOp_user_id('1380048502');
            $refundInfo = \WxPayApi::refund($refundInput, 300);

            if (is_array($refundInfo) && $refundInfo['result_code'] == 'SUCCESS') {//退款成功
                $row=array('pay_status'=>4,'shouhou_cause'=>'活动商品未获奖');
                $ordermodel->where("order_id=$order_id")->save($row);
                $this->refund_tep_weihuojiang($order_id);
            } else {
                $this->error("退款失败" .  $refundInfo['return_msg']);
            }
               
    }
    
    private function refund_tep_weihuojiang($order_id){
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id=$order_id")->find();
        $user_id=$order['user_id'];
        $usersmodel=D('Users');
        $open_id=$usersmodel->where("user_id=$user_id")->getField('open_id');
        $template_id="95UZl_xx_sjJdno-l1X4vUrRvOLlsepMEZHPFsofZms";
        $goods_id=$order['goods_id'];
        $url=U('Goods/index',array('goods_id'=>$goods_id));
        $arr_data=array(
            'first'=>array('value'=>"您好，您拼团购买的1元购商品：".$order["goods_name"]." 未被抽中，已全额退款给您！","color"=>"#666"),
            'reason'=>array('value'=>"1元购活动将在".($order['tuan_number']-1)."名团员中抽取一人获奖，团长将100%获奖，您还可以自己去开团，组团成功后，您将100%获奖","color"=>"#F90505"),
            'refund'=>array('value'=>$order["dues"]."元","color"=>"#666"),
            'remark'=>array('value'=>"点我，现在就去开团","color"=>"#F90505")
        );
        $this->response_template($open_id, $template_id, $url, $arr_data);
    }
    
    private function send_dainjinquan_tep($order_id){
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id=$order_id")->find();
        $user_id=$order['user_id'];
        $usersmodel=D('Users');
        $open_id=$usersmodel->where("user_id=$user_id")->getField('open_id');
        $template_id="-CvJ9caeLvY9Vdqehftu8JkW0LMg0_xfmsRdK8V3_WI";
        $url=U('Index/index');
        $tm=time();
        $youxiaoqi=date('Y.m.d',$tm).'-'.date('Y.m.d',($tm+345600));
        $arr_data=array(
            'first'=>array('value'=>"亲爱的用户，88元代金券已经成功发放给您，前往：会员中心--我的代金券 即可查看","color"=>"#666"),
            'keyword1'=>array('value'=>"88元代金券","color"=>"#F90505"),
            'keyword2'=>array('value'=>date('Y年m月d日'),"color"=>"#666"),
            'keyword3'=>array('value'=>'已经成功发放给您的账户',"color"=>"#666"),
            'keyword4'=>array('value'=>'代金券使用有效期：'.$youxiaoqi,"color"=>"#666"),
            'remark'=>array('value'=>"点我，查看更多拼团，前往使用代金券。","color"=>"#F90505")
        );
        $this->response_template($open_id, $template_id, $url, $arr_data);
    }
    private function pintuan_success_tep($order_id,$remark){
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id=$order_id")->find();
        $user_id=$order['user_id'];
        $usersmodel=D('Users');
        $open_id=$usersmodel->where("user_id=$user_id")->getField('open_id');
        $template_id="E-s0XUfqmr8jQZWF2y40xi9wFXwPyOWykZvx44YQfk8";
        $url=U('Order/view',array('order_id'=>$order_id));
        $arr_data=array(
            'name'=>array('value'=>$order["goods_name"],"color"=>"#666"),
            'remark'=>array('value'=>$remark,"color"=>"#F90505")
        );
        $this->response_template($open_id, $template_id, $url, $arr_data);
    }
    
    
    private function get_88_daijinquan($user_id) {
        $this->get_daijinquan($user_id, '通用券', 5);
        $this->get_daijinquan($user_id, '通用券', 8);
        $this->get_daijinquan($user_id, '通用券', 10);
        $this->get_daijinquan($user_id, '通用券', 15);
        $this->get_daijinquan($user_id, '通用券', 20);
        $this->get_daijinquan($user_id, '通用券', 30);
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
   
   
}
