<?php
namespace Admin\Model;
use Think\Model;

class  Admin_horseModel extends Model {
    protected $fields=array(
        'user_id','open_id','mobile_phone','user_name','card_id','email','password', 'ad_salt',  'add_time', 'last_login', 'last_ip',
        '_pk'=>'user_id','_autoinc'=>true
    );
}
