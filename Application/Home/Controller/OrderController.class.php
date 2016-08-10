<?php
namespace Home\Controller;
use Home\Controller;
class OrderController extends FontEndController {
    public function index(){
         $status=$_GET['status'];
         $this->assign('canshu',$_GET['status']);
         $this->assign('title','我的订单');
         $ordermodel=D('Order');
         $user_id=$_SESSION['huiyuan']['user_id'];
         $status_count['all']=$ordermodel->where("user_id={$user_id} and deleted=0")->count();//获取全部订单条数
         $status_count['no_pay']=$ordermodel->where("user_id={$user_id} and pay_status=0 and deleted=0  and status<6")->count();//获取未付款条数
         $status_count['wait_tuan']=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=1 and tuan_no<>0 and deleted=0")->count();//获取待成团条数
         $status_count['daifahuo']=$ordermodel->where("user_id={$user_id} and pay_status=1 and (status=2 or (tuan_no=0 and status=1)) and deleted=0")->count();//获取待发货条数
         $status_count['daishouhuo']=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=3 and deleted=0")->count();//获取待收货条数
         $status_count['daipingjia']=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=4 and deleted=0")->count();//获取待评价条数
         $this->assign(status_count,$status_count);
         $time=  time();
         $this->assign('time',$time);
         if(empty($status)){
             $selected['all']="selected='selected'";//选中下拉菜单的全部订单
             $this->assign(selected,$selected);
             $count=$ordermodel->where("user_id={$user_id} and deleted=0")->count();
             $this->assign(count,$count);
             $page=$this->get_page($count, 10);
             $page_foot=$page->show();//显示页脚信息
             $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.deleted=0 and t1.user_id={$user_id} and t1.goods_id=t2.goods_id")->order('t1.created desc')->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t1.price,t1.dues,t1.tuan_no,t1.tuan_number')->limit($page->firstRow.','.$page->listRows)->select();
             foreach ($list as $key=>$value){
                $tuan_no=$value['tuan_no'];
                $count=$ordermodel->where("tuan_no=$tuan_no and pay_status=1")->count();
                $tuan_number=$value['tuan_number'];
                $list[$key]['count']=$tuan_number-$count;
             }
             $this->assign('list',$list);
             $this->assign('page_foot',$page_foot);
         }else if($status==='no_pay'){
             $selected['no_pay']="selected='selected'";//选中下拉菜单的未付款
             $this->assign(selected,$selected);
             $selected['all']='selected';
             $count=$ordermodel->where("user_id={$user_id} and pay_status=0 and deleted=0  and status<6")->count();
             $page=$this->get_page($count, 10);
             $page_foot=$page->show();//显示页脚信息
             $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.deleted=0 and t1.user_id={$user_id} and t1.pay_status=0  and t1.status<6 and t1.goods_id=t2.goods_id")->order('t1.created desc')->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t1.price,t1.dues,t1.tuan_no,t1.tuan_number')->limit($page->firstRow.','.$page->listRows)->select();
             foreach ($list as $key=>$value){
                $tuan_no=$value['tuan_no'];
                $count=$ordermodel->where("tuan_no=$tuan_no and pay_status=1")->count();
                $tuan_number=$value['tuan_number'];
                $list[$key]['count']=$tuan_number-$count;
             }
             $this->assign('list',$list);
             $this->assign('page_foot',$page_foot);
         }else if($status==='wait_tuan'){
             $selected['daichengtuan']="selected='selected'";//选中下拉菜单的待成团
             $this->assign(selected,$selected);
             $count=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=1 and tuan_no<>0 and deleted=0")->count();
             $page=$this->get_page($count, 10);
             $page_foot=$page->show();//显示页脚信息
             $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.deleted=0 and t1.user_id={$user_id} and t1.pay_status=1  and t1.tuan_no<>0 and t1.status=1 and t1.goods_id=t2.goods_id")->order('t1.created desc')->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t1.price,t1.dues,t1.tuan_no,t1.tuan_number')->limit($page->firstRow.','.$page->listRows)->select();
             foreach ($list as $key=>$value){
                $tuan_no=$value['tuan_no'];
                $count=$ordermodel->where("tuan_no=$tuan_no and pay_status=1")->count();
                $tuan_number=$value['tuan_number'];
                $list[$key]['count']=$tuan_number-$count;
             }
             $this->assign('list',$list);
             $this->assign('page_foot',$page_foot);
         }else if($status==='daifahuo'){
             $selected['daifahuo']="selected='selected'";//选中下拉菜单的待确认
             $this->assign(selected,$selected);
             $count=$ordermodel->where("user_id={$user_id} and pay_status=1 and (status=2 or (tuan_no=0 and status=1)) and deleted=0")->count();
             $page=$this->get_page($count, 10);
             $page_foot=$page->show();//显示页脚信息
             $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.deleted=0 and t1.user_id={$user_id} and t1.pay_status=1 and (t1.status=2 or (t1.tuan_no=0 and t1.status=1)) and t1.goods_id=t2.goods_id")->order('t1.created desc')->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t1.price,t1.dues,t1.tuan_no,t1.tuan_number')->limit($page->firstRow.','.$page->listRows)->select();
             $this->assign('list',$list);
             $this->assign('page_foot',$page_foot);
         }else if($status==='daishouhuo'){
             $selected['daishouhuo']="selected='selected'";//选中下拉菜单的待确认
             $this->assign(selected,$selected);
             $count=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=3 and deleted=0")->count();
             $page=$this->get_page($count, 10);
             $page_foot=$page->show();//显示页脚信息
             $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.deleted=0 and t1.user_id={$user_id} and t1.pay_status=1 and t1.status=3 and t1.goods_id=t2.goods_id")->order('t1.created desc')->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t1.price,t1.dues,t1.tuan_no,t1.tuan_number')->limit($page->firstRow.','.$page->listRows)->select();
             $this->assign('list',$list);
             $this->assign('page_foot',$page_foot);
         }else if($status==='daipingjia'){
             $selected['daipingjia']="selected='selected'";//选中下拉菜单的待评价
             $this->assign(selected,$selected);
             $count=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=4 and deleted=0")->count();
             $page=$this->get_page($count, 10);
             $page_foot=$page->show();//显示页脚信息
             $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.deleted=0 and t1.user_id={$user_id} and t1.pay_status=1 and t1.status=4 and t1.goods_id=t2.goods_id")->order('t1.created desc')->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t1.price,t1.dues,t1.tuan_no,t1.tuan_number')->limit($page->firstRow.','.$page->listRows)->select();
             $this->assign('list',$list);
             $this->assign('page_foot',$page_foot);
         }
         
         
         
         $this->display('index');
    }
    public function quxiao_order(){
        if((!empty($_POST['order_id']))&&$_POST['check']==='quxiao_order'){
            $order_id=$_POST['order_id'];
            $ordermodel=D('Order');
            $row=array(
                'status' => 7
            );
            $order_user_id=$ordermodel->where("order_id=$order_id")->getField('user_id');//登录用户无该订单权限
            if($order_user_id!=$_SESSION['huiyuan']['user_id']){//登录用户无该订单权限
                $result=false;
                $this->ajaxReturn($result);
                exit();
            }
            $result = $ordermodel->where("order_id=$order_id")->save($row);
            $this->ajaxReturn($result);
        }
    }
    
