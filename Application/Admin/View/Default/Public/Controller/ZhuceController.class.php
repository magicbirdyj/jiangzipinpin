<?php

namespace Home\Controller;

use Home\Controller;

class ZhuceController extends FontEndController {


    public function index() {
        $time=gettime();
        $_SESSION['zhuce1']=$time;
        $this->assign("title", "新用户注册：设置用户名");
        $this->assign("time", $time);
        $this->display('index');
    }

    public function zhuce2() {
        if(!empty($_POST['hidden'])&&!empty($_SESSION['zhuce1'])){
            $hidden=$_POST['hidden'];
            if($hidden==$_SESSION['zhuce1']){
                $this->assign("title", "新用户注册：填写账户信息");
                $this->assign("dlm", $_POST['shoujihao']);
                $time2=gettime();
                $this->assign("time2", $time2);
                $this->display();
                unset($_SESSION['zhuce1']);
                $_SESSION['zhuce2']=$time2;
                $_SESSION['dlm']=$_POST['shoujihao'];
            }else{
                redirect(U('zhuce/index'),1,'您中途打开了另一个注册页面，将重新刷新页面');
            }
        }else{
            redirect(U('index/index'),1,'请从注册页面进入');

        }
    }

    public function zhuce3() {
         if(!empty($_POST['hidden'])&&!empty($_SESSION['zhuce2'])){
             if($_POST['shoujiyanzheng']!==$_SESSION['send_message']){
                 redirect(U('zhuce/index'),1,'手机验证码错误，请重新注册');
                 exit();
             }
            $usersmodel=D('Users');
            $hidden=$_POST['hidden'];
            $dlm=$_SESSION['dlm'];
            $hym=$_POST['huiyuanming'];
            $password=$_POST['shezhimima'];
            $salt=  create_char(6);
            $password_md5=  md5($password.$salt);
            if($hidden==$_SESSION['zhuce2']){
                $count=$usersmodel->where("mobile_phone='{$dlm}'")->count();
                if(!is_shoujihao($dlm)||$count!=='0') {
                     $this->error('手机号错误或者已被注册，请重新注册',U('zhuce/index'),3);
                     exit();
                }
                $count1=$usersmodel->where("user_name='{$hym}'")->count();
                if(is_feifa($hym)||$count1!=='0'){
                    $this->error('会员名含有非法字符或者已被注册，请重新注册',U('zhuce/index'),3);
                    exit();
                }
                $row=array(
                    'mobile_phone'=>$dlm,
                    'user_name'=>$hym,
                    'password'=>$password_md5,
                    'zhifu_password'=>$password_md5,//初始支付密码等于登录密码
                    'last_login'=>mktime(),
                    'salt'=>$salt,
                    'head_url'=>'/Public/Home/Images/public/man.png',//给个默认的头像
                    'reg_time'=>  mktime()
                );
                if($_SERVER['REMOTE_ADDR']){
                    $row['last_ip']=$_SERVER['REMOTE_ADDR'];
                }
                $result=$usersmodel->add($row);//注册信息写入数据库
                if($result){
                    $this->assign("title", "新用户注册：注册完成");
                    $this->assign("dlm", $dlm);
                    $this->assign("hym",$hym);
                    $this->display();
                    $id=$usersmodel->where("user_name='{$hym}'")->getField('user_id');
                    $smid=$usersmodel->where("user_name='{$hym}'")->getField('shopman_id');
                    $_SESSION['huiyuan']=array(
                        'user_id'=>$id,
                        'user_name'=>$hym,
                        'shopman_id'=>$smid
                            );
                    unset($_SESSION['zhuce2']);
                }else{
                    redirect(U('zhuce/index'),1,'注册失败，请重新注册');
                }
            }else{
               redirect(U('zhuce/index'),1,'您中途打开了另一个注册页面，将重新刷新页面');
            }
        }else{
            redirect(U('index/index'),1,'请从注册页面进入');

        }
        
    }

    public function zhuce4() {
        //判断是否登录
        if (isset($_SESSION['huiyuan']) && $_SESSION['huiyuan'] !== '') {
            //判断是否已经是商家
            if($_SESSION['huiyuan']['shopman_id']==='1'){
                header("location:". U("Member/hunlirenshangjiaxinxi"));
                exit();
            }
            $this->assign("title", "成为婚礼人");
            $this->display(zhuce4);
        }else{
           redirect(U('Login/index'),1,'请先登录');
        }
        
    }
    
