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
           
	if($msgType=='event'&&$keyword=='subscribe'){
            $resultStr=$this->panduan_guanzhu_leixin($postObj);//分情况发送图文消息
            echo $resultStr;
        }else{
            $content='联系客服，请点击下方按钮>>平台服务>>联系客服';
            $resultStr=$this->response_text($postObj, $content);
             echo $resultStr;
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
        $usersmodel=D('Users');
        $url=$usersmodel->where("open_id='$open_id'")->getField('url');
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
        $goods['goods_img']=$this->get_thumb($goods['goods_img']);
        $goods['goods_img']='http://m.jiangzipinpin.com'.$goods['goods_img'];
        $goods['url']='m.jiangzipinpin.com'.$url;
        return $goods;
    }
    
    //商品图片得到缩略图地址
    private function get_thumb($goods_img){
            $index=strripos($goods_img,"/");
            $img_url=substr($goods_img,0,$index+1);
            $img_name=substr($goods_img,$index+1);
            return($img_url.'thumb/'.$img_name); 
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
    private function response_image_text($object){
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
        $user_name=$this->get_user($object->FromUserName);
        $title =$user_name. "，酱紫终于等到你，点击继续购买";
        $goods=$this->get_goods_infor($object->FromUserName);
        $description=$goods[ 'goods_name'].'( 团购价：¥'.$goods['tuan_price'].')，点击继续拼团';
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, $time, $hui_msgType, $articleCount,$title,$description,$goods['goods_img'],$goods['url']);
        return $resultStr;
    }
    
    //  发送多图文信息
    private function response_arr_image_text($object){
        $arr_textTpl=array();
        $arr_textTpl['ToUserName']=$object->FromUserName;
        $arr_textTpl['FromUserName']=$object->ToUserName;
        $arr_textTpl['CreateTime']=time();
        $arr_textTpl['MsgType']="news";
        $arr_textTpl['ArticleCount']=3;
        $arr_textTpl['ToUserName']=$object->FromUserName;
        $arr_textTpl['ToUserName']=$object->FromUserName;
        $arr_textTpl['ToUserName']=$object->FromUserName;
    }


    //判断关注前有没有浏览商品或者拼团信息，没有的话 发多图文 有的话 发商品或拼团链接ss
    private function panduan_guanzhu_leixin($postObj){
        $open_id=$postObj->FromUserName;
        $usersmodel=D('Users');
        $url=$usersmodel->where("open_id=$open_id")->getField('url');
        if($url){
            $this->response_image_text($postObj);
        }else{
            $this->response_arr_image_text($postObj);
        }
    }


    //数组转XML
    private function ToXml($arr)
	{
		if(!is_array($arr) 
			|| count($arr) <= 0)
		{
    		$this->error("数组数据异常！");
    	}
    	
    	$xml = "<xml>";
    	foreach ($this->values as $key=>$val)
    	{
    		if (is_numeric($val)){
    			$xml.="<".$key.">".$val."</".$key.">";
    		}else{
    			$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
    		}
        }
        $xml.="</xml>";
        return $xml; 
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
    
    
   public function creat_menu() {
       $data='{
                "button":[
                    {
                        "type":"view",
                        "name":"1元购",
                        "url":"http://m.jiangzipinpin.com"
                        
                    },
                    {
                        "type":"view",
                        "name":"进入商城",
                        "url":"http://m.jiangzipinpin.com"
                    },
                    {
                        "name":"平台服务",
                        "sub_button":[
                        {
                            "type":"view",
                            "name":"会员中心",
                            "url":"http://m.jiangzipinpin.com/Home/Member/index.html"
                        },
                        {
                            "type":"view",
                            "name":"联系客服",
                            "url":"http://m.jiangzipinpin.com"
                        }]
                    }]
                }';
       $this->s_access_token();
       $access_token=S('access_token');
       $MENU_URL="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
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

        var_dump($info);
   }
}