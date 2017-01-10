<?php
namespace Home\Model;
use Think\Model;

class  Order_goodsModel extends Model {
    protected $fields=array(
        'rec_id','order_id','goods_id','user_id','goods_name','goods_number', 'market_price','goods_price', 'shop_id','is_gift','_autoinc'=>true
    );
}
