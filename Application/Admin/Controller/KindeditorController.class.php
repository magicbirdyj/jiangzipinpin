<?php

namespace Admin\Controller;
use Admin\Controller;

class KindeditorController extends FontEndController {
        public function editor_check(){  
        $file_info=$this->upload('image/temp/');
        //当有文件没有上传时，提示并返回
        if(count($file_info[1])<1){
            $this->error('请选择文件');
            exit();
        }
        if($file_info[0]==='error'){
            $data_1=array(
                'error' => 1
            );
            $this->ajaxReturn($data_1,'JSON');
            exit();

        }
        $file_url=UPLOAD.$file_info[1]['imgFile']['savepath'].$file_info[1]['imgFile']['savename'];
        //缩略图
        $index=strripos($file_url,"/");
        $img_url=substr($file_url,0,$index+1);
        $img_name=substr($file_url,$index+1); 
        $this->thumb($img_url,$img_name);//创建图片的缩略图
        
        
        $data_1=array(
            'error' => 0,
            'url' => '/'.$img_url.'thumb_'.$img_name
        );
        $this->ajaxReturn($data_1,'JSON');
        exit();
    }
    
    
    private function thumb($url,$name){
        $image = new \Think\Image(); 
        $image->open($url.$name);
        $image->thumb(760,3000)->save($url.'thumb_'.$name);
    }


}
