<?php
namespace Home\Controller;
use  Home\Controller;
class AjaxnologinController extends FontEndController {
    //发送信息
    public function send_message(){
        if($_POST['check']==='send_message'){
            $shoujihao=$_POST['shoujihao'];
            vendor('taobaoali.TopSdk');//引入第三方类库
            date_default_timezone_set('Asia/Shanghai'); 
            $appkey="23461151";
            $secret="32eff9693ac48fcee386923dc45e3f8c";
            $c = new \TopClient;
            $c->appkey = $appkey;
            $c->secretKey = $secret;
            $c->format='json';
            $req = new \AlibabaAliqinFcSmsNumSendRequest;
            $req->setExtend("123456");
            $req->setSmsType("normal");
            $req->setSmsFreeSignName("衣干净");
            $rand=rand(100000,999999);
            $_SESSION['send_message']="$rand";
            $req->setSmsParam("{\"name\":\"衣干净\",\"code\":\"$rand\"}");
            $req->setRecNum($shoujihao);
            $req->setSmsTemplateCode("SMS_34840303");
            $resp = $c->execute($req);
            $data=$resp->result->success;
            $this->ajaxReturn($data);
            exit();
       }else if($_POST['check']=='yanzheng_message'){
           $yanzhengma=$_POST['yanzhengma'];
           if($yanzhengma===$_SESSION['send_message']){
               $data=true;
           }else{
               $data=false;
           }
           $this->ajaxReturn($data);
           exit();
       }else{
           exit();
       }
    }
    
    
   

    public function address_tiaozhuan() {
        $a=urlencode("http://m.jiangzipinpin.com/Home/Member/address_manage");
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx91953340c19f656e&redirect_uri=".$a."&response_type=code&scope=snsapi_base&state=1#wechat_redirect";
        if(is_weixin()){
            header("Location:{$url}");
        }else{
            header("Location:{$_SESSION['ref']}");
        }
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
    
  
    
    public function send_red_pack() {
        $post=$_POST;
        if($post['check']!='send_red_pack_921314'){
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
        $this->ajaxReturn($sendRedPackInfo);
    }
    
    public function send_shop_xiaoxi_red() {
        $post=$_POST;
        if($post['check']!='send_shop_xiaoxi'){
            exit;
        }
        $order_id=$post['order_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id=$order_id")->find();
        $user_id=$order['user_id'];
        $usersmodel=D('Users');
        $user_name=$usersmodel->where("user_id=$user_id")->getField('user_name');
        $shop_id=$order['shop_id'];
        $shopsmodel=D('Shops');
        $shop=$shopsmodel->where("shop_id=$shop_id")->field('open_id,shop_name')->find();
        $template_id="TPVNrYikBGkS3KaFcVbdzBjqnurjBHhOOjOE0JjC4OM";
        $url=U('Shop/view_order',array('order_id'=>$order_id));
        $remark="红包金额将从您的收入中减去,点击查看该订单详情";
        $arr_data=array(
            'first'=>array('value'=>"恭喜您，".$user_name."成功分享了您的商品：".$order['goods_name'],"color"=>"#666"),
            'keyword1'=>array('value'=>$order['order_no'],"color"=>"#666"),
            'keyword2'=>array('value'=>$order['price'],"color"=>"#666"),
            'keyword3'=>array('value'=>date('Y/m/d H:i:s',$order['updated']),"color"=>"#666"),
            'keyword4'=>array('value'=>$order['fenxiang_dues'],"color"=>"#666"),
            'remark'=>array('value'=>$remark,"color"=>"#F90505")
        );
        $this->response_template($shop['open_id'], $template_id, $url, $arr_data);
    }
    
    public function get_shuxing() {
        $post=$_POST;
        if($post['check']!='get_shuxing'){
            exit;
        }
        $cat_id=$post['cat_id'];
        $categorymodel=D('Category');
        $data_cat=$categorymodel->where("cat_id='$cat_id'")->getField('shuxing');
        $arr_shuxing=unserialize($data_cat);//得到反序列化属性数组
        foreach ($arr_shuxing as $key => $value) {
            $str.='<div class="tr shuxing"><div class="tr_td1">'.$key.'</div><div class="tr_td2"><select name="shuxing[]" class="release_select" >';
            foreach ($value as $v) {
                $str.='<option value="'.$v.'">'.$v.'</option>';
            }
            $str.='</select></div></div>';
        }
        $this->ajaxReturn($str);
    }
    
    
    public function ceshi() {
        delayed(1);
    }
    
}


