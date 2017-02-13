<?php
namespace Home\Controller;
use Home\Controller;
class OrderController extends FontEndController {
    public function index(){
        $status=$_GET['status'];
        $this->assign('canshu',$_GET['status']);
        $ordermodel=D('Order');
        $user_id=$_SESSION['huiyuan']['user_id'];
        $status_count['no_complete']=$ordermodel->where("user_id={$user_id} and pay_status=0 and status<9 and deleted=0")->count();//获取未完成条数
        $status_count['complete']=$ordermodel->where("user_id={$user_id} and pay_status=1 and status>7 and deleted=0")->count();//获取已完成条数
        $status_count['no_pay']=$ordermodel->where("user_id={$user_id} and pay_status=0 and deleted=0  and status=8")->count();//获取待付款条数
        $status_count['no_appraise']=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=8 and deleted=0")->count();//获取待评价条数
        $this->assign(status_count,$status_count);
        $time=  time();
        $this->assign('time',$time);
        if(empty($status)){
            $selected['no_complete']="selected='selected'";//选中下拉菜单的未完成订单
            $this->assign(selected,$selected);
            $count=$ordermodel->where("user_id={$user_id} and pay_status=0 and status<9 and deleted=0")->count();
            $this->assign(count,$count);
            //$page=$this->get_page($count, 10);
            //$page_foot=$page->show();//显示页脚信息
            //$list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.deleted=0 and t1.user_id={$user_id} and t1.goods_id=t2.goods_id")->order('t1.created desc')->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t1.price,t1.dues,t1.tuan_no,t1.tuan_number,t1.fenxiang')->limit($page->firstRow.','.$page->listRows)->select();
            $list=$ordermodel->where("user_id={$user_id} and pay_status=0 and status<9 and deleted=0")->select();
            $this->assign('list',$list);
            //$this->assign('page_foot',$page_foot);
        }else if($status==='complete'){
             $selected['complete']="selected='selected'";//选中下拉菜单的未付款
             $this->assign(selected,$selected);
             $count=$ordermodel->where("user_id={$user_id} and pay_status=1 and status>7 and deleted=0")->count();
             //$page=$this->get_page($count, 10);
             //$page_foot=$page->show();//显示页脚信息
             //$list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.deleted=0 and t1.user_id={$user_id} and t1.pay_status=0  and t1.status<6 and t1.goods_id=t2.goods_id")->order('t1.created desc')->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t1.price,t1.dues,t1.tuan_no,t1.tuan_number,t1.fenxiang')->limit($page->firstRow.','.$page->listRows)->select();
             $list=$ordermodel->where("user_id={$user_id} and pay_status=1 and status>7 and deleted=0")->select();
             $this->assign('list',$list);
             //$this->assign('page_foot',$page_foot);
         }else if($status==='no_pay'){
             $selected['daifahuo']="selected='selected'";//选中下拉菜单的待发货
             $this->assign(selected,$selected);
             $count=$ordermodel->where("user_id={$user_id} and pay_status=0 and deleted=0  and status=8")->count();
             //$page=$this->get_page($count, 10);
             //$page_foot=$page->show();//显示页脚信息
             //$list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.deleted=0 and t1.user_id={$user_id} and t1.pay_status=1 and (t1.status=2 or (t1.tuan_no=0 and t1.status=1)) and t1.goods_id=t2.goods_id")->order('t1.created desc')->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t1.price,t1.dues,t1.tuan_no,t1.tuan_number,t1.fenxiang')->limit($page->firstRow.','.$page->listRows)->select();
             $list=$ordermodel->where("user_id={$user_id} and pay_status=0 and deleted=0  and status=8")->select();
             $this->assign('list',$list);
             //$this->assign('page_foot',$page_foot);
         }else if($status==='no_appraise'){
             $selected['daishouhuo']="selected='selected'";//选中下拉菜单的待确认
             $this->assign(selected,$selected);
             $count=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=8 and deleted=0")->count();
             //$page=$this->get_page($count, 10);
             //$page_foot=$page->show();//显示页脚信息
             //$list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.deleted=0 and t1.user_id={$user_id} and t1.pay_status=1 and t1.status=3 and t1.goods_id=t2.goods_id")->order('t1.created desc')->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t1.price,t1.dues,t1.tuan_no,t1.tuan_number,t1.fenxiang')->limit($page->firstRow.','.$page->listRows)->select();
             $list=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=8 and deleted=0")->select();
             $this->assign('list',$list);
             //$this->assign('page_foot',$page_foot);
         }
         $this->display();
    }
    
    
    