    public function delete_order(){
        if((!empty($_POST['order_id']))&&$_POST['check']==='delete_order'){
            $order_id=$_POST['order_id'];
            $ordermodel=D('Order');
            $row=array(
                'deleted' => 1
            );
            $order_user_id=$ordermodel->where("order_id=$order_id")->getField('user_id');//登录用户无该订单权限
            if($order_user_id!=$_SESSION['huiyuan']['user_id']){//登录用户无该订单权限
                $result=false;
                $this->ajaxReturn($result);
                exit();
            }
            $result = $ordermodel->where("order_id=$order_id")->save($row);
            $this->ajaxReturn($result);
        }
    }
    public function cuihuo(){
        if((!empty($_POST['order_id']))&&$_POST['check']==='cuihuo'){
            $order_id=$_POST['order_id'];
            $ordermodel=D('Order');
            $time=time();
            $order_cuihuo_time=$ordermodel->where("order_id=$order_id")->getField('cuihuo_time');
            if(($order_cuihuo_time+21600)>$time){
                $this->ajaxReturn('亲，6小时内请勿重复催货');
                exit();
            }
            $row=array(
                'cuihuo_time' => $time
            );
            $order_user_id=$ordermodel->where("order_id=$order_id")->getField('user_id');//登录用户无该订单权限
            if($order_user_id!=$_SESSION['huiyuan']['user_id']){//登录用户无该订单权限
                $result=false;
                $this->ajaxReturn($result);
                exit();
            }
            $result = $ordermodel->where("order_id=$order_id")->save($row);
            $this->ajaxReturn($result);
        }
    }
    
