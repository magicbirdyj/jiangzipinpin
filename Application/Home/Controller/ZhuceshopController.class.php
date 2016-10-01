<?php

namespace Home\Controller;

use Home\Controller;

class ZhuceshopController extends FontEndController {


    public function index() {
        //先判断是否注册了商家
        $shopsmodel=D('Shops');
        $open_id=$_SESSION['huiyuan']['open_id'];
        $count=$shopsmodel->where("open_id='$open_id'")->count();
        if($count&&$count>0){
            $head_url=$shopsmodel->where("open_id='$open_id'")->getField('head_url');
            if($head_url!=''){
                header("location:". U("Member/index"));
                exit();
            }else{
                header("location:". U("Zhuceshop/zhuce4"));
                exit();
            }
        }
        
        
        $time=gettime();
        $_SESSION['zhuce1']=$time;
        $this->assign("time", $time);
        $this->display('index');
    }

    public function zhuce2() {
        if(!empty($_POST['hidden'])&&!empty($_SESSION['zhuce1'])){
            $hidden=$_POST['hidden'];
            if($hidden==$_SESSION['zhuce1']){
                $this->assign("dlm", $_POST['shoujihao']);
                $time2=gettime();
                $this->assign("time2", $time2);
                $this->display();
                unset($_SESSION['zhuce1']);
                $_SESSION['zhuce2']=$time2;
                $_SESSION['dlm']=$_POST['shoujihao'];
            }else{
                redirect(U('zhuceshop/index'));
            }
        }else{
            redirect(U('Zhuceshop/index'));

        }
    }
    

    public function zhuce3() {
         if(!empty($_POST['hidden'])&&!empty($_SESSION['zhuce2'])){
             if($_POST['shoujiyanzheng']!==$_SESSION['send_message']){
                 redirect(U('zhuce/index'),1,'手机验证码错误，请重新注册');
                 exit();
             }
            $shopsmodel=D('Shops');
            $hidden=$_POST['hidden'];
            $dlm=$_SESSION['dlm'];
            $hym=$_POST['huiyuanming'];
            $password=$_POST['shezhimima'];
            $salt=  create_char(6);
            $password_md5=  md5($password.$salt);
            if($hidden==$_SESSION['zhuce2']){
                $count=$shopsmodel->where("tel='{$dlm}'")->count();
                if(!is_shoujihao($dlm)||$count!=='0') {
                     $this->error('手机号错误或者已被注册，请重新注册',U('zhuce/index'),3);
                     exit();
                }
                $count1=$shopsmodel->where("shop_name='{$hym}'")->count();
                if(is_feifa($hym)||$count1!=='0'){
                    $this->error('店铺名含有非法字符或者已被注册，请重新注册',U('zhuce/index'),3);
                    exit();
                }
                $row=array(
                    'open_id'=>$_SESSION['huiyuan']['open_id'],
                    'tel'=>$dlm,
                    'shop_name'=>$hym,
                    'password'=>$password_md5,
                    'zhifu_password'=>$password_md5,//初始支付密码等于登录密码
                    'last_login'=>mktime(),
                    'salt'=>$salt,
                    'reg_time'=>  mktime()
                );
                if($_SERVER['REMOTE_ADDR']){
                    $row['last_ip']=$_SERVER['REMOTE_ADDR'];
                }
                $result=$shopsmodel->add($row);//注册信息写入数据库
                if($result){
                    $this->assign("tel", $dlm);
                    $this->assign("shop_name",$hym);
                    $this->redirect('Zhuceshop/zhuce4');
                    //$id=$usersmodel->where("user_name='{$hym}'")->getField('user_id');
                    //$smid=$usersmodel->where("user_name='{$hym}'")->getField('shopman_id');
                    unset($_SESSION['zhuce2']);
                }else{
                    $this->redirect('Zhuceshop/index',1,'注册失败，请重新注册');
                }
            }else{
               $this->redirect('Zhuceshop/index');
            }
        }else{
            $this->redirect('index/index');

        }
        
    }

    public function zhuce4() {
        //判断是否已经是商家
         $shopsmodel=D('Shops');
         $open_id=$_SESSION['huiyuan']['open_id'];
         $head_url=$shopsmodel->where("open_id='$open_id'")->getField('head_url');
        if($head_url!=''){
            header("location:". U("Member/hunlirenshangjiaxinxi"));
            exit();
        }
        $categorymodel=D('Category');
        $cate_0=$categorymodel->where("pid=0 and deleted=0")->field('cat_id,cat_name')->select();
        $this->assign('cate_0',$cate_0);
        foreach ($cate_0 as $key => $value) {
            $pid=$value['cat_id'];
            $cate_1[]=$categorymodel->where("pid=$pid and deleted=0")->field('cat_id,cat_name')->select();
        }
        $this->assign('cate_1',$cate_1);
        $this->display(zhuce4);
       
        
    }
    
