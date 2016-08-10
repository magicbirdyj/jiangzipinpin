<?php
namespace Admin\Model;
use Think\Model;

class  Admin_userModel extends Model {
    protected $fields=array(
        'user_id','mobile_phone','user_name','email','password', 'ad_salt',  'add_time', 'last_login', 'last_ip', 'action_list','nav_list','lang_type','suppliers_id','todolist','role_id',
        '_pk'=>'user_id','_autoinc'=>true
    );
}
