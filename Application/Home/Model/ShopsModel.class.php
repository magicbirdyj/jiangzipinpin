<?php
namespace Home\Model;
use Think\Model;

class  ShopsModel extends Model {
    protected $fields=array(
        'shop_id','open_id','shop_name','password','zhifu_password','salt','created','head_url','address','sale_number',
       'tel','totle_amount','mentioned','last_login',
        '_pk'=>'shop_id','_autoinc'=>true
    );
}