    public function zhuce4_check(){
        //如果已经是婚礼人了  直接跳过
        if($_SESSION['huiyuan']['shopman_id']==='1'){
            header("location:". U("Member/hunlirenshangjiaxinxi"));
            exit();
        }
        //当有文件没有上传时，提示并返回
        if(empty($_POST['member_file_touxiang'])){
            $this->error('未选择上传头像');
        }
        //身份证以后再验证
        //if(empty($_POST['member_file_shenfenzheng'])){
            //$this->error('未选择上传身份证照片');
        //}
        //移动文件 并且改变url
        $today=substr($_POST['member_file_touxiang'],26,8);//获取到文件夹名  如20150101
        creat_file(UPLOAD.'image/member/'.$today);//创建文件夹（如果存在不会创建）
        rename($_POST['member_file_touxiang'], str_replace('Public/Uploads/image/temp', UPLOAD.'image/member',str_replace('thumb/','',$_POST['member_file_touxiang'])));//移动文件
        $head_url='/'.str_replace('Public/Uploads/image/temp', UPLOAD.'image/member',str_replace('thumb/','',$_POST['member_file_touxiang']));
       
        $today=substr($_POST['member_file_shenfenzheng'],26,8);//获取到文件夹名  如20150101
        creat_file(UPLOAD.'image/hunliren/'.$today);//创建文件夹（如果存在不会创建）
        rename($_POST['member_file_shenfenzheng'], str_replace('Public/Uploads/image/temp', UPLOAD.'image/hunliren',$_POST['member_file_shenfenzheng']));//移动文件
        $shenfenzheng_url='/'.str_replace('Public/Uploads/image/temp', UPLOAD.'image/hunliren',$_POST['member_file_shenfenzheng']);
        if(!empty($_POST['member_file_erweima'])){
            $today=substr($_POST['member_file_erweima'],26,8);//获取到文件夹名  如20150101
            creat_file(UPLOAD.'image/hunliren/'.$today);//创建文件夹（如果存在不会创建）
            rename($_POST['member_file_erweima'], str_replace('Public/Uploads/image/temp', UPLOAD.'image/hunliren',$_POST['member_file_erweima']));//移动文件
            $weixin_erweima='/'.str_replace('Public/Uploads/image/temp', UPLOAD.'image/hunliren',$_POST['member_file_erweima']);
        }else{
            $weixin_erweima='';
        }
        
            
        $serverform=intval($_POST['radio_fuwuxingshi']);//获取服务形式
        //当服务形式为公司，至少必须上传3个图片文件，否则提示并且返回
       //if($serverform===2){
            //if(count($file_info)<3){
                //$this->error('有选现未选择文件');
                //exit();
            //}
        //}
        $sex=  intval($_POST['radio_sex']);//获取性别
        $name=$_POST['name'];//获取真实姓名
        $province=$_POST['address_province'];//获取省份
        //如果没选择省份，提示并退出
        if($province==='请选择省市'||empty($province)){
            $this->error('未选择所在省市');
            exit();
        }else{//获取城市和县城
            $city=$_POST['address_city'];
            $county=$_POST['address_county'];
        }
        $address=$_POST['address_juti'];//获取详细地址
        $qq=$_POST['contact_qq'];//获取QQ号码
        $weixin=$_POST['contact_weixin'];//获取微信号码
        $email=$_POST['contact_email'];//获取邮箱
        $shop_introduce=$_POST['shop_introduce'];//获取店铺介绍
        $fuwuneirong=$_POST['fuwuneirong'];//获取服务内容
        //服务内容未选择时，提示并退出
        if(empty($email)||empty($fuwuneirong)||empty($weixin)||empty($qq)||empty($address)||empty($name)||empty($shop_introduce)){
            $this->error('有内容未填写');
            exit();
        }
        $fuwuneirong=  implode('|', $fuwuneirong);//把服务内容数组变成字符串
        //邮箱是否正确
        if(is_youxiang($email)){
            $this->error('邮箱不正确');
            exit();
        }
        //任何文本框如果含有非法字符，提示并退出
        if(is_feifa($weixin)||is_feifa($qq)||is_feifa($address)||is_feifa($name)||is_feifa($shop_introduce)){
            $this->error('有内容含有非法字符');
            exit();
        }

        
        //准备需要写进数据库的数组
        $user_id=intval($_SESSION['huiyuan']['user_id']);//获取会员id号
        $row=array(
            'head_url'=>$head_url,
            'shenfenzheng_url'=>$shenfenzheng_url,
            'sex'=>$sex,
            'server_form'=>$serverform,
            'true_name'=>$name,
            'location'=>$province.'|'.$city.'|'.$county,
            'address'=>$address,
            'qq'=>$qq,
            'weixin'=>$weixin,
            'email'=>$email,
            'server_content'=>$fuwuneirong,
            'shopman_id'=>1,
            'shop_introduce'=>$shop_introduce,
            'weixin_erweima'=>$weixin_erweima,
            'shopman_reg_time'=>  mktime()
        );
        //如果上传了营业执照照片，写进数组
        //if(isset($file_info['file_yingyezhizhao'])){
            //$yingyezhizhao_url=UPLOAD.$file_info['file_yingyezhizha']['savepath'].$file_info['file_yingyezhizha']['savename'];
            //$row['yingyezhizhao_url']='/'.$yingyezhizhao_url;
        //}
        //写入数据库
        $usersmodel=D('Users');
        $result=$usersmodel->where("user_id={$user_id}")->save($row);
        if($result!==false){
            $_SESSION['huiyuan']['shopman_id']='1';
            header("location:". U("Member/hunlirenshangjiaxinxi"));
            exit();
        }else{
            $this->error('更新数据库失败');
            exit();
        }
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
        $data=array(
            'file_touxiang'=>UPLOAD.$file_info[1]['file_touxiang']['savepath'].$file_info[1]['file_touxiang']['savename'],
            'file_shenfenzheng'=>UPLOAD.$file_info[1]['file_shenfenzheng']['savepath'].$file_info[1]['file_shenfenzheng']['savename'],
            'file_erweima'=>UPLOAD.$file_info[1]['file_erweima']['savepath'].$file_info[1]['file_erweima']['savename']
        );
        

            if($data['file_touxiang']!=='Public/Uploads/'){
                $index=strripos($data['file_touxiang'],"/");
                $img_url=substr($data['file_touxiang'],0,$index+1);
                $img_name=substr($data['file_touxiang'],$index+1);
                $this->thumb($img_url,$img_name, 'file_touxiang');//创建图片的缩略图
                $data['file_touxiang_thumb']=$img_url.'thumb/'.$img_name;
            }
           if($data['file_shenfenzheng']!=='Public/Uploads/'){
                $index=strripos($data['file_shenfenzheng'],"/");
                $img_url=substr($data['file_shenfenzheng'],0,$index+1);
                $img_name=substr($data['file_shenfenzheng'],$index+1);
                $this->thumb($img_url,$img_name, 'file_shenfenzheng');//创建图片的缩略图
                $data['file_shenfenzheng_thumb']=$img_url.'thumb/'.$img_name;
            }
            if($data['file_erweima']!=='Public/Uploads/'){
                $index=strripos($data['file_erweima'],"/");
                $img_url=substr($data['file_erweima'],0,$index+1);
                $img_name=substr($data['file_erweima'],$index+1);
                $this->thumb($img_url,$img_name, 'file_erweima');//创建图片的缩略图
                $data['file_erweima_thumb']=$img_url.'thumb/'.$img_name;
            }

                    
        $this->ajaxReturn($data,'JSON');
    }


