<?php
namespace Home\Model;
use Think\Model;

class  UsersModel extends Model {
    protected $fields=array(
        'user_id','email','open_id','user_name','password','sex','head_url', 'birthday',
       'reg_time', 'last_login', 'last_ip', 'user_rank', 'card_balance', 'address','default_address','salt',
        'is_validated','daijinquan','passwd_question','passwd_answer','url',
        '_pk'=>'user_id','_autoinc'=>true
    );
}