    public function zhuce4_check(){
        //如果已经完善了资料  直接跳过
        $shopsmodel=D('Shops');
        $open_id=$_SESSION['huiyuan']['open_id'];
        $head_url=$shopsmodel->where("open_id='$open_id'")->getField('head_url');
        if($head_url!=''){
            header("location:". U("Member/shop_info"));
            exit();
        }
        //当有文件没有上传时，提示并返回
        if(empty($_POST['member_file_touxiang'])){
            $this->error('未选择上传头像');
        }
        
        
        //移动文件 并且改变url
        $today=substr($_POST['member_file_touxiang'],26,8);//获取到文件夹名  如20150101
        creat_file(UPLOAD.'image/member/'.$today);//创建文件夹（如果存在不会创建）
        rename($_POST['member_file_touxiang'], str_replace('Public/Uploads/image/temp', UPLOAD.'image/member',str_replace('thumb/','',$_POST['member_file_touxiang'])));//移动文件
        $head_url='/'.str_replace('Public/Uploads/image/temp', UPLOAD.'image/member',str_replace('thumb/','',$_POST['member_file_touxiang']));
 
        $shop_form=intval($_POST['radio_fuwuxingshi']);//获取服务形式
        //当服务形式为公司，至少必须上传3个图片文件，否则提示并且返回
       //if($serverform===2){
            //if(count($file_info)<3){
                //$this->error('有选现未选择文件');
                //exit();
            //}
        //}
        
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
       
        $shop_introduce=$_POST['shop_introduce'];//获取店铺介绍
       $default_cat_id=$_POST['cate_1'];//获取分类cat_id
        //如果没选择分类，提示并退出
        if($default_cat_id==='请选择分类'||empty($default_cat_id)){
            $this->error('未选择分类');
            exit();
        }
        
        
        
        //服务内容未选择时，提示并退出
        if(empty($qq)||empty($address)||empty($shop_introduce)){
            $this->error('有内容未填写');
            exit();
        }
       
        //任何文本框如果含有非法字符，提示并退出
        if(is_feifa($weixin)||is_feifa($address)||is_feifa($shop_introduce)){
            $this->error('有内容含有非法字符');
            exit();
        }

        $arr_address=array();
        $arr_address['province']=$province;
        $arr_address['city']=$city;
        $arr_address['county']=$county;
        $arr_address['address']=$address;
        //准备需要写进数据库的数组
        $row=array(
            'head_url'=>$head_url,
            'shop_form'=>$shop_form,
            'address'=>  serialize($arr_address),
            'qq'=>$qq,
            'default_cat_id'=>$default_cat_id,
            'shop_introduce'=>$shop_introduce,
            'last_login'=>  mktime()
        );
       
        //写入数据库
      
        $result=$shopsmodel->where("open_id='{$open_id}'")->save($row);
        if($result!==false){
            header("location:". U("Member/index"));
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
        );
        

            if($data['file_touxiang']!=='Public/Uploads/'){
                $index=strripos($data['file_touxiang'],"/");
                $img_url=substr($data['file_touxiang'],0,$index+1);
                $img_name=substr($data['file_touxiang'],$index+1);
                $this->thumb($img_url,$img_name, 'file_touxiang');//创建图片的缩略图
                $data['file_touxiang_thumb']=$img_url.'thumb/'.$img_name;
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
            $shopsmodel=D('Shops');
            $data=$shopsmodel->where("tel={$shoujihao}")->count();
            $this->ajaxReturn($data);
            exit();
       }elseif($_POST['check']=='huiyuanming'){
            $huiyuanming=$_POST['huiyuanming'];
            $shopsmodel=D('Shops');
            $data=$shopsmodel->where("shop_name='{$huiyuanming}'")->count();
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
            $appkey="23461151";
            $secret="32eff9693ac48fcee386923dc45e3f8c";
            $c = new \TopClient;
            $c->appkey = $appkey;
            $c->secretKey = $secret;
            $c->format='json';
            $req = new \AlibabaAliqinFcSmsNumSendRequest;
            $req->setExtend("123456");
            $req->setSmsType("normal");
            $req->setSmsFreeSignName("酱紫拼拼");
            $rand=rand(100000,999999);
            $_SESSION['send_message']="$rand";
            $req->setSmsParam("{\"name\":\"酱紫拼拼\",\"code\":\"$rand\"}");
            $req->setRecNum($shoujihao);
            $req->setSmsTemplateCode("SMS_15405215");
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