    public function quxiao_shouhou(){
        if((!empty($_POST['order_id']))&&$_POST['check']==='quxiao_shouhou'){
            $order_id=$_POST['order_id'];
            $ordermodel=D('Order');
            $pay_status=$ordermodel->where("order_id=$order_id")->getField('pay_status');//查看订单付款状态 如果未付款 退出
            $order_user_id=$ordermodel->where("order_id=$order_id")->getField('user_id');//登录用户无该订单权限
            if(($order_user_id!=$_SESSION['wei_huiyuan']['user_id'])||$pay_status==0){
                $result=false;
                $this->ajaxReturn($result);
                exit();
            }
            $row=array(
                'pay_status' => 1,
                'shouhou_cause'=>'',
                'shouhou_miaoshu'=>'',
                'shouhou_img'=>'',
                'shouhou_iphone'=>'',
                'updated'=>time()
            );
            
            $result = $ordermodel->where("order_id=$order_id")->save($row);
            session('guanzhu',null); 
            $this->ajaxReturn($result);
        }
    }
    
    public function delete_order(){
        if((!empty($_POST['order_id']))&&$_POST['check']=='delete_order'){
            $order_id=$_POST['order_id'];
            $ordermodel=D('Order');
            $row=array(
                'deleted' => 1
            );
            $order_user_id=$ordermodel->where("order_id=$order_id")->getField('user_id');//登录用户无该订单权限
            if($order_user_id!=$_SESSION['wei_huiyuan']['user_id']){//登录用户无该订单权限
                $result=false;
                $this->ajaxReturn($result);
                exit();
            }
            $result = $ordermodel->where("order_id=$order_id")->save($row);
            session('guanzhu',null); 
            $this->ajaxReturn($result);
        }
    }