    private function thumb($url,$name,$leixing){
        $image = new \Think\Image(); 
        $image->open($url.$name);
        creat_file($url.'thumb');//创建文件夹（如果存在不会创建）
        if($leixing==='file_touxiang'){
            $image->thumb(200, 200,\Think\Image::IMAGE_THUMB_CENTER)->save($url.'thumb/'.$name);
        }else{
            $image->thumb(100, 100,\Think\Image::IMAGE_THUMB_FILLED)->save($url.'thumb/'.$name);
        }

    }

    public function getCode(){
        $config =    array(   
            'expire'      =>    120,    //验证码有效期
            'fontSize'    =>    18,    // 验证码字体大小   
            'length'      =>    4,     // 验证码位数   
            'imageW'    =>    160, // 验证码宽度 设置为0为自动计算
            'imageH'    =>    34, // 验证码高度 设置为0为自动计算
            'useNoise'=> false,//关闭杂点
        );
       $Verify = new \Think\Verify($config);
       $Verify->entry();
    }
    
    public function check(){
        if($_POST['check']=='yanzhengma'){
            $code=$_POST['yanzhengma'];
            $data =check_verify($code);
            $this->ajaxReturn($data);
            exit();
       }elseif($_POST['check']=='shoujihao'){
            $shoujihao=$_POST['shoujihao'];
            $usesmodel=D('Users');
            $data=$usesmodel->where("mobile_phone={$shoujihao}")->count();
            $this->ajaxReturn($data);
            exit();
       }elseif($_POST['check']=='huiyuanming'){
            $huiyuanming=$_POST['huiyuanming'];
            $usesmodel=D('Users');
            $data=$usesmodel->where("user_name='{$huiyuanming}'")->count();
            $this->ajaxReturn($data);
            exit();
       }
       else{
           exit();
       }
    }

     
    public function send_message(){
        if($_POST['check']==='send_message'){
            $shoujihao=$_POST['shoujihao'];
            vendor('taobaoali.TopSdk');//引入第三方类库
            date_default_timezone_set('Asia/Shanghai'); 
            $appkey="23304840";
            $secret="57d27c01c6d3f9af602de646019c4e3b";
            $c = new \TopClient;
            $c->appkey = $appkey;
            $c->secretKey = $secret;
            $c->format='json';
            $req = new \AlibabaAliqinFcSmsNumSendRequest;
            $req->setExtend("123456");
            $req->setSmsType("normal");
            $req->setSmsFreeSignName("一起网");
            $rand=rand(100000,999999);
            $_SESSION['send_message']="$rand";
            $req->setSmsParam("{\"code\":\"$rand\",\"product\":\"一起网\",\"item\":\"一起网\"}");
            $req->setRecNum($shoujihao);
            $req->setSmsTemplateCode("SMS_4705353");
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


}
