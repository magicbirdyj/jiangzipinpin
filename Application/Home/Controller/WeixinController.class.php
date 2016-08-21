<?php
namespace Home\Controller;
use Home\Controller;
class WeixinController extends FontEndController {
    public function index(){
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (empty($postStr)){
            echo '';
            exit;
        }
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $msgType=$postObj->MsgType;
        if($msgType=='event'){//事件类型通知
            $keyword = $postObj->Event;
        }elseif($msgType=='text'){
            $keyword = trim($postObj->Content);
        }
           
	if(($msgType=='event'&&$keyword=='subscribe')||$keyword!=''){
              		$resultStr=$this->response_image_text($postObj);
                        //$content=$postObj->Content;
                        //$resultStr=$this->response_text($postObj, $content);
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }
        
    }
   
   
     public function get_user($open_id){
        //获取微信access_token
        $this->s_access_token();
        $access_token=S('access_token');
        $userinfo=$this->get_userinfo($open_id,$access_token);
        $user_name=$userinfo['nickname'];
        return $user_name;  
          
        }
        
        
        
    private function get_userinfo($openid,$access_token){
       $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN" ;
       $res = file_get_contents($url); //获取文件内容或获取网络请求的内容
       $result = json_decode($res, true);//接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
       return $result;
    }
    
    private function get_goods_infor($open_id) {
        //'/Home/Goods/index/goods_id/221'
        $usersmodel=D('Users');
        $url=$usersmodel->where("open_id=$open_id")->getFiled('url');
        $arr_url=explode("/",$url);
        $value=array_pop($arr_url);
        $key=array_pop($arr_url);
        $goodsmodel=D('Goods');
        if($key=='goods_id'){
            $goods_id=$value;
        }elseif($key=='tuan_no'){
            $tuan_no=$value;
            $ordermodel=D(Order);
            $goods_id=$ordermodel->where("tuan_no=$tuan_no")->getField('goods_id');
        }
        $goods=$goodsmodel->where("goods_id=$goods_id")->field('goods_name,goods_img_qita,tuan_price')->find();
        $goods['goods_img']=  unserialize($goods['goods_img_qita']);
        $goods['goods_img']=$goods['goods_img'][0];
        $goods['goods_img']='m.jiangzipinpin.com'.$goods['goods_img'];
        $goods['url']='m.jiangzipinpin.com'.$_SESSION['ref'];
        return $goods;
        
    }
    
    
    //发送文本消息 
    private function response_text($object,$content){
        $time = time();
        $textTpl = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                </xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, $time, $content);
        return $resultStr;
    }
    
    
    
    //发送图文消息
    public function response_image_text(){
        $time = time();
        $textTpl = "<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[%s]]></MsgType>
                <ArticleCount>%d</ArticleCount>
                <Articles>
                <item>
                <Title><![CDATA[%s]]></Title> 
                <Description><![CDATA[%s]]></Description>
                <PicUrl><![CDATA[%s]]></PicUrl>
                <Url><![CDATA[%s]]></Url>
                </item>
                </Articles>
		</xml>";         
        $hui_msgType = "news";
        $articleCount=1;//图文消息的条数
        $open_id='oSI43woDNwqw6b_jBLpM2wPjFn_M';
        //$user_name=$this->get_user($object->FromUserName);
        $user_name=$this->get_user($open_id);
        $title =$user_name. "，酱紫终于等到你，点击继续购买";
        //$goods=$this->get_goods_infor($object->FromUserName);
        $goods=$this->get_goods_infor($open_id);
        $description=$goods['goods_name'].'[ 团购价：&yen;'.$goods['tuan_price'].']，点击继续拼团';
        $resultStr = sprintf($textTpl, $object->fromUsername, $object->toUsername, $time, $hui_msgType, $articleCount,$title,$description,$goods['goods_img'],$goods['url']);
        var_dump($resultStr);
        return $resultStr;
    }
    
    
    
    
    
    
    
    
    
     /*
        $echoStr = $_GET["echostr"];
        if($echoStr){
            if($this->checkSignature()){
            echo $echoStr;
            exit;
            }
        }
         */
    /*
    private function checkSignature(){
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"]; 
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
    */
}