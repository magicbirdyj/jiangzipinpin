<?php
namespace Home\Model;
use Think\Model;

class  OrderModel extends Model {
    protected $fields=array(
        'order_id','order_no','tuan_no','user_id', 'goods_id','identity','shop_name','goods_name','tuan_number','order_fahuo_day','zx_shuxing','buy_number','order_address', 'status',
        'pay_type', 'pay_status','shouhou_cause','shouhou_miaoshu','shouhou_img' ,'shouhou_iphone','pay_info', 'trade_no', 'choujiang','created', 'updated', 'deleted','price','daijinquan','dues','fanxian','appraise','score','pingfen',
        'appraise_img','cuihuo_time','kuaidi','_autoinc'=>true
    );
}
