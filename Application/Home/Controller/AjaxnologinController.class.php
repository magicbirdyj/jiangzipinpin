<?php
namespace Home\Controller;
use  Home\Controller;
class AjaxnologinController extends FontEndController {

   

    public function address_tiaozhuan() {
        $a=urlencode("http://m.jiangzipinpin.com/Home/Member/address_manage");
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx91953340c19f656e&redirect_uri=".$a."&response_type=code&scope=snsapi_base&state=1#wechat_redirect";
        header("Location:{$url}"); 
        exit();
    }
    
    public function buy_tiaozhuan() {
        $get=$_GET;
        $fanhui=U('Goods/buy',$get);
        $a=urlencode("http://m.jiangzipinpin.com".$fanhui);
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx91953340c19f656e&redirect_uri=".$a."&response_type=code&scope=snsapi_base&state=1#wechat_redirect";
        header("Location:{$url}"); 
        exit();
    }
    
    public function send_fanxianxiaoxi(){
        $post=$_POST;
        if($post['check']!='send_fanxianxiaoxi'){
            exit;
        }
        $order_id=$post['order_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id=$order_id")->find();
        if($order['fenxiang']=='1'){
            exit;//已经分享了直接退出
        }
       
                
        $user_id=$order['user_id'];
        $usersmodel=D('Users');
        $url='';
        $open_id=$usersmodel->where("user_id=$user_id")->getField('open_id');
        $template_id="C0pRziUD3HWFVJJEjlLAjtyK5eP53AoPqW5OJ9PBs14";
        $arr_data=array(
            'first'=>array('value'=>$post['first'],"color"=>"#666"),
            'keyword1'=>array('value'=>$post['cause'],"color"=>"#F90505"),
            'keyword2'=>array('value'=>$post['dues'].'元',"color"=>"#666"),
            'keyword3'=>array('value'=>"直接到帐","color"=>"#666"), 
            'remark'=>array('value'=>"感谢您的分享推荐","color"=>"#F90505")
        );
        $this->response_template($open_id, $template_id, $url, $arr_data);
    }
    
    public function send_red_pack() {
        $post=$_POST;
        if($post['check']!='send_red_pack'){
            exit;
        }
        $order_id=$post['order_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id=$order_id")->find();
        if($order['fenxiang']=='1'){
            exit;//已经分享了直接退出
        }
        //把订单分享字段改为1
        $row=array(
            'fenxiang'=>1
        );
        $ordermodel->where("order_id=$order_id")->save($row);
                
        $user_id=$order['user_id'];
        $usersmodel=D('Users');
        $url='';
        $open_id=$usersmodel->where("user_id=$user_id")->getField('open_id');
        vendor('wxp.native'); //引入第三方类库
        $sendRedPackInput = new \WxPaySendRedPack();
        //现金红包 
        $total_amount=$post['dues'];
        $send_name=$order['shop_name'];
        $sendRedPackInput->SetTotal_amount($total_amount*100);//红包金额 int
        $sendRedPackInput->SetRe_openid($open_id);//接收红包用户
        $sendRedPackInput->SetSend_name($send_name);//接收红包用户
        $sendRedPackInput->SetTotal_num(1);//红包发放总人数
        $sendRedPackInput->SetWishing("感谢您的分享");//红包祝福语
        $sendRedPackInput->SetAct_name('分享返现红包');//活动名称
        $sendRedPackInput->SetRemark('就是如此任性！只需分享，就能拿红包');//备注
        $sendRedPackInfo = \WxPayApi::sendredpack($sendRedPackInput, 300);
    }
    
}