    public function view(){
        $order_id=$_GET['order_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='{$order_id}'")->find();
        $user_id=$_SESSION['huiyuan']['user_id'];
        if($order['user_id']!=$user_id){
            $this->error('该订单号不存在或已经删除 ');
        }
        $order_goodsmodel=D('Order_goods');
        $order_goods=$order_goodsmodel->where("order_id='$order_id'")->select();
        $order_price=0;
        foreach ($order_goods as $value) {
            $order_price+=$value['price']*$value['goods_number'];
        }
        $this->assign('order_price',$order_price);
        $this->assign('order_goods',$order_goods);
        $address=  unserialize($order['order_address']);
        $order['order_address']=$address;
        $order['shop_img']=  unserialize($order['shop_img']);
        $order['img_number']=count($order['shop_img']);
        $this->assign('order',$order);
        
        //订单操作记录
        $order_actionmodel=D('Order_action');
        $order_action=$order_actionmodel->where("order_id='$order_id'")->order('log_time asc')->select();
        $this->assign('order_action',$order_action);
        
        //取衣骑手信息
        $horsemanmodel=D('Horseman');
        $horseman_id=$order['horseman_id'];
        $horseman=$horsemanmodel->where("horseman_id='$horseman_id'")->find();
        $this->assign('horseman',$horseman);
        //送衣骑士信息
        $deliver_horseman_id=$order['deliver_horseman_id'];
        $deliver_horseman=$horsemanmodel->where("horseman_id='$deliver_horseman_id'")->find();
        $this->assign('deliver_horseman',$deliver_horseman);
        $this->display('view');
    }
    
    public function songyi() {
        $order_id=$_GET['order_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='{$order_id}'")->find();
        $user_id=$_SESSION['huiyuan']['user_id'];
        if($order['user_id']!=$user_id){
            $this->error('该订单号不存在或已经删除 ');
        }
        $usersmodel=D('Users');
        $user=$usersmodel->where("user_id='$user_id'")->find();
        if(isset($_GET['code'])){//微信地址接口
            $code=$_GET['code'];
            $parameters=$this->get_address_data($code);
            $this->assign('signPackage',$parameters);
        }
        $this->assign('open_id',$open_id);
        //微信地址接口
        $address=$usersmodel->where("user_id=$user_id")->field('address,default_address,daijinquan')->find();
        if($address['address']!=''){
                $arr_address=  unserialize($address['address']);
            }else{
                $arr_address='';
            }
        $this->assign('arr_address',$arr_address);
        $default=$address['default_address'];
        $default_address=$arr_address[$default];
        $this->assign('default_Address',$default_address);
        $this->assign('default_eq',$default);
        $this->assign('order_id',$order_id);
        $this->display();
    }
    
    public function songyi_confirm() {
        $post=$_POST;
        $ordermodel = D('Order');
        // 手动进行令牌验证 
        if (!$ordermodel->autoCheckToken($_POST)){ 
            $this->redirect('Order/view',array('order_id'=>$order_id));
            exit();
        }
        $user_id = $_SESSION['huiyuan']['user_id'];
        $order_id=$post['order_id'];
        $order['user_id']=$ordermodel->where("order_id='{$order_id}'")->getField('user_id');
        if($user_id!=$order['user_id']){
            $this->error('您没有该订单');
            exit;
        }
        $arr_order_address=array(
            'name'=>$post['address_name'],
            'mobile'=>$post['address_mobile'],
            'location'=>$post['address_location'],
            'address'=>$post['address_address'],
        );
        $order_address=  serialize($arr_order_address);
        $order_time=$post['order_time'];
        $row = array(
            'deliver_time'=>$order_time,
            'status' => 6, 
            'deliver_address'=>$order_address,
        );
        $result = $ordermodel->where("order_id='{$order_id}'")->save($row); //订单信息写入数据库order表
       if(!$result){
           $this->error('订单更新失败');
       }
        $usersmodel=D('Users');
        $user_name=$usersmodel->where("user_id='$user_id'")->getField('user_name');
        $order_actionmodel=D('Order_action');
        $row_action=array(
            'order_id'=>$order_id,
            'action_type'=>'user',
            'actionuser_id'=>$user_id,
            'actionuser_name'=>$user_name,
            'order_status'=>6,
            'pay_status' => 0, //支付状态为未支付
            'log_time'=>time()
        );
        $order_actionmodel->add($row_action); //订单操作信息写入数据库order_action表
        cookie('order_id',$result,36000);
        $this->redirect('Order/view',array('order_id'=>$order_id));
    }
    

    public function jiaoyi_success(){
        session('guanzhu',null); 
        $this->assign('title','交易完成');
        $order_id=$_GET['order_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id=$order_id")->field('user_id,shop_id,dues,fenxiang_dues,fenxiang')->find();
        $order_user_id=$order['user_id'];//登录用户无该订单权限
        if($order_user_id!=$_SESSION['wei_huiyuan']['user_id']){//登录用户无该订单权限
            $this->error('您没有该订单权限');
        }
        //改变订单状态，同时无法再进行分享返现
        if($order['fenxiang']==0){
            $row=array(
                'status'=>4,
                'fenxiang'=>2
            );
        }else{
            $row=array(
                'status'=>4
            );
        }
        $result=$ordermodel->where("order_id=$order_id")->save($row);
        if(!$result){
            $this->error('确认收货失败！');
        }
        
        //店铺总金额增加
        $shop_id=$order['shop_id'];
        if($order['fenxiang']==1){
            $amount=$order['dues']-$order['fenxiang_dues'];
        }else{
            $amount=$order['dues'];
        }
        $shopsmodel=D('Shops');
        $result=$shopsmodel->where("shop_id='$shop_id'")->setInc('totle_amount',(float)$amount);
        if(!$result){
            $this->error('确认收货后增加店铺金额失败！');
        }
        
        //发送交易成功通知
        $remark='点我进行评价，您的评价是对卖家最好的肯定。';
        $this->jiaoyi_success_tep($order_id, $remark);
        
        //给商家发送订单已经确认收货通知
        $remark='订单金额已经转入您的店铺金额。';
        $this->queren_shouhuo_tep($order_id, $remark);
        
        
        $this->redirect('Order/appraise',array('order_id'=>$order_id));
        
        
        
        
    }
    
    
    
    
    public function appraise(){
        session('guanzhu',null); 
        $this->assign('title','评价');
        $order_id=$_GET['order_id'];
        $this->assign('order_id',$order_id);
        $ordermodel=D('Order');
        $order_user_id=$ordermodel->where("order_id=$order_id")->getField('user_id');//登录用户无该订单权限
        if($order_user_id!=$_SESSION['wei_huiyuan']['user_id']){//登录用户无该订单权限
            $this->error('您没有该订单权限');
        }
        $order=$ordermodel->table('m_order t1,m_goods t2')->where("t1.order_id={$order_id} and t1.goods_id=t2.goods_id")->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.shop_name,t1.status,t1.pay_status,t1.created,t1.updated,t2.goods_img,t1.price,t1.dues,t1.shop_name')->find();
        $this->assign('order',$order);
        $order=$ordermodel->where("order_id=$order_id")->find();
        $this->display('appraise');
    }
    public function file_jia(){
        $file_info=$this->upload('image/temp/');//获取上传文件信息
        if($file_info[0]==='error'){
            $data=array(
                'result'=>'error',
                'error'=>$file_info[1]
            );
            $this->ajaxReturn($data,'JSON');
            exit();

        }
        //获取图片URL
        $data=array();
        $data['src']=UPLOAD.$file_info[1]['file_img']['savepath'].$file_info[1]['file_img']['savename'];
        $data['src_thumb']=$this->thumb($data['src'],300,300);//创建图片的缩略图
        $this->ajaxReturn($data,'JSON');
    }
        
    private function thumb($url,$a,$b){
        $image = new \Think\Image(); 
        $index=strripos($url,"/");
        $img_url=substr($url,0,$index+1);
        $img_name=substr($url,$index+1); 
        $image->open($url);
        creat_file($img_url.'thumb');//创建文件夹（如果存在不会创建）
        $image->thumb($a, $b)->save($img_url.'thumb/'.$img_name);
        return $img_url.'thumb/'.$img_name;
    }
    
    public function appraise_success(){
        session('guanzhu',null); 
        $this->assign('title','评价成功');
        $order_id=$_GET['order_id'];
        $ordermodel=D('Order');
        $user_id=$_SESSION['wei_huiyuan']['user_id'];
        $order_user_id=$ordermodel->where("order_id=$order_id")->getField('user_id');//登录用户无该订单权限
        if($order_user_id!=$user_id){//登录用户无该订单权限
            $this->error('您没有该订单权限');
        }
        $content=$_POST;//获取提交的内容
        $pinglun=$content['pingjia_text'];

        //获取图片URL,分割成数组
        if($content['goods_img']!==''){
            $arr_img=explode('+img+',$content['goods_img']);
            //移动文件 并且改变url
            foreach ($arr_img as &$value) {
                $today=substr($value,26,8);//获取到文件夹名  如20150101
                creat_file(UPLOAD.'image/appraise/'.$today);//创建文件夹（如果存在不会创建）
                $img_url_thumb=$this->thumb($value, 500, 800);//thumb
                rename($img_url_thumb, str_replace('Public/Uploads/image/temp', UPLOAD.'image/appraise',$value));//移动文件
                $value=str_replace('Public/Uploads/image/temp','Public/Uploads/image/appraise',$value);  
                $value='/'.$value;
            }
            $str_img=serialize($arr_img);//序列化数组
        }
        unset($content['goods_img']);//从数组中删除goods_img
        
        
        if(is_feifa($pinglun)){
            $this->error('评论含有非法字符');
            exit();
        }
        if($pinglun==''){
            $pinglun='买家没有留下文字评价';//如果没有留下评论，自动评论为这句话
        }
        unset($content['pingjia_text']);//从数组中删除评论
       
        $pingfen[]=$content['pingfen_1'];
        $pingfen[]=$content['pingfen_2'];
        $pingfen[]=$content['pingfen_3'];
        $score=($content['pingfen_1']+$content['pingfen_2']+$content['pingfen_3'])/3;
        $score=number_format($score, 1);
        
        $pingfen=serialize($pingfen);//序列化数组      
        
        //更新order表里面的数据，存入数据库
        $order_status=$ordermodel->where("order_id=$order_id")->getField('status');//订单是否是已确认状态
        if($order_status!='4'){
            $this->error('订单状态不是已收货状态');
            exit();
        }
        $row=array(
            'status'=>5,//状态为已评价
            'appraise'=>$pinglun,
            'score'=>$score,
            'pingfen'=>$pingfen,
            'appraise_img'=>$str_img,
            'updated'=> time()
                );
        $ordermodel->where("order_id=$order_id")->save($row);
        
        
        
        //更新商品表里面的分数和评价人数，存入
        $goods_id=$ordermodel->where("order_id=$order_id")->getField('goods_id');//得到商品id
        $array_score=$ordermodel->where("goods_id=$goods_id and status=5")->getField('score',true);
        $goods_score=0;
        foreach ($array_score as $score_value){
            $goods_score+=$score_value;
        }
        $score_count=count($array_score);
        $goods_score=$goods_score/$score_count;
        $row1=array(
            'score'=>$goods_score,
            'comment_number'=>$score_count
        );
        $goodsmodel=D('Goods');
        $goodsmodel->where("goods_id=$goods_id")->save($row1);
        
        //发放33元代金券
        $this->get_daijinquan($user_id, '通用券', 5);
        $this->get_daijinquan($user_id, '通用券', 8);
        $this->get_daijinquan($user_id, '通用券', 20);
        
        //发送评论成功(得到代金券)模板消息
        $this->send_dainjinquan_tep($order_id);
        $this->redirect('Order/appraise_manage',array('order_id'=>$order_id),0);

    }
    
    public function appraise_manage(){
        session('guanzhu',null); 
        $this->assign('title','我已评价');
        $ordermodel=D('Order');
        $user_id=$_SESSION['wei_huiyuan']['user_id'];
        $count=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=5")->count();
        $page=$this->get_page($count, 10);
        $page_foot=$page->show();//显示页脚信息
        $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.user_id={$user_id} and t1.pay_status=1 and t1.status=5 and t1.goods_id=t2.goods_id")->order('t1.updated desc')->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.shop_name,t1.status,t1.pay_status,t1.updated,t1.pingfen,t1.appraise,t2.goods_img')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page_foot',$page_foot);
        $this->display('appraise_manage');
    }
    
    
    public function shouhou() {
        $user_id=$_SESSION['huiyuan']['user_id'];
        $this->assign('user_id',$user_id);
        $order_id=$_GET['order_id'];
        if(!$order_id){
            $this->error('订单号为空！');
        }
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id='{$order_id}'")->find();
        $maijia_id=$order['user_id'];
        if(empty($maijia_id)){
            $this->error('该订单不存在','/Home/Order/index');
        }
        if($order[pay_status]==='0'){
            $this->error('该订单未付款','/Home/Order/index');
        }
        $usermodel=D('Users');
        $maijia=$usermodel->where("user_id=$maijia_id")->field('user_name')->find();
        $this->assign('maijia',$maijia);
        if($order['user_id']===$user_id||$order['shop_id']===$user_id){
            $this->assign('order',$order);
            echo '请联系客服：13574506835';
            exit;
            $this->display();
        }else{
            $this->error('该订单不存在','/Home/Order/index');
        }
    }
    public function shouhou_check() {
        session('guanzhu',null); 
        $ordermodel=D('Order');
        // 手动进行令牌验证 
        if (!$ordermodel->autoCheckToken($_POST)){ 
            $this->error('不能重复提交订单',U('Order/index'));
        }
        $order_id=$_POST['order_id'];
        if(empty($order_id)){
            $this->error('订单号不存在');
        }
        
        $order=$ordermodel->where("order_id=$order_id")->field("user_id,shop_name,goods_id,dues")->find();
        $order_user=$order['user_id'];
        $user_id=$_SESSION['wei_huiyuan']['user_id'];
        if($order_user!==$user_id){
            $this->error('您没有该订单');
        }
        //描述超过170个字，返回
        if(strlen($_POST['miaoshu'])>170){
            $this->error('您的问题描述超出170个字！');
        }
        //验证手机号是否符合规范
        if(!is_shoujihao($_POST['shouhou_iphone'])){
            $this->error('您的联系手机不符合规范！');
        }
        $arr_img=  explode('+img+',$_POST['goods_img']);
        foreach ($arr_img as &$value) {
            $value='/'.$value;
        }
        $shouhou_img=  serialize($arr_img);
        $order_row=array(
            'shouhou_img'=>$shouhou_img,
            'shouhou_cause'=>$_POST['shouhou_cause'],
            'shouhou_miaoshu'=>$_POST['miaoshu'],
            'shouhou_iphone'=>$_POST['shouhou_iphone'],
            'updated'=>  time()
        );
        if($_POST['shouhou_leixing']==='申请换货'){
            $order_row['pay_status']=3;
        }elseif($_POST['shouhou_leixing']==='申请退货'){
            $order_row['pay_status']=2;
        }
        $result=$ordermodel->where("order_id=$order_id")->save($order_row);
        if($result){
            $this->redirect('Order/shouhou_status',array('order_id'=>$order_id),0);
        }else{
            $this->error('提交售后失败！');
        }
    }
    public function shouhou_status() {
        session('guanzhu',null); 
        $order_id=$_GET['order_id'];
        if(empty($order_id)){
            $this->error('订单号不存在');
        }
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id=$order_id")->field('order_id,user_id,pay_status,shouhou_cause,shouhou_miaoshu,shouhou_img,shouhou_iphone,goods_id,dues,updated')->find();
        if($order['pay_status']<2){
            $this->error('该订单没有申请售后！');
        }
        $order_user=$order['user_id'];
        $user_id=$_SESSION['wei_huiyuan']['user_id'];
        if($order_user!==$user_id){
            $this->error('您没有该订单');
        }
        
        $this->assign('order',$order);
        $arr_img= unserialize($order['shouhou_img']);
        $this->assign('arr_img',$arr_img);
        $this->display();
    }
    


    
    /**
    * Json方式 查询订单物流轨迹
    */
    private function getOrderTracesByJson($OrderCode,$ShipperCode,$LogisticCode){
	$requestData= "{'OrderCode':'$OrderCode','ShipperCode':'$ShipperCode','LogisticCode':'$LogisticCode'}";
	$datas = array(
            'EBusinessID' => EB_ID,
            'RequestType' => '1002',
            'RequestData' => urlencode($requestData) ,
            'DataType' => '2',
        );
        $datas['DataSign'] = $this->encrypt($requestData, EB_AppKey);
	$result=$this->sendPost(EB_ReqURL, $datas);	
	
	//根据公司业务处理返回的信息......
	
	return $result;
    }
 
    /**
    *  post提交数据 
    * @param  string $url 请求Url
    * @param  array $datas 提交的数据 
    * @return url响应返回的html
    */
    private function sendPost($url, $datas) {
        $postdata = http_build_query($datas);    
        $options = array(    
            'http' => array(    
                'method' => 'POST',    
                'header' => 'Content-type:application/x-www-form-urlencoded',    
                'content' => $postdata,    
                'timeout' => 15 * 60 // 超时时间（单位:s）    
            )    
        );    
        $context = stream_context_create($options);    
        $result = file_get_contents($url, false, $context);             
        return $result;    
    }

    /**
     * 电商Sign签名生成
    * @param data 内容   
    * @param appkey Appkey
    * @return DataSign签名
    */
    private function encrypt($data, $appkey) {
        return urlencode(base64_encode(md5($data.$appkey)));
    }
    
    
   //收货成功后，给商家发送订单确认收货通知
    private function queren_shouhuo_tep($order_id,$remark){
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id=$order_id")->find();
        $user_id=$order['user_id'];
        $usersmodel=D('Users');
        $user_name=$usersmodel->where("user_id=$user_id")->getField('user_name');
        $shop_id=$order['shop_id'];
        $shopsmodel=D('Shops');
        $open_id=$shopsmodel->where("shop_id=$shop_id")->getField('open_id');
        $template_id="TlXhsrpBwj1I8v3pkClul5dDEuvrMBGmy1ihKqJOCyY";
        $url=U('Shop/view_order',array('order_id'=>$order_id));
        if($order['fenxiang']==1){
            $amount=$order['dues']-$order['fenxiang_dues'];
        }else{
            $amount=$order['dues'];
        }
        $arr_data=array(
            'first'=>array('value'=>"您好，您售出的商品".$order['goods_name']."已经被".$user_name."确认收货。","color"=>"#666"),
            'keyword1'=>array('value'=>$order['order_no'],"color"=>"#666"),
            'keyword2'=>array('value'=>$amount,"color"=>"#666"),
            'keyword3'=>array('value'=>  date('Y/m/d H:i:s'),"color"=>"#666"),
            'remark'=>array('value'=>$remark,"color"=>"#F90505")
        );
        $this->response_template($open_id, $template_id, $url, $arr_data);
    }
    
    
    //收货成功后，发送交易成功和请买家评价通知
    private function jiaoyi_success_tep($order_id,$remark){
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id=$order_id")->find();
        $user_id=$order['user_id'];
        $usersmodel=D('Users');
        $open_id=$usersmodel->where("user_id=$user_id")->getField('open_id');
        $template_id="VFmfBzeReRkds4Itr5HMDij0RTgPFalRQJpL5J7Pw9s";
        $url=U('Order/appraise',array('order_id'=>$order_id));
        $arr_data=array(
            'first'=>array('value'=>"您好，您购买的商品：".$order["goods_name"]."已经确认收货。","color"=>"#666"),
            'keyword1'=>array('value'=>$order['dues'].'元',"color"=>"#F90505"),
            'keyword2'=>array('value'=>$order["goods_name"],"color"=>"#666"),
            'keyword3'=>array('value'=>$order['order_no'],"color"=>"#F90505"),
            'remark'=>array('value'=>$remark,"color"=>"#F90505")
        );
        $this->response_template($open_id, $template_id, $url, $arr_data);
    }
    
    //评价成功后 获得代金券模板消息
    private function send_dainjinquan_tep($order_id){
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id=$order_id")->find();
        $user_id=$order['user_id'];
        $usersmodel=D('Users');
        $open_id=$usersmodel->where("user_id=$user_id")->getField('open_id');
        $template_id="-CvJ9caeLvY9Vdqehftu8JkW0LMg0_xfmsRdK8V3_W";
        $url=U('Index/index');
        $tm=time();
        $youxiaoqi=date('Y.m.d',$tm).'-'.date('Y.m.d',($tm+345600));
        $arr_data=array(
            'first'=>array('value'=>"亲爱的用户，您成功评价了商品：".$order['goods_name'].",33元代金券已经成功发放给您，前往：会员中心--”我的代金券“即可查看","color"=>"#666"),
            'keyword1'=>array('value'=>"33元代金券","color"=>"#F90505"),
            'keyword2'=>array('value'=>date('Y年m月d日'),"color"=>"#666"),
            'keyword3'=>array('value'=>'已经成功发放给您的账户',"color"=>"#666"),
            'keyword4'=>array('value'=>'代金券使用有效期：'.$youxiaoqi,"color"=>"#666"),
            'remark'=>array('value'=>"点我，查看更多拼团，前往使用代金券。","color"=>"#F90505")
        );
        $this->response_template($open_id, $template_id, $url, $arr_data);
    }
    
    

}