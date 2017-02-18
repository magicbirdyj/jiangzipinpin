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
            $resultStr=$this->response_arr_image_text($postObj);//分情况发送图文消息
            echo $resultStr;
        }else{
            $content='联系客服，请点击下方按钮：  平台服务>>联系客服';
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
        $newsTplHead = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[news]]></MsgType>
                <ArticleCount>%d</ArticleCount>
                <Articles>";
        //具体内容数组
        $count=4;
        $header = sprintf($newsTplHead, $object->FromUserName, $object->ToUserName, time(),$count); 
        //构建内容数组$arr_content
        $arr_content=array();
        $arr_content[0]['Title']='【点击抽奖】立即获得首单免费或洗衣优惠券';
        $arr_content[0]['PicUrl']='http://m.jiangzipinpin.com'.'/Public/Home/Mobile/Images/public/image_text_news/xiyi.jpg';
        $arr_content[0]['Url']='m.jiangzipinpin.com'.U('Advert/fengxiang_choujiang');
        
        $arr_content[1]['Title']='洗衣低至9元起，一件也上门，点我立即下单';
        $arr_content[1]['PicUrl']='http://m.jiangzipinpin.com'.'/Public/Home/Mobile/Images/public/image_text_news/index.jpg';
        $arr_content[1]['Url']='http://m.jiangzipinpin.com';
        
        $arr_content[2]['Title']='洗衣新模式，58元/袋，装多少洗多少';
        $arr_content[2]['PicUrl']='http://m.jiangzipinpin.com'.'/Public/Home/Mobile/Images/public/image_text_news/daizi.jpg';
        $arr_content[2]['Url']='http://m.jiangzipinpin.com';
        
        $arr_content[3]['Title']='十五道衣味，精心呵护您的爱衣';
        $arr_content[3]['PicUrl']='http://m.jiangzipinpin.com'.'/Public/Home/Mobile/Images/public/image_text_news/yiwei.jpg';
        $arr_content[3]['Url']='http://m.jiangzipinpin.com';
        
        
        // 转换成xml结构中的item
        $body='';
        foreach ($arr_content as $value) {
            $body.=$this->ToXml_item($value);
        }
        $footer = "</Articles>
                </xml>";
        return $header.$body.$footer;
    }


    


    //多图文消息中，内容数组转XML中的<item></item> 
    private function ToXml_item($arr){
        if(!is_array($arr)|| count($arr) <= 0){
            $this->error("数组数据异常！");
        }
    	$xml = "<item>";
    	foreach ($arr as $key=>$val)
    	{
    		if (is_numeric($val)){
    			$xml.="<".$key.">".$val."</".$key.">";
    		}else{
    			$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
    		}
        }
        $xml.="</item>";
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
                        "name":"立即洗衣",
                        "sub_button":[
                        {
                            "type":"view",
                            "name":"新用户抽奖",
                            "url":"http://m.jiangzipinpin.com/Home/Advert/fengxiang_choujiang.html"
                        },
                        {
                            "type":"view",
                            "name":"洗衣价目表",
                            "url":"http://m.jiangzipinpin.com"
                        },
                        {
                        "type":"view",
                        "name":"立即预约",
                        "url":"http://m.jiangzipinpin.com/Home/Goods/buy.html"
                        }]
                    },
                    {
                        "type":"view",
                        "name":"进入衣干净",
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