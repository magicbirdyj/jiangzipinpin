<?php
namespace Home\Controller;
use Home\Controller;
class WeixinController extends FontEndController {
    public function index(){
        //$echoStr = $_GET["echostr"];
        //if($echoStr){
            //if($this->checkSignature()){
            //echo $echoStr;
            //exit;
            //}
        //}
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (empty($postStr)){
            echo '';
            exit;
        }
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $msgType=$postObj->MsgType;
        if($msgType=='event'){//事件类型通知
            $keyword = $postObj->Event;
        }elseif($msgType=='text'){
            $keyword = trim($postObj->Content);
        }
        $time = time();
        $textTpl = "<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[%s]]></MsgType>
		<Content><![CDATA[%s]]></Content>
		<FuncFlag>0</FuncFlag>
		</xml>";             
	if($msgType=='event'&&$keyword=='subscribe')//关注事件
                {
              		$hui_msgType = "text";
                	$contentStr = "感谢您的关注";
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $hui_msgType, $contentStr);
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }
        
    }
   
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
    
    public function ceshi(){
        $xmlstring=<<<XML
            <xml>
                <ToUserName>George</ToUserName>
                <FromUserName><![CDATA[FromUser]]></FromUserName>
                <CreateTime>123456789</CreateTime>
                <MsgType><![CDATA[event]]></MsgType>
                <Event><![CDATA[subscribe]]></Event>
            </xml>
XML;
                
        $xml_oblect = simplexml_load_string($xmlstring);
        var_dump($xml_oblect->ToUserName);
    }
    
    
    
}