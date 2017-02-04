<?php
namespace Home\Model;
use Think\Model;

class  GoodsModel extends Model {
    protected $fields=array(
        'goods_id','cat_id','cat_name', 'goods_name','goods_jianjie','yuan_price', 'price',
        'fanxian','wash_day', 'goods_img','buy_number','add_time','is_delete','daijinquan','is_hot','last_update',
        '_pk'=>'goods_id','_autoinc'=>true
    );
}
