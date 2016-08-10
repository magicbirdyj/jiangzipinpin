<?php
namespace Home\Model;
use Think\Model;

class  CartModel extends Model {
    protected $fields=array(
        'cart_id','user_id','goods_id','goods_name', 'goods_price', 'yuan_price','shop_name','shop_id','server_day','cat_name','goods_img',
        '_pk'=>'cart_id','_autoinc'=>true
    );
}
