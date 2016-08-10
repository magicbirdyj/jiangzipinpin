<?php
namespace Admin\Controller;
use Admin\Controller;
class IndexController extends FontEndController {
    public function index(){
        //header ( " Expires: Mon, 26 Jul 1970 05:00:00 GMT " );
        //header ( " Last-Modified:" . gmdate ( " D, d M Y H:i:s " ). "GMT " );
        $this->display();
    }
    public function top(){
        $admin_hym=$_SESSION['admin_huiyuan'];
        $this->assign('admin_hym',$admin_hym);
        $this->display();
    }
    public function drag(){
        $this->display();
    }
    public function menu(){
        $this->display();
    }
    public function main(){
        $this->display();
    }
 



}