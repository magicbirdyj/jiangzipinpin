<?php
namespace Home\Model;
use Think\Model;

class  UsersModel extends Model {
    protected $fields=array(
        'shop_id','open_id','shop_name','shop_form','status','password','zhifu_password','salt','created','head_url','address','default_cat_id','shop_introduce','sale_number',
       'qq', 'tel','totle_amount','mentioned','last_login',
        '_pk'=>'shop_id','_autoinc'=>true
    );
}
