<?php
namespace Home\Model;
use Think\Model;

class  UsersModel extends Model {
    protected $fields=array(
        'shop_id','shop_name','status','created','head_url', 'sale_number',
       'qq', 'tel',
        '_pk'=>'shop_id','_autoinc'=>true
    );
}
