<?php
namespace Home\Controller;
use Think\Controller;
class TestController extends Controller {
   
    //ceshi
    public function index(){
        file_put_contents("./Public/Uploads/weixinzhifu.txt", print_r($_POST,TRUE)."\r\n",FILE_APPEND);
    }
    

}