    public function view_wuliu() {
        $user_id=$_SESSION['huiyuan']['user_id'];
        $this->assign('user_id',$user_id);
        $order_id=$_GET['order_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->table('m_order t1,m_goods t2')->where("t1.order_id='{$order_id}' and  t1.goods_id=t2.goods_id")->field('t1.user_id,t1.goods_name,t1.shop_name,t2.goods_img,t1.price,t1.buy_number,t1.dues,t1.kuaidi')->find();
        if($order['user_id']===$user_id){
            $this->assign('order',$order);
            $wuliu=  unserialize($order['kuaidi']);
            $this->assign('wuliu',$wuliu);
            $this->display();
        }else{
            $this->error('该订单不存在','/Home/Order/index');
        }
    }
    
    public function view(){
        $user_id=$_SESSION['huiyuan']['user_id'];
        $this->assign('user_id',$user_id);
        $order_id=$_GET['order_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->table('m_order t1,m_goods t2')->where("t1.order_id='{$order_id}' and  t1.goods_id=t2.goods_id")->field('t1.user_id,t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.shop_name,t1.status,t1.pay_status,t1.created,t1.updated,t1.deleted,t2.goods_img,t1.price,t1.dues,t1.order_address,t1.buy_number')->find();
        $usersmodel=D('Users');
        $address=$usersmodel->where("user_id=$user_id")->getField('address');
        $arr_address=  unserialize($address);
        $address=$arr_address[$order['order_address']];
        if($order['user_id']===$user_id){
            $this->assign('order',$order);
            $this->assign('address',$address);
            $this->display('view');
        }else{
            $this->error('该订单不存在','/Home/Order/index');
        }
    }

    public function jiaoyi_success(){
        $this->assign('title','交易完成');
        $order_id=$_GET['order_id'];
        $ordermodel=D('Order');
        $order_user_id=$ordermodel->where("order_id=$order_id")->getField('user_id');//登录用户无该订单权限
        if($order_user_id!=$_SESSION['huiyuan']['user_id']){//登录用户无该订单权限
            $this->error('您没有该订单权限');
        }
        $row=array(
            'status'=>4
        );
        $result=$ordermodel->where("order_id=$order_id")->save($row);
        if(!$result){
            $this->error('确认收货失败！');
        }
        $this->redirect('Order/appraise',array('order_id'=>$order_id));
    }
    
    
    
    
    public function appraise(){
        $this->assign('title','评价');
        $order_id=$_GET['order_id'];
        $this->assign('order_id',$order_id);
        $ordermodel=D('Order');
        $order_user_id=$ordermodel->where("order_id=$order_id")->getField('user_id');//登录用户无该订单权限
        if($order_user_id!=$_SESSION['huiyuan']['user_id']){//登录用户无该订单权限
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
        $this->assign('title','评价成功');
        $order_id=$_GET['order_id'];
        $ordermodel=D('Order');
        $user_id=$_SESSION['huiyuan']['user_id'];
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
                rename($img_url_thumb, str_replace('Public/Uploads/image/temp', UPLOAD.'image/goods',$value));//移动文件
                $value=str_replace('Public/Uploads/image/temp','Public/Uploads/image/goods',$value);  
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
            'updated'=> mktime()
                );
        $ordermodel->where("order_id=$order_id")->save($row);
        
        
        
        //更新商品表里面的分数和评价人数，存入
        $goods_id=$ordermodel->where("order_id=$order_id")->getField('goods_id');//得到商品id
        $array_score=$ordermodel->where("goods_id=$goods_id and status=3")->getField('score',true);
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
        
        $this->redirect('Order/appraise_manage',array('order_id'=>$order_id),0);

    }
    
    public function appraise_manage(){
        $this->assign('title','我已评价');
        $ordermodel=D('Order');
        $user_id=$_SESSION['huiyuan']['user_id'];
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
        $ordermodel=D('Order');
        $order=$ordermodel->table('m_order t1,m_goods t2')->where("t1.order_id={$order_id}  and t1.goods_id=t2.goods_id")->field('t1.user_id,t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.shop_name,t1.status,t1.pay_status,t1.created,t1.updated,t1.deleted,t2.goods_img,t1.price,t1.dues')->find();
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
            $this->display();
        }else{
            $this->error('该订单不存在','/Home/Order/index');
        }
    }
    
    public function shouhou_check() {
        $order_id=$_POST['order_id'];
        if(empty($order_id)){
            $this->error('订单号不存在');
        }
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id=$order_id")->field("user_id,shop_name,goods_id,dues")->find();
        $order_user=$order['user_id'];
        $user_id=$_SESSION['huiyuan']['user_id'];
        if($order_user!==$user_id){
            $this->error('您没有该订单');
        }
        $usersmodel=D('Users');
        $order_row=array(
            'pay_status'=>3,
            'tuikuang_cause'=>$_POST['cause']
        );
                $ordermodel->where("order_id=$order_id")->save($order_row);
                $usersmodel->where("user_id=$order_user")->setInc( 'credit_line',$order['dues']);
                $this->ajaxReturn('success');
           
                
            
        
    }
    
    
    public function get_new_order(){
        $time=  cookie('time');
        $ordermodel=D('Order');
        if((!cookie('new_order'))||cookie('new_order')==='a:0:{}'){
            $time=time();
            cookie('time',$time);
            if(!cookie('newest_order_id')){
                $new_order=$ordermodel->order('order_id desc')->field('order_id,user_id,created,order_address')->limit(6)->select();
                $str_new_order=  serialize($new_order);
                cookie('new_order',$str_new_order); 
                cookie('newest_order_id',$new_order[0]['order_id']);//记录最后一条order_id
            }else{
                $newest_order_id=  cookie('newest_order_id');
                $new_order=$ordermodel->where("order_id>$newest_order_id")->order('order_id desc')->field('order_id,user_id,created,order_address')->limit(6)->select();
                if(!$new_order[0]){
                    $this->ajaxReturn('0');exit();
                }
                $str_new_order=  serialize($new_order);
                cookie('new_order',$str_new_order);
                cookie('newest_order_id',$new_order[0]['order_id']);//记录最后一条order_id
            }
        }
        $arr_cookie=  unserialize(cookie('new_order'));
        $user=array_pop($arr_cookie);
        cookie('new_order',serialize($arr_cookie));
        $data=$this->get_user($user);
        $this->ajaxReturn($data);

    }
    
    
    private function get_user($new_order){
        $usersmodel=D('Users');
        $user_id=$new_order['user_id'];
        $order_address=$new_order['order_address'];
        $user=$usersmodel->where("user_id=$user_id")->field('user_name,address,head_url')->find();
        $arr_address=  unserialize($user['address']);
        $address=$arr_address[$order_address];
        $arr_location=  explode(' ', $address['location']);
        $location=$arr_location[1];
        $shijian=$this->shijian($new_order['created']);
        $data=array(
            'head_url'=>$user['head_url'],
            'text'=>'最新订单来自 '.$location.' 的 '.$user['user_name'].',  '.$shijian.'前'
        );
        return $data;
    }
    
    private function shijian($time){
        $second=time()-$time;
        if($second<60){
            $shijian=$second.'秒';
        }elseif($second<3600){
            $shijian=floor($second/60).'分钟';
        }elseif($second<86400){
            $shijian=floor($second/3600).'小时';
        }else{
            $shijian=floor($second/86400).'天';
        }
        return $shijian;
    }
    
}