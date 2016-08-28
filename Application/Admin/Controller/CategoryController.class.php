<?php
namespace Admin\Controller;
use Admin\Controller;
class CategoryController extends FontEndController {
    public function fenlei() {
        $categorymodel=D('Category');
        $fenlei=$categorymodel->where("pid<>0 and deleted=0")->select();
        foreach ($fenlei as $key => &$value) {
            $pid=$value['pid'];
            $pid_info=$categorymodel->where("cat_id=$pid")->field('cat_name,cat_id')->find();
            $value['pid_name']=$pid_info['cat_name'];
            $value['pid_id']=$pid_info['cat_id'];
        }
        $this->assign('fenlei',$fenlei);
        $this->display();
    }
    public function tianjia(){
        C('TOKEN_ON',false);
        $categorymodel=D('Category');
        $yiji_fenlei=$categorymodel->where("pid=0 and deleted=0")->select();
        $this->assign('yiji_fenlei',$yiji_fenlei);
        $this->display();
    }
    
    public function tianjia_check() {
        $post=$_POST;
        $post['sort_order']='50';
        $post['keywords']=$post['cat_name'];
        $categorymodel=D('Category');
        //编辑核对
        if($post['cat_id']){
            $result=$categorymodel->save($post);
            if($result){
                $this->success('分类编辑成功!',U('Category/fenlei'));
            }
        }else{
            $result=$categorymodel->add($post);
            if($result){
                $this->success('分类添加成功!',U('Category/fenlei'));
            }
        }
        
    }
    
    
    public function fenlei_editor() {
        $cat_id=$_GET['cat_id'];
        if($cat_id==''){
            $this->error('分类id不存在');
        }
        $categorymodel=D('Category');
        $cat=$categorymodel->where("cat_id=$cat_id")->find();
        $this->assign('cat',$cat);
        
        $yiji_fenlei=$categorymodel->where("pid=0 and deleted=0")->select();
        $this->assign('yiji_fenlei',$yiji_fenlei);
        $this->display();
    }

    public function del_fenlei() {
        if($_GET['check']==='del_fenlei'){
            $cat_id=$_GET['cat_id'];
            $categorymodel=D('Category');
            $result=$categorymodel->where("cat_id=$cat_id")->save(array('deleted'=>1));
            $this->ajaxReturn($result);
        }else{
            $this->ajaxReturn(false);
        }
    }


    public function manger(){
        $categorymodel=D('Category');
        $data=$categorymodel->where("pid<>0 and deleted=0")->field('cat_name')->select();
        $this->assign('data',$data);
        //获取服务类型表单提交值
        if(!empty($_POST['server_content'])){
        //if(!empty($_POST['sc_hidden'])&&$_POST['sc_hidden']==="server_content"){
            $server_content=$_POST['server_content'];
            $this->assign($server_content,'selected="selected"');
            $this->assign('server_content',$server_content);
        }else{
            $server_content=$data[0]['cat_name'];
            $this->assign('server_content',$server_content);
        }
        
        $this->assign("cat_name",$server_content);
        $data_cat=$categorymodel->where("cat_name='$server_content'")->getField('shuxing');
        $arr_shuxing=unserialize($data_cat);//得到反序列化属性数组
        $this->assign("arr_shuxing",$arr_shuxing);//给模板里面的$arr_shuxing赋值
        $this->display();
    }
    
    
    public function check(){
        $cat_name=$_POST['cat_name'];
        $shuxing=$_POST['shuxing'];
        $shuxingzhi=$_POST['shuxingzhi'];

        $i=0;
        $new_arr=array();
        foreach ($shuxingzhi as  $value) {
           $key=$shuxing[$i];
           $new_arr[$key]=$value;
           $i++;
        }
        $str_shuxing=serialize($new_arr);
        $categorymodel=D('Category');
        $row=array(
            'shuxing'=>$str_shuxing
        );
        $result=$categorymodel->where("cat_name='$cat_name'")->save($row);
        if($result){
            $this->success('修改属性成功','manger');
        }else{
            $this->error('请您再改动后再确认修改');
        }
        
    }

    
    
    


}