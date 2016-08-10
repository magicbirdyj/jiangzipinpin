<?php
header("content-type:text/html;charset=utf-8");
include "./TopSdk.php";
date_default_timezone_set('Asia/Shanghai'); 

$appkey="23304840";
$secret="57d27c01c6d3f9af602de646019c4e3b";
    

$c = new TopClient;
$c->appkey = $appkey;
$c->secretKey = $secret;
$c->format='json';
$req = new AlibabaAliqinFcSmsNumSendRequest;
$req->setExtend("123456");
$req->setSmsType("normal");
$req->setSmsFreeSignName("一起网");
$req->setSmsParam("{\"code\":\"921314\",\"product\":\"一起网\",\"item\":\"一起网\"}");
$req->setRecNum("13574506835");
$req->setSmsTemplateCode("SMS_4705353");
//$req->
$resp = $c->execute($req);
var_dump($resp);

?>