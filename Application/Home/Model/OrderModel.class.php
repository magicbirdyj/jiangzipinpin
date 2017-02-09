<?php
namespace Home\Model;
use Think\Model;

class  OrderModel extends Model {
    protected $fields=array(
        'order_id','order_no','user_id','order_fahuo_day','order_address','appointment_time','remark', 'status','pay_type', 'pay_status','shouhou_cause','shouhou_miaoshu','shouhou_img' ,
        'shouhou_iphone','pay_info', 'trade_no', 'created', 'updated', 'deleted','price','daijinquan','dues','fanxian','appraise','score','pingfen',
        'appraise_img','cuihuo_time','kuaidi','fenxiang','fenxiang_dues','horseman_id','remind_horseman_time','shop_id','shop_name','shop_note','shop_img','remind_user_time',
        'deliver_address','deliver_time','deliver_horseman_id','deliver_remind_horseman','remind_pay_time','_autoinc'=>true
    );
}
